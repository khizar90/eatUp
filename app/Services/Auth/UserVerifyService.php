<?php

namespace  App\Services\Auth;

use App\Http\Requests\Auth\OtpVerifyRequest;
use App\Models\User;
use stdClass;
use Twilio\Rest\Client;
use Twilio\Exceptions\RestException;


class  UserVerifyService
{

    public function userVerify($request)
    {
        $obj = new stdClass();

        $phonenumber = $request->country_code . $request->phone;



        $user = User::where('phone', $phonenumber)->first();

        if ($user) {
            return response()->json([
                'status' => false,
                'action' => "User not verify",
                'data' => $obj,
                'error' => ['Phone number is already exists']
            ]);
        } else {

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
                'action' => "User verify",
                'data' => $obj,
                'error' => []
            ]);
        }
    }

    public function otpVerify($request)
    {

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
                'action' => 'Error in verifying code',
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
}
