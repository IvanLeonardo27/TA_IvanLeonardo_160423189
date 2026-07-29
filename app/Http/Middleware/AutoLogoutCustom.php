<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AutoLogoutCustom
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $lastActivity = session('last_activity_timestamp');
            $timeoutMinutes = 20; // 20 Menit AFK

            if ($lastActivity && (time() - $lastActivity > ($timeoutMinutes * 60))) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')->with('warning', 'Sesi Anda telah berakhir karena tidak ada aktivitas selama 20 menit.');
            }

            session(['last_activity_timestamp' => time()]);
        }

        return $next($request);
    }
}
