<?php

namespace App\Http\Controllers\FamilyMember;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use App\Models\FamilyTree;
use App\Constants\FamilyMemberPage;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AboutController extends Controller
{
    public function index(Request $request)
    {
        $pageTitle = "Giới Thiệu";
        $agent = new Agent();
        $authUser = Auth::guard('family_member')->user();
        $familyTreeInfo = FamilyTree::where('id', $authUser->family_tree_id)->first();
        $leaveMembers = User::join('user_infos', 'user_infos.user_id', '=', 'users.id')
            ->where('family_tree_id', $authUser->family_tree_id)
            ->where(function($q){
                $q->whereNotNull('user_infos.leave_day');
                $q->orWhereNotNull('user_infos.leave_month');
                $q->orWhereNotNull('user_infos.leave_year');
            })
            ->get();
        $returnData = [
            'agent' => $agent,
            'leaveMembers' => $leaveMembers,
            'familyTreeInfo' => $familyTreeInfo,
            'pageTitle' => $pageTitle,
            'currentPage' => FamilyMemberPage::ABOUT,
        ];

        if ($agent->isMobile()) {
            return view('family_member.mobile.about', $returnData);
        }

        return view('family_member.desktop.about', $returnData);
    }

    public function panoramaView($id)
    {
        $agent = new Agent();
        $user = User::where('users.id', $id)
            ->join('user_infos', 'user_infos.user_id', '=', 'users.id')
            ->with(['video360degrees', 'vr3D.vr3Dbuttons'])
            ->firstOrFail();

        $returnData = [
            'user' => $user,
            'pageTitle' => 'An nghỉ ' . $user->full_name,
            'currentPage' => FamilyMemberPage::ABOUT,
        ];

        if ($agent->isMobile()) {
            return view('family_member.mobile.preview_3d', $returnData);
        }

        return view('family_member.desktop.preview_3d', $returnData);
    }
}
