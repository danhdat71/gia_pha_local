<?php

namespace App\Http\Controllers\FamilyMember;

use App\Constants\FamilyMemberPage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Auth;
use App\Models\ContactInfo;

class ContactController extends Controller
{
    public function contactInfo()
    {
        $pageTitle = "Giới Thiệu";
        $agent = new Agent();
        $authUser = Auth::guard('family_member')->user();
        $contactInfo = ContactInfo::where('family_tree_id', $authUser->family_tree_id)->first();

        $returnData = [
            'agent' => $agent,
            'contactInfo' => $contactInfo,
            'pageTitle' => $pageTitle,
            'currentPage' => FamilyMemberPage::PROFILE,
        ];

        if ($agent->isMobile()) {
            return view('family_member.mobile.contact_info', $returnData);
        }
        $returnData['currentPage'] = FamilyMemberPage::CONTACT;
        return view('family_member.desktop.contact_info', $returnData);
    }
}
