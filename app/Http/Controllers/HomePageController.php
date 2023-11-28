<?php

namespace App\Http\Controllers;

use App\Constants\UserType;
use App\Constants\Trial;
use App\Http\Requests\UserRegisterRequest;
use App\Jobs\UserRegisterJob;
use App\Mail\RegisterUserMail;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\FamilyTree;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class HomePageController extends Controller
{

    public function index()
    {
        return view('home_page.main');
    }

    public function register(UserRegisterRequest $request)
    {
        $password = Str::random(8);
        $birthday = explode("-", $request->birthday);

        // Create family tree
        $familyTree = new FamilyTree;
        $familyTree->title = $request->title;
        $familyTree->expired_at_trial = Trial::getTrialExpired();
        $familyTree->max_member_trial = Trial::DEFAULT_TRIAL_MEMBER;
        $familyTree->is_approve_trial = Trial::TRIAL;
        $familyTree->save();
        // Create user
        $userRegister = new User;
        $userRegister->full_name = $request->full_name;
        $userRegister->email = $request->email;
        $userRegister->born_year = $birthday[0];
        $userRegister->born_month = $birthday[1];
        $userRegister->born_day = $birthday[2];
        $userRegister->gender = $request->gender;
        $userRegister->type = UserType::FAMILY_ADMIN;
        $userRegister->family_tree_id = $familyTree->id;
        $userRegister->password = Hash::make($password);
        $userRegister->is_main = true;
        $userRegister->save();
        // Create user info
        $userInfo = new UserInfo;
        $userInfo->user_id = $userRegister->id;
        $userInfo->save();

        // Send mail invite
        dispatch(new UserRegisterJob([
            'email' => $request->email,
            'password' => $password,
        ]));

        return $this->responseJson($userRegister);
    }
}
