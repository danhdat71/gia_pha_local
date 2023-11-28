<?php

namespace App\Http\Middleware;

use App\Constants\UserType;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RootAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $rootAdmin = Auth::guard('root_admin');

        if ($rootAdmin->user() && $rootAdmin->check()) {
            return $next($request);
        }

        return redirect()->route('root_admin.login_view');
    }
}
