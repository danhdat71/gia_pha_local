<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\FamilyTree;
use App\Models\User;
use App\Constants\Trial;

class CheckTrialMemberNum
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
            $currentFamilyMemberNum = User::where('family_tree_id', $user->family_tree_id)->count();
            $maxFamilyTreeNum = $familyTree->max_member_trial;

            if ($currentFamilyMemberNum >= $maxFamilyTreeNum) {
                abort(403, "Quá số thành viên được dùng thử !");
            }
        }

        return $next($request);
    }
}
