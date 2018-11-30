<?php

namespace App\Http\Controllers\Material\V1\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Material\V1\Models\Material;
use App\Http\Controllers\Material\V1\Request\MaterialRequest;
use App\Http\Controllers\Material\V1\Transformer\MaterialTransformer;
use Illuminate\Http\Request;
use DB;

class MaterialsController extends Controller
{
    public function index(Request $request, Material $material)
    {
        $perPage = $request->perPage ? (int)$request->perPage: 10;

        $query = $material->query();

        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        if ($request->has('name')) {
            $query->where('name', 'like', '%'.$request->name.'%');
        }

        $materials = $query->orderBy('created_at', 'desc')->paginate($perPage);

        return $this->response->paginator($materials, new MaterialTransformer());
    }

    public function store(MaterialRequest $request, Material $material)
    {
        $material->fill($request->all());
        $material->user_id = $this->user()->id;
        $material->name = $material->attribute['name'];
        $material->save();

        return $this->response->item($material, new MaterialTransformer())
            ->setStatusCode(201);
    }

    public function show(Request $request, Material $material)
    {
        return $this->response->item($material, new MaterialTransformer());
    }

    public function update(MaterialRequest $request, Material $material)
    {
        $this->authorize('own', $material);
        $material->update($request->all());

        return $this->response->item($material, new MaterialTransformer());
    }

    public function destroy(Material $material)
    {
        $this->authorize('own', $material);
        $material->delete();

        return $this->response->noContent();
    }

}