<?php

namespace App\Http\Controllers\Work\V1\Api;

use App\Http\Controllers\Work\V1\Models\Work;
use App\Http\Controllers\Work\V1\Request\WorkRequest;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Work\V1\Transformer\WorkTransformer;
use Illuminate\Http\Request;

class WorksController extends Controller
{
    public function index(Request $request)
    {
        //
    }

    public function store(WorkRequest $request, Work $work)
    {
        $work->fill($request->all());
        $work->user_id = $this->user()->id;
        $work->save();

        return $this->response->item($work, new WorkTransformer())->setStatusCode(201);
    }

    public function show(Request $request, Work $work)
    {
        return $this->response->item($work, new WorkTransformer());
    }
}
