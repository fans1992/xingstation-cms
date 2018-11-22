<?php

namespace App\Http\Controllers\Material\V1\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Material\V1\Models\Material;
use Illuminate\Http\Request;
use DB;

class MaterialsController extends Controller
{
    public function index(Request $request)
    {
//        $res = DB::connection('mongodb')->collection('materials')->first();
        $res = Material::first();
        dd($res);

    }

}