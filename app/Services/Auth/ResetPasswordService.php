<?php

namespace  App\Services\Auth;

use App\Http\Requests\Auth\NewPasswordRequest;
use App\Models\User;
use stdClass;
use Twilio\Rest\Client;
use Twilio\Exceptions\RestException;
use Illuminate\Support\Facades\Hash;

class ResetPasswordService{

    public function resetVerify($request){
        $phonenumber = $request->country_code . $request->phone;

        $user = User::where('phone',+923086577705)->first();
        $obj = new stdClass();
        if($user){


            $token = getenv("TWILIO_AUTH_TOKEN");
                $twilio_sid = getenv("TWILIO_SID");
                $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
                $twilio = new Client($twilio_sid, $token);

                try {
                    $twilio->verify->v2->services($twilio_verify_sid)->verifications->create($phonenumber, "sms");
                } catch (RestException $e) {

                    return response()->json([
                        'status' => false,
                        'action' => 'Otp send failed',
                        'data' => $obj,
                        'error' => [$e->getMessage()]
                    ]);
                }

                return response()->json([
                    'status' => true,
                    'action' => "Otp send",
                    'data' => $obj,
                    'error' => []
                ]);
        }
        else{
            return response()->json([
                'status' => false,
                'action' => "Account not found",
                'data' => $obj,
                'error' => []
            ]);
        }
    }

    public function resetOtpVerify($request){

        $obj = new stdClass();

        $phone_number = $request->country_code . $request->phone;
        $verification_code = $request->otp;

        $twilio_sid = getenv("TWILIO_SID");
        $twilio_auth_token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");

        $twilio = new Client($twilio_sid, $twilio_auth_token);

        try {
            $verification = $twilio->verify->v2->services($twilio_verify_sid)
                ->verificationChecks
                ->create([
                    'to' => $phone_number,
                    'code' => $verification_code
                ]);
        } catch (RestException $e) {
            return response()->json([
                'status' => false,
                'action' => 'Otp not verify',
                'data' => $obj,
                'error' => ['Time out']
            ]);
        }

        if ($verification->status == 'approved') {

            return response()->json([
                'status' => true,
                'action' => 'Verification successful',
                'data' => $obj,
                'error' => []
            ]);
        } else {
            return response()->json([
                'status' => false,
                'action' => 'Error verifying code',
                'data' => $obj,
                'error' => 'Inavlid code'
            ]);
        }
    }

    public function newPassword($request){

        $obj = new stdClass();
        $phone = $request->country_code . $request->phone;
        $user = User::where('phone',$phone)->first();

        if($user){


            if(Hash::check($request->password, $user->password)){
                return response()->json([
                    'status' => true,
                    'action' => 'New password not set',
                    'data' => $obj,
                    'error' => ["Old password is same"]
                ]);
            }
            else{
                $user->update([
                    'password' => $request->password
                ]);
                return response()->json([
                    'status' => true,
                    'action' => 'New password set',
                    'data' => $obj,
                    'error' => []
                ]);
            }
            
        }
        else{
            return response()->json([
                'status' => false,
                'action' => 'New password not set',
                'data' => $obj,
                'error' => ['Account not found']
            ]);
        }
    }
}