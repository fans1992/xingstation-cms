<?php

namespace App\Http\Controllers\User\V1\Api;

use App\Http\Controllers\Admin\Common\V1\Models\Image;
use App\Http\Controllers\User\V1\Transformer\UserTransformer;
use App\Http\Controllers\User\V1\Request\UserRequest;
use App\Http\Controllers\Controller;
use App\Models\User;

class UsersController extends Controller
{
    public function me()
    {
        //$this->user() dingo api helper trait
        return $this->response->item($this->user(), new UserTransformer());
    }


    public function update(UserRequest $request)
    {
        $user = $this->user();

        $attributes = $request->only(['name', 'phone']);

        if ($request->avatar_image_id) {
            $image = Image::find($request->avatar_image_id);

            $attributes['avatar'] = $image->path;
        }

        if ($request->password) {
            $attributes['password'] = bcrypt($request->password);
        }

        $user->update($attributes);

        return $this->response->item($user, new UserTransformer());
    }

}
