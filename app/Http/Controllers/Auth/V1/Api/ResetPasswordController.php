<?php

namespace App\Http\Controllers\Auth\V1\Api;

use App\Http\Controllers\Auth\V1\Request\ResetPasswordRequest;
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

        if (!$token = Auth::guard('api')->attempt(['id' => $user->id, 'password' => $request->old_password])) {
            abort(422, '旧密码错误');
        }

        $user->update(['password' => bcrypt($request->new_password)]);

        Auth::guard('api')->logout();
        activity('update_password')->causedBy($this->user())->log('CMS-修改密码');

        return $this->response->noContent()->setStatusCode(200);
    }
}
