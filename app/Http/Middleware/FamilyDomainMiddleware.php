<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\FamilyTree;

class FamilyDomainMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $domain = $request->getHost();
        $user = Auth::guard('family_member')->user();

        if ($user) {
            $familyTree = FamilyTree::find($user->family_tree_id);
            view()->share('templateId', $familyTree->template_id);
        } else {
            $familyTree = FamilyTree::where('domain', $domain)->first();
            view()->share('templateId', $familyTree->template_id ?? 1);
        }

        return $next($request);
    }
}
