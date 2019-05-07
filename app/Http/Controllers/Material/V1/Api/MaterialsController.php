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
        $perPage = $request->get('perPage') ? (int)$request->get('perPage') : 10;

        $query = $material->query();

        if ($request->has('type')) {
            $query->where('type', $request->get('type'));
        }

        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function store(MaterialRequest $request, Material $material)
    {
        $material->fill($request->all());
        $material->user_id = $this->user()->id;
        $material->save();

        return response()->json($material, 201);
    }

    public function show(Material $material): Material
    {
        $material->setAttribute('user', $material->user);
        return $material;
    }

    /**
     * 更新素材
     * @param MaterialRequest $request
     * @param Material $material
     * @return Material
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(MaterialRequest $request, Material $material): Material
    {
        $this->authorize('own', $material);
        $material->update($request->all());

        return $material;
    }

    /**
     * 删除素材
     * @param Material $material
     * @return \Dingo\Api\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Material $material): \Dingo\Api\Http\Response
    {
        $this->authorize('own', $material);
        $material->delete();

        return $this->response->noContent();
    }

}