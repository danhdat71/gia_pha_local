<?php

namespace App\Http\Middleware;

use App\Constants\UserType;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FamilyAdminMiddleware
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
        $user = Auth::guard('family_member')->user();
        if ($user) {
            if (in_array($user->type, [UserType::FAMILY_ADMIN, UserType::FAMILY_SUB_ADMIN, UserType::SECRETARY])) {
                return $next($request);
            }
            if ($user->type == UserType::NORMAL) {
                return redirect()->route('family_member.about');
            }
        }

        return redirect()->route('family_admin.login_view');
    }
}
