<?php

namespace  App\Services\Auth;

use App\Models\User;
use App\Models\UserDevice;
use Illuminate\Support\Facades\Hash;
use stdClass;

class RegisterService
{
    public function register($request)
    {

        $obj = new stdClass();

      


        $phone = $request->country_code . $request->phone;

        $user = User::where('phone', $phone)->first();
        if ($user) {
            return response()->json([
                'status' => false,
                'action' => "Register failed",
                'data' => $obj,
                'error' => ['Phone already exists']
            ]);
        }
        else{
            $user = new User();
            $user->name = $request->name;
            $user->phone = $phone;
            $user->platform = $request->platform;
            $user->password = $request->password;
            $user->platform = $request->platform;
            $user->username = $request->username;
            $user->save();

            $user = User::where('username', $request->username)->first();

            $userdevice = new UserDevice();
            $userdevice->user_id = $user->id;
            $userdevice->device_name = $request->device_name;
            $userdevice->device_id = $request->device_id;
            $userdevice->timezone = $request->timezone;
            $userdevice->token = $request->token;
            $userdevice->save();


            return response()->json([
                'status' => true,
                'action' => "Register successfully",
                'data' => $user,
                'error' => []
            ]);

        }
    }
}
