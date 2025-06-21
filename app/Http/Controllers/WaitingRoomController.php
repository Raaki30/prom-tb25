<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WaitingRoom;
use Illuminate\Support\Facades\Session;
use App\Models\Control;
use Carbon\Carbon;

class WaitingRoomController extends Controller
{
    public function show(){
        $session_id = Session::getId();
        
        // Check if ticket limit (25) has been reached
        $completedCount = WaitingRoom::whereIn('status', ['completed'])->count();
        $limitquantity = Control::where('jenis_tiket', 'general')->value('quantity_waiting');
        $remainingTickets = max(0, $limitquantity - $completedCount);

        // If limitquantity is set and > 0, enforce the limit
        if ($limitquantity > 0 && $completedCount >= $limitquantity) {
            return view('waiting.show', [
                'status' => 'sold'
            ]);
        }

        // Create a new waiting room entry
        WaitingRoom::create([
            'session_id' => $session_id,
            'status' => 'waiting',
            'expired_at' => Carbon::now()->addMinutes(30), // Add default expiration
        ]);

        // Hitung posisi user saat ini (1-based), abaikan yang status 'completed' dan 'abandoned'
        $originPosition = WaitingRoom::whereNotIn('status', ['completed', 'abandoned'])
            ->orderBy('id')
            ->get()
            ->search(function ($item) use ($session_id) {
            return $item->session_id === $session_id;
            });

        $originPosition = $originPosition !== false ? $originPosition + 1 : null;
        
        WaitingRoom::whereIn('status', ['abandoned'])->delete();
        // Get all waiting/active users ordered by expired_at
        $waitingRooms = WaitingRoom::whereIn('status', ['waiting', 'active'])
            ->orderBy('expired_at')
            ->get();

        // Find the current user's position in the queue
        $position = $waitingRooms->search(function ($item) use ($session_id) {
            return $item->session_id === $session_id;
        });

        $estimatedTime = 0;
        Session::put('action', 'hold');
        Session::put('origin_position', $originPosition);
        return view('waiting.show', [
            'status' => 'valid',
            'waitingRooms' => $waitingRooms,
            'position' => $position + 1, // +1 to make it 1-based index
            'estimatedTime' => $estimatedTime,
            'session_id' => $session_id,
            'remainingTickets' => $remainingTickets,
        ]);
    }

    public function checkStatus()
    {
        $session_id = Session::getId();

        // Update expired users to 'abandoned'
        $expiredRooms = WaitingRoom::whereIn('status', ['waiting', 'active'])
            ->where('expired_at', '<', Carbon::now())
            ->get();

        foreach ($expiredRooms as $room) {
            $room->status = 'abandoned';
            $room->save();
        }

        // Check ticket availability
        $limitquantity = Control::where('jenis_tiket', 'general')->value('quantity_waiting');
        $completedCount = WaitingRoom::where('status', 'completed')->count();
        $remainingTickets = max(0, $limitquantity - $completedCount);

        if ($limitquantity > 0 && $completedCount >= $limitquantity) {
            // Mark the current session's queue as abandoned
            WaitingRoom::where('session_id', $session_id)
            ->whereIn('status', ['waiting', 'active'])
            ->update(['status' => 'abandoned']);

            return response()->json([
            'status' => 'sold',
            'message' => 'Tickets are sold out.',
            'session_id' => $session_id,
            ]);
        }

        $waitingRoom = WaitingRoom::where('session_id', $session_id)->first();

        if ($waitingRoom) {
            // Get all waiting/active users ordered by expired_at
            $waitingRooms = WaitingRoom::whereIn('status', ['waiting', 'active'])
                ->orderBy('expired_at')
                ->get();

            // Count how many users are currently 'active'
            $activeCount = $waitingRooms->where('status', 'active')->count();

            // Position is 1-based: 1 means next in line after actives
            $position = $activeCount + 1;

            // Estimasi waktu tunggu: (position - 1) * 3 menit
            $averageWait = 3; // menit
            if ($position > 1) {
                $estimatedTime = ($position - 1) * $averageWait;
            } else {
                $estimatedTime = 0;
            }

            // Changed from 3 to 5 for active users limit
            if ($activeCount < 5 && $position == 1 && $waitingRoom->status !== 'active') {
                // User can be set to active
                $waitingRoom->status = 'active';
                $waitingRoom->entered_at = Carbon::now();
                $waitingRoom->expired_at = Carbon::now()->addMinutes(10); // Set expired_at 10 menit dari sekarang
                $waitingRoom->save();
                $status = 'active';
                Session::put('action', 'pass');
                Session::put('expired_at', $waitingRoom->expired_at);
                $estimatedTime = 0;
            } else {
                $status = $waitingRoom->status;
            }

            return response()->json([
                'status' => $status,
                'position' => $position,
                'estimatedTime' => $estimatedTime,
                'session_id' => $session_id,
                'remainingTickets' => $remainingTickets,
            ]);
        }

        return response()->json(['status' => 'error', 'message' => 'Waiting room not found.'], 404);
    }
    
    public function markAsAbandoned(Request $request)
    {
        $session_id = $request->session_id ?? Session::getId();
        
        WaitingRoom::where('session_id', $session_id)
            ->whereIn('status', ['waiting', 'active'])
            ->update(['status' => 'abandoned']);
            
        return response()->json(['status' => 'success']);
    }
    
    public function resetWaitingRoom()
    {
        // Remove all records from the waiting_room table
        WaitingRoom::truncate();
        
        return redirect()->route('dashboard.control')->with('success', 'Waiting room database has been reset successfully.');
    }
}
