<?php

namespace App\Http\Middleware;

use App\Constants\UserType;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomCKFinderAuth
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
        $authFamilyAdmin = Auth::guard('family_member')->user();
        if (in_array($authFamilyAdmin->type, [UserType::FAMILY_ADMIN, UserType::FAMILY_SUB_ADMIN, UserType::SECRETARY])) {
            $configCkfinder = [
                'ckfinder.authentication' => function(){return true;},
                'ckfinder.backends.default.baseUrl' => env('APP_URL', '').'/userfiles/users/'.$authFamilyAdmin->family_tree_id.'/',
                'ckfinder.backends.default.root' => public_path('/userfiles/users/'.$authFamilyAdmin->family_tree_id.'/'),
            ];
        }
        config($configCkfinder);
        return $next($request);
    }
}
