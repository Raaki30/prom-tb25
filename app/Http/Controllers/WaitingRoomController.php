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
            // Check if we've reached the maximum completed tickets
            $control = Control::first();
            $totalLimit = $control ? ($control->quantity_waiting ?? 100) : 100;
            $completedCount = WaitingRoom::where('status', 'completed')->count();
            
            // Only show sold out if we've reached the maximum COMPLETED tickets
            if ($completedCount >= $totalLimit) {
                return view('waiting.sold-out');
            }

            // Create a new waiting room entry with proper timestamps
            try {
                WaitingRoom::create([
                    'session_id' => $session_id,
                    'status' => 'waiting',
                    'entered_at' => Carbon::now(),
                    'expired_at' => Carbon::now()->addMinutes(30),
                ]);
            } catch (\Exception $e) {
                Log::error('Failed to create waiting room entry: ' . $e->getMessage());
                // Still show waiting page even on error
            }
        }

        // Calculate user's original position (for progress tracking)
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

            // Check if we've reached our limit of completed tickets
            $control = Control::first();
            $totalLimit = $control ? ($control->quantity_waiting ?? 100) : 100;
            $completedCount = WaitingRoom::where('status', 'completed')->count();

            // Only show sold out if completed = totalLimit
            if ($completedCount >= $totalLimit) {
                // Mark the current session's queue as abandoned - no tickets left
                WaitingRoom::where('session_id', $session_id)
                    ->whereIn('status', ['waiting', 'active'])
                    ->update(['status' => 'abandoned']);

                return response()->json([
                    'status' => 'sold',
                    'message' => 'Tickets are sold out.',
                    'session_id' => $session_id,
                ]);
            }

            // Calculate remaining tickets for display purposes
            $remainingTickets = $totalLimit - $completedCount;

            $waitingRoom = WaitingRoom::where('session_id', $session_id)->first();

            if (!$waitingRoom) {
                // Create a new record if one doesn't exist yet
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

            // Get current position and stats
            $queueStats = $this->getQueueStats($session_id);
            $position = $queueStats['position'];
            $total = $queueStats['total'];
            
            // Set maximum active users to 80% of total quantity
            $maxConcurrentActiveUsers = max(1, ceil($totalLimit * 0.8));
            
            // Improved estimated wait time calculation
            $averageProcessingTime = 3; // minutes per user
            
            if ($position > $maxConcurrentActiveUsers) {
                $estimatedTime = ceil(($position - $maxConcurrentActiveUsers) * $averageProcessingTime / $maxConcurrentActiveUsers);
            } else {
                $estimatedTime = 0;
            }

            // Check if user can be activated based on available slots (80% rule)
            $activeCount = WaitingRoom::where('status', 'active')->count();
            
            if ($activeCount < $maxConcurrentActiveUsers && $position <= $maxConcurrentActiveUsers && $waitingRoom->status !== 'active') {
                // Only activate if completed count hasn't reached the limit yet
                if ($completedCount < $totalLimit) {
                    // User can be set to active
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
                        'remainingTickets' => $remainingTickets,
                        'expiresAt' => $waitingRoom->expired_at->timestamp,
                    ]);
                }
            }

            return response()->json([
                'status' => $waitingRoom->status,
                'position' => $position,
                'total' => $total,
                'estimatedTime' => $estimatedTime,
                'session_id' => $session_id,
                'remainingTickets' => $remainingTickets,
                'maxActive' => $maxConcurrentActiveUsers,
                'activeCount' => $activeCount,
            ]);
        } catch (\Exception $e) {
            Log::error('Status check error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error', 
                'message' => 'An unexpected error occurred.'
            ], 500);
        }
    }
    
    protected function calculateUserPosition($session_id)
    {
        try {
            $records = WaitingRoom::whereNotIn('status', ['completed', 'abandoned'])
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
    
    protected function getRemainingTicketCount()
    {
        try {
            // Cache ticket count for 5 seconds to reduce database load during high traffic
            return Cache::remember('remaining_tickets', 5, function() {
                // Get quantity from control table with fallback value
                $control = Control::first();
                $totalLimit = $control ? ($control->quantity_waiting ?? 100) : 100;
                
                // Count only completed purchases against the limit
                $completedCount = WaitingRoom::where('status', 'completed')->count();
                
                return max(0, $totalLimit - $completedCount);
            });
        } catch (\Exception $e) {
            Log::error('Ticket count error: ' . $e->getMessage());
            return 100; // Default value on error
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
            // Continue execution even if cleanup fails
        }
    }
    
    public function markAsAbandoned(Request $request)
    {
        try {
            $session_id = $request->session_id ?? Session::getId();
            
            WaitingRoom::where('session_id', $session_id)
                ->whereIn('status', ['waiting', 'active'])
                ->update(['status' => 'abandoned']);
                
            // Clear the cache to update ticket counts
            Cache::forget('remaining_tickets');
                
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
            
            // Clear the cache
            Cache::forget('remaining_tickets');
            
            return redirect()->route('dashboard.control')->with('success', 'Waiting room database has been reset successfully.');
        } catch (\Exception $e) {
            Log::error('Reset waiting room error: ' . $e->getMessage());
            return redirect()->route('dashboard.control')->with('error', 'Failed to reset waiting room: ' . $e->getMessage());
        }
    }
}
