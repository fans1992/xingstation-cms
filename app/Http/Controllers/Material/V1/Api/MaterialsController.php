<?php

namespace App\Http\Controllers\Material\V1\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Material\V1\Models\Material;
use App\Http\Controllers\Material\V1\Request\MaterialRequest;
use Illuminate\Http\Request;
use DB;

class MaterialsController extends Controller
{
    public function index(Request $request, Material $material)
    {
        $query = $material->query();

        $materials = $query->orderBy('id', 'desc')->paginate(1);

        return $materials;
    }

    public function store(Request $request, Material $material)
    {
        $material->fill($request->all());
        $material->user_id = $this->user()->id;
        $material->save();

        return $material;
    }

    public function update(Request $request, Material $material)
    {
        $this->authorize('own', $material);

        $material->update($request->all());


        return $material;
    }

}