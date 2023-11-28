<?php

namespace App\Http\Controllers\FamilyAdmin;

use App\Constants\CurrentPage;

use App\Constants\UserType;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Traits\FileTrait;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FamilyAdminAuthController extends Controller
{
    use FileTrait;

    public function loginView()
    {
        if (Auth::guard('family_member')->check()) {
            return redirect()->route('family_admin.dashboard');
        }
        return view('family_admin.login');
    }

    public function login(LoginRequest $request)
    {
        $rememberMe = $request['remember_me'] ? true : false;
        $user = User::where('email', $request['login_id'])->orWhere('cccd_number', $request['login_id'])->first();
        if ($user && in_array($user->type, [UserType::FAMILY_ADMIN, UserType::FAMILY_SUB_ADMIN, UserType::SECRETARY])) {
            if (Hash::check($request['password'], $user['password'])) {
                Auth::guard('family_member')->login($user, $rememberMe);
                return redirect()->route('family_admin.dashboard');
            }
        }

        return redirect()->back()->withErrors(['message' => 'Sai tên đăng nhập hoặc mật khẩu !']);
    }

    // public function resetPasswordView($token)
    // {
    //     $decrypted = Crypt::decrypt($token);
    //     $user = User::where('email', $decrypted['email'])->firstOrFail();
    //     $existToken = Password::tokenExists($user, $decrypted['token']);
        
    //     if (!$existToken) {
    //         abort(403, 'Token hết hạn');
    //     }
        
    //     return view('global.reset_password', [
    //         'token_reset' => $token
    //     ]);
    // }

    // public function confirmResetPassword(ConfirmResetPasswordRequest $request)
    // {
    //     $decrypted = Crypt::decrypt($request->token_reset);
    //     $user = User::where('email', $decrypted['email'])->firstOrFail();
    //     $existToken = Password::tokenExists($user, $decrypted['token']);

    //     if (!$existToken) {
    //         abort(403, 'Token hết hạn');
    //     }

    //     Password::deleteToken($user);
    //     $user->password = Hash::make($request->password);
    //     if ($user->enable_status == EnableStatus::UNACTIVE){
    //         $user->enable_status = EnableStatus::ENABLE;
    //     }
    //     $user->save();

    //     Auth::attempt([
    //         'email' => $decrypted['email'],
    //         'password' => $request->password
    //     ]);

    //     return redirect()->route('dashboard');
    // }

    public function mypageView()
    {
        $user = Auth::guard('family_member')->user();
        return view('family_admin.my_page', [
            'user' => $user,
            'current_page' => CurrentPage::MYPAGE,
        ]);
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $user = Auth::guard('family_member')->user();
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->back()->with('message', 'Cập nhật mật khẩu thành công !');
    }

    public function logout()
    {
        Auth::guard('family_member')->logout();
        return redirect()->route('family_admin.login_view');
    }

    public function storeDeviceToken(Request $request)
    {
        $user = Auth::guard('family_member')->user();
        $user->userTokens()->firstOrCreate([
            'device_token' => $request->fcm_device_token,
        ]);

        return $this->successMessage('ok!');
    }
}
