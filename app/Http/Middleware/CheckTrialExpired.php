<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\FamilyTree;
use App\Constants\Trial;

class CheckTrialExpired
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
        $familyTree = FamilyTree::find($user->family_tree_id);

        if ($familyTree->is_approve_trial == Trial::TRIAL) {
            $now = date('Y-m-d H:i:s');
            $expiredAt = $familyTree->expired_at_trial;

            if (strtotime($now) >= strtotime($expiredAt)) {
                abort(403, "Đã hết hạn dùng thử");
            }
        }

        return $next($request);
    }
}
