<?php

namespace App\Http\Controllers\User\V1\Api;

use App\Http\Controllers\User\V1\Transformer\CustomerTransformer;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function me()
    {
        //$this->user() dingo api helper trait
        return $this->response->item($this->user(), new CustomerTransformer());
    }


    /**
     * 修改用户信息
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function update(Request $request)
    {
        /** @var Customer $customer */
        $customer = $this->user();

        $attributes = $request->only(['name', 'avatar', 'password']);

//        if ($request->avatar_image_id) {
//            $image = Image::find($request->avatar_image_id);
//
//            $attributes['avatar'] = $image->path;
//        }

        if ($request->password) {
            $attributes['password'] = bcrypt($request->password);
        }

        $customer->update($attributes);

        return $this->response->item($customer, new CustomerTransformer());
    }

}
