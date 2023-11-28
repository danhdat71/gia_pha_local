<?php

namespace App\Http\Controllers\FamilyAdmin;

use App\Constants\CurrentPage;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateContactInfoRequest;
use App\Http\Requests\UpdateFamilyTreeInfoRequest;
use App\Models\ContactInfo;
use App\Models\FamilyTree;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ContactInfoController extends Controller
{
    public function index()
    {
        $familyTreeId = Auth::guard('family_member')->user()->family_tree_id;
        $info = ContactInfo::where('family_tree_id', $familyTreeId)->first();
        $familyTreeInfo = FamilyTree::find($familyTreeId);

        return view('family_admin.contact_info', [
            'info' => $info,
            'familyTreeInfo' => $familyTreeInfo,
            'current_page' => CurrentPage::CONTACT_INFO,
        ]);
    }

    public function updateContactInfo(UpdateContactInfoRequest $request)
    {
        $familyTreeId = Auth::guard('family_member')->user()->family_tree_id;
        $info = ContactInfo::firstOrNew(['family_tree_id' => $familyTreeId]);
        $info->phone = $request->phone;
        $info->email = $request->email;
        $info->contact_person = $request->contact_person;
        $info->position = $request->position;
        $info->address = $request->address;
        $info->save();

        return redirect()->back()->with('message_1', 'Cập nhật thành công !');
    }

    public function updateFamilyTreeInfo(UpdateFamilyTreeInfoRequest $request)
    {
        $familyTreeId = Auth::guard('family_member')->user()->family_tree_id;
        $familyTreeInfo = FamilyTree::find($familyTreeId);

        // Store audio
        if ($request->has('audio_link')) {
            $audioFile = $request->file('audio_link');
            $familyTreeInfo->audio_link = Storage::disk('public_all')->put('audio', $audioFile);
        }
        // Remove image
        if ($request->is_del_audio_link == 1) {
            $familyTreeInfo->audio_link = null;
        }
        // Update data
        $familyTreeInfo->title = $request->title;
        $familyTreeInfo->description = $request->description;
        $familyTreeInfo->save();

        return redirect()->back()->with('message_2', 'Cập nhật thành công !');
    }
}
