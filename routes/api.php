<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


$api = app('Dingo\Api\Routing\Router');

app('Dingo\Api\Exception\Handler')->register(function (Exception $exception) {
    if ($exception instanceof TokenExpiredException) {
        return response()->json('未登录', 401);
    };
});

include app_path('Http/Controllers/Auth/V1/routes.php');
include app_path('Http/Controllers/User/V1/routes.php');
include app_path('Http/Controllers/Common/V1/routes.php');
//include app_path('Http/Controllers/Admin/Store/V1/routes.php');
//include app_path('Http/Controllers/Admin/Marketing/V1/routes.php');


