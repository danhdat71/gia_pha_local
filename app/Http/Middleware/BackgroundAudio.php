<?php

namespace App\Http\Middleware;

use App\Models\FamilyTree;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BackgroundAudio
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
        view()->share('audioLink', $familyTree->audio_link ?? "");
        return $next($request);
    }
}
