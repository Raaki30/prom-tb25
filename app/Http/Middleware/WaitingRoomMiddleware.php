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

    // Jika sistem waiting room tidak aktif, lanjutkan tanpa cek
    if (!$control) {
        return $next($request);
    }

    $action = Session::get('action');

    if (is_null($action) || $action === 'hold') {
        return redirect()->route('waiting.show');
    }

    if ($action === 'pass') {
        $sessionId = Session::getId();
        $waitingRoom = \App\Models\WaitingRoom::where('session_id', $sessionId)->first();

        if (!$waitingRoom) {
            return redirect()->route('waiting.show');
        }

        if (in_array($waitingRoom->status, ['abandoned', 'completed'])) {
            Session::forget('action');
            Session::forget('expired_at');
            Session::forget('origin_position');
            return redirect()->route('waiting.show');
        }

        $now = \Carbon\Carbon::now();
        if ($waitingRoom->expired_at && $waitingRoom->expired_at->lt($now)) {
            return redirect()->route('waiting.show');
        }
    }

    Session::forget('origin_position');
    return $next($request);
}

}
