<?php

namespace App\Http\Controllers\Auth\V1\Api;

use App\Http\Controllers\Admin\Auth\V1\Request\ResetPasswordRequest;
use App\Models\Customer;
use App\Http\Controllers\Controller;
use Auth;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */


    public function reset(ResetPasswordRequest $request)
    {
        /** @var Customer $user */
        $user = $this->user;
        $user->update(['password' => bcrypt($request->new_password)]);

        Auth::guard('api')->logout();
        activity('update_password')->causedBy($this->user())->log('修改密码');
        abort(401);
    }
}
