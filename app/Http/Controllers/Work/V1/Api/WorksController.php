<?php

namespace App\Http\Controllers\Work\V1\Api;

use App\Http\Controllers\Work\V1\Models\Work;
use App\Http\Controllers\Work\V1\Request\WorkRequest;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Work\V1\Transformer\WorkTransformer;
use function foo\func;
use Illuminate\Http\Request;

class WorksController extends Controller
{
    public function index(Request $request, Work $work)
    {
        $perPage = $request->perPage ? (int)$request->perPage: 10;

        $query = $work->query();
        $works = $query->OrderByDesc('﻿created_at')->paginate($perPage);

        return $this->response->paginator($works, new WorkTransformer());
    }

    public function store(WorkRequest $request, Work $work)
    {
        $work->fill($request->all());
        $work->user_id = $this->user()->id;
        $work->save();

        return $this->response->array($work->toArray())->setStatusCode(201);
    }

    public function update(WorkRequest $request, Work $work)
    {
        $this->authorize('own', $work);
        $work->update($request->all());

        return $work;
    }

    public function show(Request $request, Work $work)
    {
        if ($request->has('workPage')) {
            $pageId = $request->workPage;

            $workInfo = $work->toArray();

            //获取页面组件ids
            foreach ($workInfo['pages'] as $k => $v) {
                if ($v['id'] == $pageId) {
                    $orderIds = $v['order'];
                } else {
                    unset($workInfo['pages'][$k]);
                }
            }

            //根据ids筛选组件
            foreach($workInfo['coms'] as $key => $item) {
                if (!in_array($item['id'], $orderIds)) {
                    unset($workInfo['coms'][$key]);
                }
            }

        }

        return $this->response->array($workInfo, new WorkTransformer());
    }

    public function destroy(Work $work)
    {
        $this->authorize('own', $work);
        $work->delete();

        return $this->response->noContent();
    }

    public function templetIndex(Request $request, Work $work)
    {
        $perPage = $request->perPage ? (int)$request->perPage: 10;

        $query = $work->query();
        $templets = $query->OrderByDesc('﻿created_at')->paginate($perPage);

//        $templets = $query->user()->whereHas('roles', function (){
//
//        });

        return $this->response->paginator($templets, new WorkTransformer());
    }
}
