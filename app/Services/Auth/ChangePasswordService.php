<?php

namespace  App\Services\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use stdClass;

class ChangePasswordService
{

    public function changePassword($request)
    {
        $obj = new stdClass();
        $user = User::where('phone', $request->phone)->first();
        if ($user) {

            if(Hash::check($request->oldPassword, $user->password)){

                if (Hash::check($request->newPassword, $user->password)) {

                    return response()->json([
                        'status' => false,
                        'action' => "Password not change",
                        'data' => $obj,
                        'error' => ['New password  is  same as old password']
                    ]);
                } else {
                    $user->update([
                        'password' => $request->newPassword
                    ]);
                    return response()->json([
                        'status' => true,
                        'action' => "Password  change",
                        'data' => $obj,
                        'error' => []
                    ]);
                }
            }
            return response()->json([
                'status' => false,
                'action' => "Password not change",
                'data' => $obj,
                'error' => ['Old password is invalid']
            ]);
            
        }
        return response()->json([
            'status' => false,
            'action' => "Password not change",
            'data' => $obj,
            'error' => ['Account not found']
        ]);
    }
}
