<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WaitingRoom;
use Illuminate\Support\Facades\Session;
use App\Models\Control;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WaitingRoomController extends Controller
{
    public function show(){
        $session_id = Session::getId();
        
        // Check if this session already exists in the waiting room
        $existingRoom = WaitingRoom::where('session_id', $session_id)->first();
        if ($existingRoom) {
            // Update last activity timestamp
            $existingRoom->touch();
        } else {
            // ONLY check if all tickets have been COMPLETED (purchased)
            // NOT including active users, so people can join the waiting room
            $control = Control::first();
            $saleLimit = $control ? ($control->sale_quantity ?? 100) : 100;
            $completedCount = WaitingRoom::where('status', 'completed')->count();
            
            // Only show sold out if all tickets have actually been purchased
            if ($completedCount >= $saleLimit) {
                return view('waiting.sold-out');
            }

            // Create a new waiting room entry
            try {
                WaitingRoom::create([
                    'session_id' => $session_id,
                    'status' => 'waiting',
                    'entered_at' => Carbon::now(),
                    'expired_at' => Carbon::now()->addMinutes(30),
                ]);
            } catch (\Exception $e) {
                Log::error('Failed to create waiting room entry: ' . $e->getMessage());
            }
        }

        // Calculate user's original position
        $originPosition = $this->calculateUserPosition($session_id);
        Session::put('origin_position', $originPosition);
        
        // Clean up abandoned sessions
        try {
            $this->cleanupAbandonedSessions();
        } catch (\Exception $e) {
            Log::error('Failed to cleanup sessions: ' . $e->getMessage());
        }
        
        // Set action to hold (waiting)
        Session::put('action', 'hold');
        
        return view('waiting.show');
    }

    public function checkStatus()
    {
        try {
            $session_id = Session::getId();

            // Update expired users to 'abandoned'
            $this->cleanupAbandonedSessions();

            // Get control values
            $control = Control::first();
            $waitingLimit = $control ? ($control->quantity_waiting ?? 2) : 2; // Active user limit
            $saleLimit = $control ? ($control->sale_quantity ?? 100) : 100;   // Total ticket limit
            
            // Count completed purchases and active reservations
            $completedCount = WaitingRoom::where('status', 'completed')->count();
            $activeCount = WaitingRoom::where('status', 'active')->count();
            
            // Calculate potential available sales slots
            $availableSalesSlots = $saleLimit - $completedCount;
            
            // If all tickets have been PURCHASED (not just reserved), show sold out
            if ($availableSalesSlots <= 0) {
                // Mark the current session as abandoned
                WaitingRoom::where('session_id', $session_id)
                    ->where('status', 'waiting')
                    ->update(['status' => 'abandoned']);

                return response()->json([
                    'status' => 'sold',
                    'message' => 'All tickets have been sold.',
                    'session_id' => $session_id,
                ]);
            }

            // Get or create the waiting room record
            $waitingRoom = WaitingRoom::where('session_id', $session_id)->first();
            if (!$waitingRoom) {
                try {
                    $waitingRoom = WaitingRoom::create([
                        'session_id' => $session_id,
                        'status' => 'waiting',
                        'entered_at' => Carbon::now(),
                        'expired_at' => Carbon::now()->addMinutes(30),
                    ]);
                } catch (\Exception $e) {
                    Log::error('Failed to create waiting room entry: ' . $e->getMessage());
                    return response()->json([
                        'status' => 'error', 
                        'message' => 'Unable to create waiting room entry.'
                    ], 500);
                }
            }

            // Get queue position
            $queueStats = $this->getQueueStats($session_id);
            $position = $queueStats['position'];
            $total = $queueStats['total'];
            
            // Calculate estimated wait time
            $averageProcessingTime = 3; // minutes per user
            $estimatedTime = $position <= $waitingLimit ? 0 : 
                ceil(($position - $waitingLimit) * $averageProcessingTime / $waitingLimit);

            // THIS IS THE KEY ACTIVATION CHECK:
            // 1. Ensure we don't exceed the concurrent active user limit
            // 2. Ensure we can never oversell tickets
            // 3. Only activate users who are at the front of the queue
            $canActivate = 
                // User is currently waiting
                $waitingRoom->status === 'waiting' && 
                // There's room in the active user limit
                $activeCount < $waitingLimit &&
                // User is near front of queue 
                $position <= 3 &&
                // THIS CHECK PREVENTS OVERSELLING:
                ($completedCount + $activeCount) < $saleLimit &&
                // There are still tickets available
                $availableSalesSlots > 0;
            
            if ($canActivate) {
                // Activate the user
                $waitingRoom->status = 'active';
                $waitingRoom->entered_at = Carbon::now();
                $waitingRoom->expired_at = Carbon::now()->addMinutes(10);
                $waitingRoom->save();

                Session::put('action', 'pass');
                Session::put('expired_at', $waitingRoom->expired_at);
                
                return response()->json([
                    'status' => 'active',
                    'position' => 0,
                    'total' => $total,
                    'estimatedTime' => 0,
                    'session_id' => $session_id,
                    'remainingTickets' => $availableSalesSlots - 1, // -1 for this reservation
                    'expiresAt' => $waitingRoom->expired_at->timestamp,
                    'debug' => [
                        'activeCount' => $activeCount + 1,  // +1 for this user
                        'completedCount' => $completedCount,
                        'waitingLimit' => $waitingLimit,
                        'saleLimit' => $saleLimit
                    ]
                ]);
            }

            // User needs to wait in queue
            return response()->json([
                'status' => $waitingRoom->status,
                'position' => $position,
                'total' => $total,
                'estimatedTime' => $estimatedTime,
                'session_id' => $session_id,
                'remainingTickets' => $availableSalesSlots,
                'debug' => [
                    'completed' => $completedCount,
                    'active' => $activeCount,
                    'waitingLimit' => $waitingLimit,
                    'saleLimit' => $saleLimit,
                    'availableSlots' => $saleLimit - ($completedCount + $activeCount)
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Status check error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error', 
                'message' => 'An unexpected error occurred: ' . $e->getMessage()
            ], 500);
        }
    }
    
    protected function calculateUserPosition($session_id)
    {
        try {
            $records = WaitingRoom::whereIn('status', ['waiting', 'active'])
                ->orderBy('entered_at')
                ->get();
                
            if ($records->isEmpty()) {
                return 1; // First in queue if no records
            }
            
            $position = $records->search(function ($item) use ($session_id) {
                return $item->session_id === $session_id;
            });
            
            return $position !== false ? $position + 1 : count($records) + 1;
        } catch (\Exception $e) {
            Log::error('Position calculation error: ' . $e->getMessage());
            return 1; // Default to position 1 on error
        }
    }
    
    protected function getQueueStats($session_id)
    {
        try {
            // Get all waiting/active users ordered by entered_at (FIFO)
            $waitingRooms = WaitingRoom::whereIn('status', ['waiting', 'active'])
                ->orderBy('entered_at')
                ->get();
                
            // Total users in queue
            $total = $waitingRooms->count();
            
            // Find position (1-based index)
            $position = $waitingRooms->search(function ($item) use ($session_id) {
                return $item->session_id === $session_id;
            });
            
            return [
                'position' => $position !== false ? $position + 1 : $total,
                'total' => $total
            ];
        } catch (\Exception $e) {
            Log::error('Queue stats error: ' . $e->getMessage());
            return [
                'position' => 1,
                'total' => 1
            ];
        }
    }
    
    protected function cleanupAbandonedSessions()
    {
        try {
            // Mark expired sessions as abandoned
            WaitingRoom::whereIn('status', ['waiting', 'active'])
                ->where('expired_at', '<', Carbon::now())
                ->update(['status' => 'abandoned']);
                
            // Physically remove truly abandoned sessions that are older than 1 hour
            WaitingRoom::where('status', 'abandoned')
                ->where('updated_at', '<', Carbon::now()->subHour())
                ->delete();
        } catch (\Exception $e) {
            Log::error('Cleanup error: ' . $e->getMessage());
        }
    }
    
    public function markAsAbandoned(Request $request)
    {
        try {
            $session_id = $request->session_id ?? Session::getId();
            
            WaitingRoom::where('session_id', $session_id)
                ->whereIn('status', ['waiting', 'active'])
                ->update(['status' => 'abandoned']);
                
            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            Log::error('Mark abandoned error: ' . $e->getMessage());
            return response()->json(['status' => 'error'], 500);
        }
    }
    
    public function resetWaitingRoom()
    {
        try {
            // Remove all records from the waiting_room table
            WaitingRoom::truncate();
            
            return redirect()->route('dashboard.control')->with('success', 'Waiting room database has been reset successfully.');
        } catch (\Exception $e) {
            Log::error('Reset waiting room error: ' . $e->getMessage());
            return redirect()->route('dashboard.control')->with('error', 'Failed to reset waiting room: ' . $e->getMessage());
        }
    }
}
