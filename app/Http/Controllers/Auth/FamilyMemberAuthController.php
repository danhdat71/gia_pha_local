<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ConfirmResetPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\SendRequestResetPasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Constants\UserType;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;

use App\Models\Person;
use App\Models\Spouse;
use App\Models\Marriage;

class FamilyMemberAuthController extends Controller
{
    public function test()
    {
        // Lấy toàn bộ data cây guia phả
        // $people = Person::with([
        //     'marriages.children',
        //     'marriages.spouse',
        // ])->first()->toArray();

        // Lấy danh sách các con dựa vào id marriages của node cha khi được click
        // Sử dụng cho mobile loadmore
        // $child = Person::with([
        //     'marriages.spouse',
        // ])->whereHas('parentMarriage', function($q) {
        //     $q->where('id', 1);
        // })->get()->toArray();
        // dd($child);
        

        return view('test');
    }
    public function loginView()
    {
        if (Auth::guard('family_member')->check()) {
            return redirect()->route('family_admin.dashboard');
        }
        return view('global.login');
    }

    public function login(LoginRequest $request)
    {
        $rememberMe = $request['remember_me'] ? true : false;
        $user = User::where('email', $request['login_id'])->orWhere('cccd_number', $request['login_id'])->first();
        if ($user && Hash::check($request['password'], $user['password'])) {
            Auth::guard('family_member')->login($user, $rememberMe);

            // Store device token]
            if ($request->user_token) {
                $user->userTokens()->firstOrCreate([
                    'device_token' => $request->user_token,
                ]);
            }

            if (in_array($user->type, [UserType::FAMILY_ADMIN, UserType::FAMILY_SUB_ADMIN, UserType::SECRETARY])) {
                return redirect()->route('family_admin.dashboard');
            } else {
                return redirect()->route('family_member.about');
            }
        }

        return redirect()->back()->withErrors(['message' => 'Sai tên đăng nhập hoặc mật khẩu !']);
    }

    public function logout()
    {
        Auth::guard('family_member')->logout();
        return redirect()->route('family_admin.login_view');
    }

    public function resetPasswordRequestView()
    {
        return view('global.reset_password_view');
    }

    public function sendResetPassword(SendRequestResetPasswordRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        // Create token and send invite
        $token = Password::broker('family_members')->createToken($user);
        $token = Crypt::encrypt([
            'token' => $token,
            'email' => $request->email,
        ]);
        Mail::send('mails.reset_password', ['token' => $token], function ($message) use($request) {
            $message->to($request->email);
            $message->subject('Thư mời tham gia');
        });

        return redirect()->back()->with(['message' => 'Đã gửi yêu cầu']);
    }

    public function resetPasswordView($token)
    {
        $decrypted = Crypt::decrypt($token);
        $user = User::where('email', $decrypted['email'])->firstOrFail();
        $existToken = Password::broker('family_members')->tokenExists($user, $decrypted['token']);
        
        if (!$existToken) {
            abort(403, 'Token hết hạn');
        }
        
        return view('global.reset_password', [
            'token_reset' => $token
        ]);
    }

    public function confirmResetPassword(ConfirmResetPasswordRequest $request)
    {
        $decrypted = Crypt::decrypt($request->token_reset);
        $user = User::where('email', $decrypted['email'])->firstOrFail();
        $existToken = Password::broker('family_members')->tokenExists($user, $decrypted['token']);

        if (!$existToken) {
            abort(403, 'Token hết hạn');
        }

        Password::broker('family_members')->deleteToken($user);
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('family_admin.login_view');
    }
}
