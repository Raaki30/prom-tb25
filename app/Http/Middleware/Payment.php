<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Control;

class Payment
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek jika token CSRF tidak ada atau tidak valid
        if (!$request->has('_token') || !$request->session()->token() || $request->input('_token') !== $request->session()->token()) {
            return redirect('/');
        }

        $status = Control::where('is_active', true)->first();
        if (!$status) {
            return redirect('/')->with('error', 'Pembelian tiket sedang ditutup');
        }

        return $next($request);
    }
}
