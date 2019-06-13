<?php

namespace App\Http\Controllers\Work\V1\Api;

use App\Http\Controllers\Work\V1\Models\Work;
use App\Http\Controllers\Work\V1\Request\WorkRequest;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Work\V1\Transformer\WorkTransformer;
use Illuminate\Http\Request;

class WorksController extends Controller
{
    public function index(Request $request, Work $work)
    {
        $perPage = $request->get('perPage') ? (int)$request->get('perPage') : 10;

        $query = $work->query();
        return $query->OrderByDesc('updated_at')->paginate($perPage);
    }

    public function store(WorkRequest $request, Work $work)
    {
        $work->fill($request->all());
        $work->user_id = $this->user()->id;
        $work->save();

//        return $this->response->array($work->toArray())->setStatusCode(201);
        return response()->json($work, 201);
    }

    /**
     * 更新作品
     * @param WorkRequest $request
     * @param Work $work
     * @return Work
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(WorkRequest $request, Work $work)
    {
        $this->authorize('own', $work);
        $work->update($request->all());

        return $work;
    }

    public function show(Request $request, Work $work)
    {
        $work->setAttribute('user', $work->user);

        if ($request->has('workPage')) {
            $pageId = $request->get('workPage');

            $work = $work->toArray();

            //获取页面组件ids
            foreach ($work['pages'] as $k => $v) {
                if ($v['id'] == $pageId) {
                    $orderIds = $v['order'];
                } else {
                    unset($work['pages'][$k]);
                }
            }

            sort($work['pages']);

            //根据ids筛选组件
            foreach ($work['coms'] as $key => $item) {
                if (!in_array($item['id'], $orderIds)) {
                    unset($work['coms'][$key]);
                }
            }

            sort($work['coms']);
        }

        return response()->json($work);
    }

    /**
     * 作品预览
     * @param Request $request
     * @param Work $work
     * @return \Illuminate\Http\JsonResponse
     */
    public function preview(Request $request, Work $work)
    {
        if ($request->has('workPage')) {
            $pageId = $request->get('workPage');

            $work = $work->toArray();

            //获取页面组件ids
            foreach ($work['pages'] as $k => $v) {
                if ($v['id'] == $pageId) {
                    $orderIds = $v['order'];
                } else {
                    unset($work['pages'][$k]);
                }
            }
            sort($work['pages']);

            //根据ids筛选组件
            foreach ($work['coms'] as $key => $item) {
                if (!in_array($item['id'], $orderIds)) {
                    unset($work['coms'][$key]);
                }
            }

            sort($work['coms']);
        }


        return response()->json($work);
    }

    /**
     * 删除作品
     * @param Work $work
     * @return \Dingo\Api\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Work $work)
    {
        $this->authorize('own', $work);
        $work->delete();

        return $this->response->noContent();
    }

    public function templetIndex(Request $request, Work $work)
    {
        $perPage = $request->perPage ? (int)$request->perPage : 10;

        $query = $work->query();
        $templets = $query->OrderByDesc('﻿created_at')->paginate($perPage);

//        $templets = $query->user()->whereHas('roles', function (){
//
//        });

        return $this->response->paginator($templets, new WorkTransformer());
    }
}
