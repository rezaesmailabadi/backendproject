<?php

namespace App\Http\Controllers\Auth\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Customer\LoginRegisterRequest;
use App\Http\Services\Message\Email\EmailService;
use App\Http\Services\Message\MessageService;
use App\Http\Services\Message\SMS\SmsService;
use App\Models\Otp;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class LoginRegisterController extends Controller
{




    public function loginRegister(LoginRegisterRequest $request)
    {
        // dd($request);
        try {
            $inputs = $request->all();
            //check id is email or not
            if (filter_var($inputs['email'], FILTER_VALIDATE_EMAIL)) {
                $type = 1; // 1 => email
                $user = User::where('email', $inputs['email'])->first();
                if (empty($user)) {
                    $newUser['email'] = $inputs['email'];
                }
                // dd('hkddk');
            }
            if (empty($user)) {
                $newUser['password'] = '98355154';
                $newUser['activition'] = 1;
                $user = User::create($newUser);
            }

            $otpCode = rand(111111, 999999);
            $token = Str::random(60);
            $otpInputs = [
                'token' => $token,
                'user_id' => $user->id,
                'otp_code' => $otpCode,
                'login_id' => $inputs['email'],
                'type' => $type,
            ];
            //create otp code
            Otp::create($otpInputs);
            return response()->json([
                'results' => $otpCode
            ], 200);
        } catch (\Exception $e) {
            // Return Json Response
            return response()->json([
                'message' => "Something went dfsdfsfdsfdsdfsfdsfd wrong!"
            ], 500);
        }
    }


    public function loginConfirmForm($token, LoginRegisterRequest $request)
    {

        try {

            $inputs = $request->all();
            $otp = Otp::where('token', $token)->where('used', 0)->where('created_at', '>=', Carbon::now()->subMinute(5)->toDateTimeString())->first();
            if (empty($otp)) {
                return response()->json([
                    'message' => "آدرس وارد شده صحیح نمیباشد "
                ], 500);
            }

            //if otp not match
            if ($otp->otp_code !== $inputs['otp']) {
                return response()->json([
                    'message' => "کد وارد شده صحیح نمیباشد "
                ], 500);
            }

            // if everything is ok :
            $otp->update(['used' => 1]);
            $user = $otp->user()->first();
            if ($otp->type == 1 && empty($user->email_verified_at)) {
                $user->update(['email_verified_at' => Carbon::now()]);
            }
            Auth::login($user);
            return response()->json([
                'message' => "همه اوکیه"
            ], 200);
        } catch (\Exception $e) {
            // Return Json Response
            return response()->json([
                'message' => "Something went really wrong!"
            ], 500);
        }
    }









    public function loginConfirm($token, LoginRegisterRequest $request)
    {
        try {
            $inputs = $request->all();
            $otp = Otp::where('token', $token)->where('used', 0)->where('created_at', '>=', Carbon::now()->subMinute(5)->toDateTimeString())->first();
            if (empty($otp)) {
                return redirect()->route('auth.customer.login-register-form', $token)->withErrors(['id' => 'آدرس وارد شده نامعتبر میباشد']);
            }

            //if otp not match
            if ($otp->otp_code !== $inputs['otp']) {
                return redirect()->route('auth.customer.login-confirm-form', $token)->withErrors(['otp' => 'کد وارد شده صحیح نمیباشد']);
            }

            // if everything is ok :
            $otp->update(['used' => 1]);
            $user = $otp->user()->first();
            if ($otp->type == 0 && empty($user->mobile_verified_at)) {
                $user->update(['mobile_verified_at' => Carbon::now()]);
            } elseif ($otp->type == 1 && empty($user->email_verified_at)) {
                $user->update(['email_verified_at' => Carbon::now()]);
            }
            Auth::login($user);
            return redirect()->route('customer.home');
        } catch (\Exception $e) {
            // Return Json Response
            return response()->json([
                'message' => "Something went really wrong!"
            ], 500);
        }
    }



    public function loginResendOtp($token)
    {
        try {

            $otp = Otp::where('token', $token)->where('created_at', '<=', Carbon::now()->subMinutes(5)->toDateTimeString())->first();

            if (empty($otp)) {
                return redirect()->route('auth.customer.login-register-form', $token)->withErrors(['id' => 'ادرس وارد شده نامعتبر است']);
            }

            $user = $otp->user()->first();
            //create otp code
            $otpCode = rand(111111, 999999);
            $token = Str::random(60);
            $otpInputs = [
                'token' => $token,
                'user_id' => $user->id,
                'otp_code' => $otpCode,
                'login_id' => $otp->login_id,
                'type' => $otp->type,
            ];

            Otp::create($otpInputs);

            //send sms or email

            if ($otp->type == 0) {
                //send sms
                $smsService = new SmsService();
                $smsService->setFrom(Config::get('sms.otp_from'));
                $smsService->setTo(['0' . $user->mobile]);
                $smsService->setText("مجموعه آمازون \n  کد تایید : $otpCode");
                $smsService->setIsFlash(true);

                $messagesService = new MessageService($smsService);
            } elseif ($otp->type === 1) {
                $emailService = new EmailService();
                $details = [
                    'title' => 'ایمیل فعال سازی',
                    'body' => "کد فعال سازی شما : $otpCode"
                ];
                $emailService->setDetails($details);
                $emailService->setFrom('noreply@example.com', 'example');
                $emailService->setSubject('کد احراز هویت');
                $emailService->setTo($otp->login_id);

                $messagesService = new MessageService($emailService);
            }

            $messagesService->send();

            return redirect()->route('auth.customer.login-confirm-form', $token);
        } catch (\Exception $e) {
            // Return Json Response
            return response()->json([
                'message' => "Something went really wrong!"
            ], 500);
        }
    }


    public function logout()
    {
        Auth::logout();
        return redirect()->route('customer.home');
    }
}
