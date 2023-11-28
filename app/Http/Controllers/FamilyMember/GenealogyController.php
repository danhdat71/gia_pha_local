<?php

namespace App\Http\Controllers\FamilyMember;

use App\Http\Controllers\Controller;
use App\Models\FamilyTree;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use App\Constants\FamilyMemberPage;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class GenealogyController extends Controller
{
    public $genealogyColumns = [
        'users.id',
        'users.full_name',
        'users.role_name',
        'users.born_day',
        'users.born_month',
        'users.born_year',
        'users.avatar',
        'users.pids',
        'users.fid',
        'users.mid',
        'users.is_main',
        'user_infos.leave_day',
        'user_infos.leave_month',
        'user_infos.leave_year',
    ];

    public function genealogy()
    {
        $agent = new Agent();
        if ($agent->isMobile()) {
            return $this->genealogyMobile();
        }

        return $this->genealogyDesktop();
    }

    public function genealogyMobile()
    {
        $authUser = Auth::guard('family_member')->user();
        $familyTreeId = $authUser->family_tree_id;
        $familyTree = FamilyTree::find($familyTreeId);
        $members = User::selectRaw('*, users.id as node_user_id')->where('family_tree_id', $authUser['family_tree_id'])->with([
            'marriages.spouse',
        ])->first()->toArray();
        $pageTitle = "Gia Phả";

        return view('family_member.mobile.genealogy', [
            'members' => [$members],
            'pageTitle' => $pageTitle,
            'family_tree' => $familyTree,
            'currentPage' => FamilyMemberPage::GENEALOGY,
            'link_back' => url()->previous(),
        ]);
    }

    public function genealogyDesktop()
    {
        $pageTitle = "Gia Phả";
        $familyAdminAuth = Auth::guard('family_member')->user();
        $familyTree = FamilyTree::where('id', $familyAdminAuth['family_tree_id'])->first();
        $members = User::where('family_tree_id', $familyAdminAuth['family_tree_id'])->with([
            'marriages.children',
            'marriages.spouse',
        ])->first()->toArray();

        return view('family_member.desktop.genealogy', [
            'members' => [$members],
            'family_tree' => $familyTree,
            'pageTitle' => $pageTitle,
            'currentPage' => FamilyMemberPage::GENEALOGY,
        ]);
    }

    function loadMore(Request $request)
    {
        $authUser = Auth::guard('family_member')->user();
        $parentMarriageId = $request->parent_marriage_id;

        $members = User::selectRaw('*, users.id as node_user_id')->where('family_tree_id', $authUser['family_tree_id'])->with([
            'marriages.spouse',
        ])->whereHas('parentMarriage', function($q) use($parentMarriageId) {
            $q->where('id', $parentMarriageId);
        })->get()->toArray();

        return $this->responseJson([$members]);
    }

    public function detailUser(Request $request)
    {
        $agent = new Agent();
        $authUser = Auth::guard('family_member')->user();
        $user = User::with(['userInfo'])
            ->where('family_tree_id', $authUser->family_tree_id)
            ->where('users.id', $request->id)
            ->firstOrFail();
        
        $pageTitle = "Gia Phả | ". $user->full_name;

        $returnData = [
            'user' => $user,
            'pageTitle' => $pageTitle,
            'agent' => $agent,
            'currentPage' => FamilyMemberPage::GENEALOGY,
        ];

        if ($agent->isMobile()) {
            return view('family_member.mobile.detail_user', $returnData);
        }
        return view('family_member.desktop.detail_user', $returnData);
    }
}
