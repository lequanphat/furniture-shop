<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\VerifyAccount;
use App\Models\User;
use App\Models\UserVerify;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function login_ui()
    {
        return view('auth.login');
    }
    public function register_ui()
    {
        return view('auth.register');
    }
    public function accountVerification_ui(Request $request)
    {
        $user_id = $request->route('user_id');
        return view('auth.email-verify', ['user_id' => $user_id]);
    }
    public function login(Request $request)
    {
        // check user exists
        $user = User::where('email', $request->input('email'))->where('is_active', true)->first();
        if ($user) {
            // check password
            if (Hash::check($request->input('password'), $user->password)) {
                if ($user->is_verified) {
                    // authenticated
                    Auth::login($user);
                    if ($user->is_staff)
                        return redirect('/admin');
                    else
                        return redirect('/');
                    // user haven't verified
                } else return back()->withErrors(['password' => 'This account is not verified!'])->withInput($request->input());
            } else {
                // invalid password
                return back()->withErrors(['password' => 'Invalid password'])->withInput($request->input());
            }
        } else {
            // invalid email
            return back()->withErrors(['email' => 'User not found'])->withInput($request->input());
        }
    }

    public function register(RegisterRequest $request)
    {
        // If RegisterRequest passes, create the user
        $user = User::create([
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
        ]);
        // generate otp
        $otp = rand(100000, 999999);
        $expiredTime = Carbon::now()->addMinutes(5);

        // create user_verify
        $user_verify = UserVerify::create(['user_id' => $user->user_id, 'otp' => $otp, 'expired_time' => $expiredTime]);
        // send mail here
        // --->

        // response
        return redirect("/email-verify/" . $user->user_id);
    }
    public function accountVerification(VerifyAccount $request)
    {
        // check existed account
        $user_id = $request->route('user_id');
        $user_verify = UserVerify::where('user_id', $user_id)
            ->where('otp', $request->input('otp'))
            ->where('expired_time', '>=', now())
            ->first();
        if ($user_verify) {
            $user = User::find($user_id);
            if ($user) {
                $user->update([
                    'is_verified' => true,
                ]);
                // authenticated
                Auth::login($user);
                $user_verify->delete();

                // response
                return redirect('/');
            }
            return back()->withErrors(['otp' => 'Verify account failed'])->withInput($request->input());
        } else return back()->withErrors(['otp' => 'Invalid OTP'])->withInput($request->input());
    }
    public function resendOTP(Request $request)
    {
        $user_id = $request->route('user_id');
        $user_verify = UserVerify::where('user_id', $user_id)->first();
        if ($user_verify) {
            // generate otp
            $otp = rand(100000, 999999);
            $expiredTime = Carbon::now()->addMinutes(5);
            $user_verify->update(['otp' => $otp, 'expired_time' => $expiredTime]);
            // send mail here
            // -->
            return redirect('/email-verify/' . $user_id);
        } else return back()->withErrors(['otp' => 'Some went wrong!'])->withInput($request->input());
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
