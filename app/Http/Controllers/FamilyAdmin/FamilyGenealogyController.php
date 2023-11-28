<?php

namespace App\Http\Controllers\FamilyAdmin;

use App\Constants\CurrentPage;
use App\Constants\UserType;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateFamilyMemberRequest;
use App\Http\Requests\UpdateFamilyMemberRequest;
use App\Mail\RegisterUserMail;
use App\Models\Marriage;
use App\Models\User;
use App\Models\FamilyTree;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Traits\FileTrait;
use App\Constants\Relation;
use App\Constants\Gender;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class FamilyGenealogyController extends Controller
{
    use FileTrait;

    public function __construct()
    {
        $this->middleware('check-trial-member-num')->only(['addUserView', 'addUser']);
    }

    public function genealogy()
    {
        $familyAdminAuth = Auth::guard('family_member')->user();
        $familyTree = FamilyTree::where('id', $familyAdminAuth['family_tree_id'])->first();
        $members = User::where('family_tree_id', $familyAdminAuth['family_tree_id'])->with([
            'marriages.children',
            'marriages.spouse',
        ])->first()->toArray();

        return view('family_admin.genealogy', [
            'members' => [$members],
            'family_tree' => $familyTree,
            'current_page' => CurrentPage::GENEALOGY,
        ]);
    }
    
    public function addUserView($fromMemberId)
    {
        $fromMember = User::where('id', $fromMemberId)->withCount(['spouses'])->firstOrFail();
        return view('family_admin.add_user', [
            'fromMember' => $fromMember,
            'current_page' => CurrentPage::GENEALOGY,
        ]);
    }

    public function addUser(Request $request)
    {
        $validate = new CreateFamilyMemberRequest();
        $validator = Validator::make(
            $request->all(),
            $validate->rules(),
            $validate->messages(),
            $validate->attributes()
        );
        
        // Keep avatar on validate err
        if (!$validator->errors()->has('avatar') && $request->has('avatar')) {
            $avatarName = $this->storeAvatar($request->file('avatar'));
        } else {
            $avatarName = $request->avatar_name;
        }

        // Keep cccd_image_before on validate err
        if (!$validator->errors()->has('cccd_image_before') && $request->has('cccd_image_before')) {
            $cccdImageBeforeName = $this->storeCCCD($request->file('cccd_image_before'));
        } else {
            $cccdImageBeforeName = $request->cccd_image_before_name;
        }

        // Keep cccd_image_after on validate err
        if (!$validator->errors()->has('cccd_image_after') && $request->has('cccd_image_after')) {
            $cccdImageAfterName = $this->storeCCCD($request->file('cccd_image_after'));
        } else {
            $cccdImageAfterName = $request->cccd_image_after_name;
        }

        // Keep rest images
        $restImages = null;
        $restImagesTemp = [];
        if (!$validator->errors()->has('rest_images') && $request->has('rest_images')) {
            foreach ($request->file('rest_images') as $restImage) {
                $restImageName = $this->storeRestImage($restImage);
                array_push($restImagesTemp, $restImageName);
                $restImages = implode(',', $restImagesTemp);
            }
        } else {
            $restImages = $request->rest_image_names;
        }

        // Keep certificate images
        $certImages = null;
        $certImagesTemp = [];
        if (!$validator->errors()->has('cert_images') && $request->has('cert_images')) {
            foreach ($request->file('cert_images') as $restImage) {
                $certImageName = $this->storeCertImage($restImage);
                array_push($certImagesTemp, $certImageName);
                $certImages = implode(',', $certImagesTemp);
            }
        } else {
            $certImages = $request->cert_image_names;
        }

        // Keep 360 degree video on validate err
        if (!$validator->errors()->has('video_360_url') && $request->has('video_360_url')) {
            $videoName = $this->storeRestVideo360($request->file('video_360_url'));
        } else {
            $videoName = $request->video_name;
        }

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with([
                    'avatar_name' => $avatarName,
                    'cccd_image_before_name' => $cccdImageBeforeName,
                    'cccd_image_after_name' => $cccdImageAfterName,
                    'rest_images' => $restImages,
                    'cert_images' => $certImages,
                    'video_name' => $videoName,
                ]);
        }

        $relation = $request->relation;
        $current = User::find($request->from_member_id);
        $passwordRandom = Str::random(8);

        if ($relation == Relation::CHILD) {
            $parentMarriage = $current->marriages->first();
            $dataChild = [
                'full_name' => $request->fullname,
                'role_name' => $request->role_name,
                'born_day' => $request->born_day,
                'born_month' => $request->born_month,
                'born_year' => $request->born_year,
                'address' => $request->address,
                'domicile' => $request->domicile,
                'phone' => $request->phone,
                'email' => $request->email,
                'gender' => $request->gender,
                'position_index' => $request->position_index,
                'avatar' => $avatarName,
                'cccd_number' => $request->cccd_number,
                'password' => Hash::make($passwordRandom),
                'family_tree_id' => $current->family_tree_id,
                'type' => UserType::NORMAL,
                'is_main' => true,
                'parent_marriage_id' => $parentMarriage->id,
            ];

            $dataChildOther = [
                'cccd_image_before' => $cccdImageBeforeName,
                'cccd_image_after' => $cccdImageAfterName,
                'story' => $request->story,
                'job' => $request->job,
                'position' => $request->position,
                'organization' => $request->organization,
                'leave_day' => $request->leave_day,
                'leave_month' => $request->leave_month,
                'leave_year' => $request->leave_year,
                'lat' => $request->lat,
                'long' => $request->long,
                'rest_images' => $restImages,
                'cert_images' => $certImages,
                'rest_place' => $request->rest_place,
                'video_360_url' => $videoName,
            ];

            $createdChild = User::create($dataChild);
            $createdChild->userInfo()->create($dataChildOther);
        }
        else if ($relation == Relation::COUPLE) {
            $dataCouple = [
                'full_name' => $request->fullname,
                'role_name' => $request->role_name,
                'born_day' => $request->born_day,
                'born_month' => $request->born_month,
                'born_year' => $request->born_year,
                'address' => $request->address,
                'domicile' => $request->domicile,
                'phone' => $request->phone,
                'email' => $request->email,
                'gender' => $current->gender == Gender::MALE ? Gender::FEMALE : Gender::MALE,
                'avatar' => $avatarName,
                'cccd_number' => $request->cccd_number,
                'password' => Hash::make($passwordRandom),
                'family_tree_id' => $current->family_tree_id,
                'type' => UserType::NORMAL,
                'main_person_id' => $current->id,
                'is_main' => 0,
            ];

            $dataCoupleOther = [
                'cccd_image_before' => $cccdImageBeforeName,
                'cccd_image_after' => $cccdImageAfterName,
                'story' => $request->story,
                'job' => $request->job,
                'position' => $request->position,
                'organization' => $request->organization,
                'leave_day' => $request->leave_day,
                'leave_month' => $request->leave_month,
                'leave_year' => $request->leave_year,
                'lat' => $request->lat,
                'long' => $request->long,
                'rest_images' => $restImages,
                'cert_images' => $certImages,
                'rest_place' => $request->rest_place,
                'video_360_url' => $videoName,
            ];

            $createdCouple = User::create($dataCouple);
            $createdCouple->userInfo()->create($dataCoupleOther);

            $dataMarriage = [
                'main_person_id' => $current->id,
                'spouse_id' => $createdCouple->id,
            ];
            Marriage::create($dataMarriage);
        }

        Mail::to($request->email)->send(new RegisterUserMail($request->email, $passwordRandom, env('APP_URL')));

        return redirect()->route('family_admin.genealogy');
    }

    public function editUserView($id)
    {
        $member = User::whereId($id)->with('userInfo')->first();
        return view('family_admin.edit_user', [
            'member' => $member,
            'current_page' => CurrentPage::GENEALOGY,
        ]);
    }

    public function editUser(Request $request)
    {
        $member = User::find($request->id);
        $validate = new UpdateFamilyMemberRequest();
        $validator = Validator::make(
            $request->all(),
            $validate->rules(),
            $validate->messages(),
            $validate->attributes()
        );
        if (!$validator->errors()->has('avatar') && $request->has('avatar')) {
            $avatar = $this->storeAvatar($request->file('avatar'));
            $member->avatar = $avatar;
        } else {
            $avatar = $request->avatar_name;
            $member->avatar = $avatar;
        }

        if ($request->has('cccd_image_before')) {
            $member->userInfo->cccd_image_before = $this->storeCCCD($request->file('cccd_image_before'));
        }

        if ($request->has('cccd_image_after')) {
            $member->userInfo->cccd_image_after = $this->storeCCCD($request->file('cccd_image_after'));
        }

        if ($validator->fails()) {
            return $this->errorValidate($validator->errors());
        }

        if (!$validator->errors()->has('video_360_url') && $request->has('video_360_url')) {
            $video = $this->storeRestVideo360($request->file('video_360_url'));
            $member->userInfo->video_360_url = $video;
        } else {
            $video = $request->video_name;
            $member->userInfo->video_360_url = $video;
        }

        // Handle store rest image
        $restImages = $request->rest_image_names;
        $restImagesTemp = [];
        if (!$validator->errors()->has('rest_images') && $request->has('rest_images')) {
            foreach ($request->file('rest_images') as $restImage) {
                $restImageName = $this->storeRestImage($restImage);
                array_push($restImagesTemp, $restImageName);
            }
            if ($restImages != "") {
                $restImages = $restImages . "," . implode(',', $restImagesTemp);
            } else {
                $restImages = implode(',', $restImagesTemp);
            }
        }

        // Handle rest_image delete
        if ($request->del_rest_image_names != "") {
            $restImagesArr = explode(",", $restImages);
            $restImageDeleteArr = explode(",", $request->del_rest_image_names);
            $result = array_diff($restImagesArr, $restImageDeleteArr);
            $restImages = implode(",", $result);
        }

        // Handle store cert image
        $certImages = $request->cert_image_names;
        $certImagesTemp = [];
        if (!$validator->errors()->has('cert_images') && $request->has('cert_images')) {
            foreach ($request->file('cert_images') as $certImage) {
                $certImageName = $this->storeCertImage($certImage);
                array_push($certImagesTemp, $certImageName);
            }
            if ($certImages != "") {
                $certImages = $certImages . "," . implode(',', $certImagesTemp);
            } else {
                $certImages = implode(',', $certImagesTemp);
            }
        }

        // Handle cert_image delete
        if ($request->del_cert_image_names != "") {
            $certImagesArr = explode(",", $certImages);
            $certImageDeleteArr = explode(",", $request->del_cert_image_names);
            $result = array_diff($certImagesArr, $certImageDeleteArr);
            $certImages = implode(",", $result);
        }

        // Handle delete avatar
        

        if ($member->position_index != "") {
            $member->position_index = $request->position_index;
        }

        $member->full_name = $request->full_name;
        $member->cccd_number = $request->cccd_number;
        $member->role_name = $request->role_name;
        $member->born_day = $request->born_day;
        $member->born_month = $request->born_month;
        $member->born_year = $request->born_year;
        $member->address = $request->address;
        $member->domicile = $request->domicile;
        $member->phone = $request->phone;
        $member->phone = $request->phone;
        $member->userInfo->story = $request->story;
        $member->userInfo->job = $request->job;
        $member->userInfo->position = $request->position;
        $member->userInfo->organization = $request->organization;
        $member->userInfo->leave_day = $request->leave_day;
        $member->userInfo->leave_month = $request->leave_month;
        $member->userInfo->leave_year = $request->leave_year;
        $member->userInfo->rest_place = $request->rest_place;
        $member->userInfo->lat = $request->lat;
        $member->userInfo->long = $request->long;
        $member->userInfo->rest_images = $restImages;
        $member->userInfo->cert_images = $certImages;
        $member->save();
        $member->userInfo->save();

        return redirect()->back()->with(['message' => 'Cập nhật thông tin thành công !']);
    }

    public function detailUser($id)
    {
        $member = User::whereId($id)->with(['userInfo', 'video360degrees'])->firstOrFail();
        $parent = $member->parentMarriage ? $member->parentMarriage->mainPerson->first() : null;
        $child = $member->marriages->first() ? $member->marriages->first()->marriageChildrens : collect();
        $couple = $member->is_main ? $member->spouses : collect([$member->mainSpouse]);
        

        return view('family_admin.detail_member', [
            'member' => $member,
            'parent' => $parent,
            'child' => $child,
            'couple' => $couple,
            'current_page' => CurrentPage::GENEALOGY,
        ]);
    }

    public function deleteUser(Request $request)
    {
        $member = User::find($request->id);

        // Delete marriage when delete spouse
        if ($member->is_main != true) {
            Marriage::where('spouse_id', $member->id)->delete();
        }

        $member->userInfo()->delete();
        $member->delete();

        return redirect()->back();
    }
}
