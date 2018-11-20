<?php

namespace App\Http\Controllers\Admin\Marketing\V1\Api;

use App\Http\Controllers\Admin\Marketing\V1\Transformer\MarketingTransformer;
use App\Http\Controllers\Admin\Marketing\V1\Models\Marketing;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MarketingsController extends Controller
{
    public function index(Request $request, Marketing $marketing)
    {
        $query = $marketing->query();

        //预约专用
        if ($request->filled('use_for_appointment')) {
            $query->where('use_for_appointment', $request->use_for_appointment);
        }

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        $marketings = $query->orderBy('date_added', 'desc')->paginate(20);

        return $this->response->paginator($marketings, new MarketingTransformer());
    }

}