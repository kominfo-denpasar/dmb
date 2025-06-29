<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\LogtoService;

class VerifyLogtoSession
{
    /**
     * Middleware to verify Logto session.
     * This middleware checks if the user is authenticated and if the session is still valid with Logto server.
     * If the session is invalid, it logs out the user and redirects to the login page.
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $logto = app(LogtoService::class);

            if (! $logto->validateSessionWithLogtoServer()) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect('/login')->with('error', 'Sesi Anda telah berakhir.');
            }
        }

        return $next($request);
    }
}