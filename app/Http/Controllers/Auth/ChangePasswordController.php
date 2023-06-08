<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Services\Auth\ChangePasswordService;
use Illuminate\Http\Request;

class ChangePasswordController extends Controller
{
    protected $changePasswordService;

    public function __construct(ChangePasswordService $changePasswordService)
    {
        $this->changePasswordService = $changePasswordService;
    }

    public function changePassword(ChangePasswordRequest $request){
        return $this->changePasswordService->changePassword($request);
    }
}
