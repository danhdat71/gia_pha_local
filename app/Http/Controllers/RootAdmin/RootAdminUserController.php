<?php

namespace App\Http\Controllers\RootAdmin;

use App\Constants\CurrentPage;
use App\Constants\Paginate;
use App\Constants\Trial;
use App\Constants\UserType;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\RootAdminRegisterUserRequest;
use App\Http\Requests\RootAdminUpdateUserRequest;
use App\Jobs\UserRegisterJob;
use App\Mail\RegisterUserMail;
use App\Models\FamilyTree;
use App\Models\User;
use App\Models\UserInfo;
use App\Models\UserRegister;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class RootAdminUserController extends Controller
{
    public function registerView()
    {
        return view('root_admin.user_register', [
            'current_page' => CurrentPage::USER_REGISTER,
        ]);
    }

    public function registerUser(RootAdminRegisterUserRequest $request)
    {
        $authAdmin = Auth::guard('root_admin')->user();
        $familyTree = new FamilyTree;
        $familyTree->title = $request->title;
        $familyTree->root_admin_id = $authAdmin->id;
        $familyTree->domain = $request->domain;
        $familyTree->template_id = $request->template_id;
        $familyTree->is_approve_trial = Trial::TRIAL;
        $familyTree->expired_at_trial = Carbon::now()->addMonths($request->trial_month);
        $familyTree->max_member_trial = $request->trial_member;
        $familyTree->save();

        $user = new User;
        $user->full_name = $request->full_name;
        $user->born_day = $request->born_day;
        $user->born_month = $request->born_month;
        $user->born_year = $request->born_year;
        $user->email = $request->email;
        $user->type = UserType::FAMILY_ADMIN;
        $user->gender = $request->gender;
        $user->family_tree_id = $familyTree->id;
        $user->is_main = true;
        $user->password = Hash::make($request->pass);
        $user->save();

        $userInfo = new UserInfo;
        $userInfo->user_id = $user->id;
        $userInfo->save();

        // Send notification
        dispatch(new UserRegisterJob([
            'email' => $user->email,
            'password' => $request->pass,
        ]));

        return redirect()->back()->with(['message' => 'Đăng ký thành công !']);
    }

    public function users(Request $request)
    {
        $inputed = $request->only('keyword');
        $users = User::when(!empty($request->keyword), function($q) use($request) {
                $q->where('users.full_name', 'like', "%".$request['keyword']."%");
                $q->orWhere('users.email', 'like', "%".$request['keyword']."%");
            })
            ->where('type', UserType::FAMILY_ADMIN)
            ->with(['familyTree'])
            ->paginate(Paginate::USER);

        return view('root_admin.users', [
            'users' => $users,
            'current_page' => CurrentPage::USER,
            'inputed' => $inputed,
        ]);
    }

    public function editUser($id)
    {
        $selectColumn = [
            'users.id',
            'users.full_name',
            'users.born_day',
            'users.born_month',
            'users.born_year',
            'users.gender',
            'users.email',
            'family_trees.title',
            'family_trees.template_id',
            'family_trees.domain',
            'family_trees.is_approve_trial',
            'family_trees.expired_at_trial',
            'family_trees.max_member_trial',
            'family_trees.created_at as start_at',
        ];
        $user = User::where('users.id', $id)
            ->join('family_trees', 'family_trees.id', 'users.family_tree_id')
            ->select($selectColumn)
            ->first();
        
        return view('root_admin.edit_user', [
            'user' => $user,
            'current_page' => CurrentPage::USER,
        ]);
    }

    public function approveTrialView($familyTreeId)
    {
        $familyTree = FamilyTree::findOrFail($familyTreeId);
        return view('root_admin.approve_trial', [
            'current_page' => CurrentPage::USER,
            'family_tree' => $familyTree,
        ]);
    }

    public function approveTrial($familyTreeId)
    {
        $familyTree = FamilyTree::find($familyTreeId);
        $familyTree->is_approve_trial = Trial::APPROVED;
        $familyTree->save();
        
        return redirect()->back();
    }

    public function updateUser(RootAdminUpdateUserRequest $request)
    {
        $user = User::find($request->id);
        $familyTree = FamilyTree::find($user->family_tree_id);
        $user->full_name = $request->full_name;
        $user->born_day = $request->born_day;
        $user->born_month = $request->born_month;
        $user->born_year = $request->born_year;
        $user->gender = $request->gender;
        $familyTree->title = $request->title;
        $familyTree->domain = $request->domain;
        $familyTree->template_id = $request->template_id;

        if ($familyTree->is_approve_trial == Trial::TRIAL) {
            $familyTree->expired_at_trial = Carbon::parse($familyTree->created_at)->addMonths($request->trial_month);
            $familyTree->max_member_trial = $request->max_member_trial;
        }

        if ($request->pass != "") {
            $user->password = Hash::make($request->pass);
        }

        $user->save();
        $familyTree->save();

        // Send notification
        dispatch(new UserRegisterJob([
            'email' => $user->email,
            'password' => $request->pass,
        ]));

        return redirect()->route('root_admin.users');
    }
}
