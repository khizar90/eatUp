<?php

namespace  App\Services\Auth;

use App\Models\User;
use App\Models\UserDevice;
use Illuminate\Support\Facades\Hash;
use stdClass;

class LoginService
{

    public function login($request)
    {


        $obj = new stdClass();

        $user = User::where('username', $request->username)->orWhere('phone', $request->username)
            ->first();

        if ($user) {

            if (Hash::check($request->password, $user->password)) {

                $userdevice = new UserDevice();
                $userdevice->user_id = $user->id;
                $userdevice->device_name = $request->device_name;
                $userdevice->device_id = $request->device_id;
                $userdevice->timezone = $request->timezone;
                $userdevice->token = $request->token;
                $userdevice->save();

                $user->save();
                return response()->json([
                    'status' => true,
                    'action' => "Login successfully",
                    'data' => $user,
                    'error' => []
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'action' => "Login failed",
                    'data' => $obj,
                    'error' => ['Wrong password']
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'action' => "Login failed",
                'data' => $obj,
                'error' => ['User not found']
            ]);
        }





        return response()->json([
            'status' => false,
            'action' => "Login failed",
            'data' => $obj,
            'error' => ['Invalid platform']
        ]);
    }
}
