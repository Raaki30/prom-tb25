<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\WaitingRoom;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Http\Controllers\WaitingRoomController;
use App\Models\Control;
use Illuminate\Support\Facades\Cache;



class WaitingRoomMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
{
    $control = Control::where('iswaitingroomactive', true)->first();

    // If waiting room is not active, proceed normally
    if (!$control) {
        return $next($request);
    }

    $action = Session::get('action');
    $session_id = Session::getId();

    // If no action is set, redirect to waiting room
    if (is_null($action) || $action === 'hold') {
        return redirect()->route('waiting.show');
    }

    // If user has 'pass' action (allowed to proceed)
    if ($action === 'pass') {
        $waitingRoom = WaitingRoom::where('session_id', $session_id)->first();

        // If the session doesn't exist in waiting room, send back to waiting room
        if (!$waitingRoom) {
            Session::forget('action');
            return redirect()->route('waiting.show');
        }

        // If status is abandoned or completed, reset and send back to waiting room
        if (in_array($waitingRoom->status, ['abandoned', 'completed'])) {
            Session::forget('action');
            Session::forget('expired_at');
            Session::forget('origin_position');
            return redirect()->route('waiting.show');
        }

        // Check if session is expired
        $now = Carbon::now();
        $expired_at = Session::get('expired_at');
        
        if ($expired_at && Carbon::parse($expired_at)->lt($now)) {
            // Mark as abandoned since it's expired
            $waitingRoom->status = 'abandoned';
            $waitingRoom->save();
            
            // Clear session data
            Session::forget('action');
            Session::forget('expired_at');
            Session::forget('origin_position');
            
            // Clear cache
            Cache::forget('remaining_tickets');
            
            return redirect()->route('waiting.show')
                ->with('error', 'Your session has expired. You have been placed back in the queue.');
        }
        
        // Renew expiration time on activity - prevent unfair timeouts while active user is shopping
        $waitingRoom->expired_at = Carbon::now()->addMinutes(10);
        $waitingRoom->save();
        Session::put('expired_at', $waitingRoom->expired_at);
    }

    // Clear origin position as it's no longer needed
    Session::forget('origin_position');
    
    return $next($request);
}

}
