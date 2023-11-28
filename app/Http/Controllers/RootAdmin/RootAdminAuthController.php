<?php

namespace App\Http\Controllers\RootAdmin;

use App\Constants\CurrentPage;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\RootAdminChangePasswordRequest;
use App\Models\RootAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RootAdminAuthController extends Controller
{
    public function loginView()
    {
        if (Auth::guard('root_admin')->check()) {
            return redirect()->route('root_admin.users');
        }
        return view('root_admin.login');
    }

    public function login(Request $request)
    {
        $rememberMe = $request['remember_me'] ? true : false;
        $user = RootAdmin::where('username', $request['login_id'])->first();
        if ($user && Hash::check($request['password'], $user['password'])) {
            Auth::guard('root_admin')->login($user, $rememberMe);
            return redirect()->route('root_admin.users');
        }

        return redirect()->back()->withErrors(['message' => 'Sai tên đăng nhập hoặc mật khẩu !']);
    }

    public function mypageView()
    {
        $user = Auth::guard('root_admin')->user();
        return view('root_admin.my_page', [
            'user' => $user,
            'current_page' => CurrentPage::MYPAGE,
        ]);
    }

    public function changePassword(RootAdminChangePasswordRequest $request)
    {
        $user = Auth::guard('root_admin')->user();
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->back()->with('message', 'Cập nhật mật khẩu thành công !');
    }

    public function logout()
    {
        Auth::guard('root_admin')->logout();
        return redirect()->route('root_admin.login_view');
    }
}
