<?php

namespace App\Http\Controllers\Material\V1\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class MaterialsController extends Controller
{
    public function index(Request $request)
    {
        $res = DB::connection('mongodb')->collection('xingstation_cms')->all();
        dd($res);
    }

}