<?php

namespace App\Http\Controllers\FamilyMember;

use App\Constants\FamilyMemberPage;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddCertImageItemRequest;
use App\Http\Requests\AddRestImageItemRequest;
use App\Http\Requests\UserUpdateProfileRequest;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Traits\FileTrait;
use Illuminate\Support\Facades\Validator;
use Jenssegers\Agent\Agent;

class ProfileController extends Controller
{
    use FileTrait;
    protected $modelUser = null;
    protected $modelUserInfo = null;
    protected $request = null;
    public function index()
    {
        return view('family_member.mobile.profile_index', [
            'pageTitle' => 'Cá nhân',
            'currentPage' => FamilyMemberPage::PROFILE
        ]);
    }

    public function mypage()
    {
        $myInfo = Auth::guard('family_member')->user();
        $myInfo = User::where('id', $myInfo->id)->with(['userInfo'])->first();
        $agent = new Agent();

        $returnData = [
            'myInfo' => $myInfo,
            'pageTitle' => 'Cá nhân',
            'currentPage' => FamilyMemberPage::PROFILE,
        ];

        if ($agent->isMobile()) {
            return view('family_member.mobile.mypage', $returnData);
        }
        
        return view('family_member.desktop.mypage', $returnData);
    }

    public function removeCertImage(Request $request)
    {
        $myInfo = Auth::guard('family_member')->user();
        $myInfo = UserInfo::where('user_id', $myInfo->id)->first();
        $certImages = explode(',', $myInfo->cert_images);
        $certImages = array_diff( $certImages, [$request->cert_image] );
        if (count($certImages) < 1) {
            $myInfo->cert_images = null;
        } else {
            $myInfo->cert_images = implode(',', $certImages);
        }
        $myInfo->save();

        return $this->successMessage('Cập nhật thành công !');
    }

    public function addCertImage(AddCertImageItemRequest $request)
    {
        $certImages = [];
        $myInfo = Auth::guard('family_member')->user();
        $myInfo = UserInfo::where('user_id', $myInfo->id)->first();
        if ($myInfo->cert_images != "") {
            $certImages = explode(',', $myInfo->cert_images);
        }
        $certImageName = $this->storeCertImage($request->file('cert_image'));
        array_push($certImages, $certImageName);
        $myInfo->cert_images = implode(',', $certImages);
        $myInfo->save();

        return $this->successMessage([
            'cert_image' => $certImageName,
        ]);
    }

    public function removeCCCDImage(Request $request)
    {
        $myInfo = Auth::guard('family_member')->user();
        $myInfo = UserInfo::where('user_id', $myInfo->id)->first();

        if ($request->field == 'cccd_image_before') {
            $myInfo->cccd_image_before = null;
        }
        if ($request->field == 'cccd_image_after') {
            $myInfo->cccd_image_after = null;
        }
        $myInfo->save();

        return $this->successMessage('Cập nhật thành công !');

    }

    public function removeRestImage(Request $request)
    {
        $myInfo = Auth::guard('family_member')->user();
        $myInfo = UserInfo::where('user_id', $myInfo->id)->first();
        $restImages = explode(',', $myInfo->rest_images);
        $restImages = array_diff( $restImages, [$request->rest_image] );
        if (count($restImages) < 1) {
            $myInfo->rest_images = null;
        } else {
            $myInfo->rest_images = implode(',', $restImages);
        }
        $myInfo->save();

        return $this->successMessage('Cập nhật thành công !');
    }

    public function addRestImage(AddRestImageItemRequest $request)
    {
        $restImages = [];
        $myInfo = Auth::guard('family_member')->user();
        $myInfo = UserInfo::where('user_id', $myInfo->id)->first();
        if ($myInfo->rest_images != "") {
            $restImages = explode(',', $myInfo->rest_images);
        }
        $restImageName = $this->storeRestImage($request->file('rest_image'));
        array_push($restImages, $restImageName);
        $myInfo->rest_images = implode(',', $restImages);
        $myInfo->save();

        return $this->successMessage([
            'rest_image' => $restImageName,
        ]);
    }

    public function updateAllowNullAttr(array $attributes)
    {
        $userAttribute = $this->modelUser->fillable;
        $userInfoAttribute = $this->modelUserInfo->fillable;
        foreach ($attributes as $attr) {
            if (in_array($attr, $userAttribute)) {
                if ($this->request->has($attr) && $this->request->{$attr} == "") {
                    $this->modelUser->{$attr} = null;
                } else if ($this->request->has($attr) && $this->request->{$attr} != "") {
                    $this->modelUser->{$attr} = $this->request->{$attr};
                }
            }

            if (in_array($attr, $userInfoAttribute)) {
                if ($this->request->has($attr) && $this->request->{$attr} == "") {
                    $this->modelUserInfo->{$attr} = null;
                } else if ($this->request->has($attr) && $this->request->{$attr} != "") {
                    $this->modelUserInfo->{$attr} = $this->request->{$attr};
                }
            }
        }

        $this->modelUser->save();
        $this->modelUserInfo->save();
    }

    public function updateAttr(array $attributes)
    {
        $userAttribute = $this->modelUser->fillable;
        $userInfoAttribute = $this->modelUserInfo->fillable;
        foreach ($attributes as $attr) {
            if (in_array($attr, $userAttribute)) {
                if ($this->request->has($attr) && $this->request->{$attr} != "") {
                    $this->modelUser->{$attr} = $this->request->{$attr};
                }
            }

            if (in_array($attr, $userInfoAttribute)) {
                if ($this->request->has($attr) && $this->request->{$attr} != "") {
                    $this->modelUserInfo->{$attr} = $this->request->{$attr};
                }
            }
        }

        $this->modelUser->save();
        $this->modelUserInfo->save();
    }

    public function userUpdateProfile(Request $request)
    {
        $validate = new UserUpdateProfileRequest();
        $validator = Validator::make(
            $request->all(),
            $validate->rules(),
            $validate->messages(),
            $validate->attributes()
        );
        if ($validator->fails()) {
            return $this->errorValidate($validator->errors());
        }

        $this->request = $request;
        $this->modelUser = Auth::guard('family_member')->user();
        $this->modelUserInfo = UserInfo::where('user_id', $this->modelUser->id)->first();
        
        $this->updateAllowNullAttr([
            'role_name',
            'leaveday',
            'phone',
            'address',
            'domicile',
            'cccd_number',
            'job',
            'position',
            'organization',
            'rest_place',
            'born_day',
            'born_month',
            'born_year',
        ]);

        $this->updateAttr([
            'full_name',
            'birthday',
        ]);

        if ($this->request->has('avatar')) {
            $avatar = $this->storeAvatar($this->request->file('avatar'));
            $this->modelUser->avatar = $avatar;
            $this->modelUser->save();
        }

        if ($this->request->has('cccd_image_before')) {
            $cccdImageBefore = $this->storeCCCD($this->request->file('cccd_image_before'));
            $this->modelUserInfo->cccd_image_before = $cccdImageBefore;
            $this->modelUserInfo->save();
        }

        if ($this->request->has('cccd_image_after')) {
            $cccdImageAfter = $this->storeCCCD($this->request->file('cccd_image_after'));
            $this->modelUserInfo->cccd_image_after = $cccdImageAfter;
            $this->modelUserInfo->save();
        }

        // Handle delete avatar
        if ($this->request->has('del_avatar')) {
            $this->modelUser->avatar = null;
            $this->modelUser->save();
        }

        return $this->successMessage('Thành công !');
    }
}
