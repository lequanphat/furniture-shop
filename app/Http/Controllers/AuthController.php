<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePassword;
use App\Http\Requests\ForgotPassword;
use App\Http\Requests\OTPVerification;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Models\UserVerify;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;


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
    public function forgot_password_ui()
    {
        return view('auth.forgot-password');
    }
    public function account_verification_ui(Request $request)
    {
        $user_id = $request->route('user_id');
        $user = User::find($user_id);
        return view('auth.account-verification', ['user' => $user]);
    }
    public function forgot_password_verification_ui(Request $request)
    {
        $user_id = $request->route('user_id');
        return view('auth.forgot-password-verification', ['user_id' => $user_id]);
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
        $user = User::where('email', $request->input('email'))->first();

        if ($user) {
            if ($user->is_verified) {
                return back()->withErrors(['email' => 'This email already exists.'])->withInput($request->input());
            }
            $user->update([
                'password' => Hash::make($request->input('password')),
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
            ]);
            // generate otp
            $otp = rand(100000, 999999);
            $expiredTime = Carbon::now()->addMinutes(5);
            $user_verify = UserVerify::where('user_id', $user->user_id)->first();
            if ($user_verify) {
                $user_verify->update(['otp' => $otp, 'expired_time' => $expiredTime]);
            } else {
                $user_verify = UserVerify::create(['user_id' => $user->user_id, 'otp' => $otp, 'expired_time' => $expiredTime]);
            }
            // send mail here
            Mail::raw('Your code is ' . $otp, function ($message) use ($user) {
                $message->to($user->email);
            });

            // response
            return redirect("/account-verification/" . $user->user_id);
        } else {
            $user = User::create([
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'avatar' => '/storage/defaults/default_avatar.jpg',
            ]);
            // generate otp
            $otp = rand(100000, 999999);
            $expiredTime = Carbon::now()->addMinutes(5);

            // create user_verify
            $user_verify = UserVerify::create(['user_id' => $user->user_id, 'otp' => $otp, 'expired_time' => $expiredTime]);
            // send mail here
            Mail::raw('Your code is ' . $otp, function ($message) use ($user) {
                $message->to($user->email);
            });

            // response
            return redirect("/account-verification/" . $user->user_id);
        }
    }
    public function account_verification(OTPVerification $request)
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
            abort(500, 'User not found.');
            // ...
        }
        abort(500, 'Invalid Code.');
    }


    public function resend_otp(Request $request)
    {
        $user_id = $request->route('user_id');
        $user_verify = UserVerify::where('user_id', $user_id)->first();
        $user = User::find($user_id);
        if ($user_verify) {
            // generate otp
            $otp = rand(100000, 999999);
            $expiredTime = Carbon::now()->addMinutes(5);
            $user_verify->update(['otp' => $otp, 'expired_time' => $expiredTime]);
            // send mail here
            Mail::raw('Your code is ' . $otp, function ($message) use ($user) {
                $message->to($user->email);
            });
            // response
            return back();
        } else return back()->withErrors(['otp' => 'Some went wrong!'])->withInput($request->input());
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
    public function forgot_password(ForgotPassword $request)
    {
        // check existed user
        $user = User::where('email', $request->input('email'))->where('is_active', true)->where('is_verified', true)->first();
        if ($user) {
            // generate new password
            $otp = rand(100000, 999999);
            $user->update(['password' => Hash::make($otp)]);
            // send email here
            Mail::raw('Your new password is ' . $otp, function ($message) use ($user) {
                $message->to($user->email);
            });
            // response
            return redirect('/forgot-password-verification');
        }
        // response
        return back()->withErrors(['email' => 'Cannot find user with this email.'])->withInput($request->input());
    }

    public function change_password(ChangePassword $request)
    {
        $user = User::find(Auth::user()->user_id);
        if (Hash::check($request->input('password'), $user->password)) {
            $user->update([
                'password' => Hash::make($request->input('new_password')),
            ]);
            return redirect('/');
        }
        return back()->withErrors(['password' => 'Invalid password'])->withInput($request->input());
    }
}
