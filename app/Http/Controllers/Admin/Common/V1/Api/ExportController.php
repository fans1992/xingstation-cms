<?php

namespace App\Http\Controllers\Admin\Common\V1\Api;

use App\Http\Controllers\Admin\Common\V1\Request\ExportRequest;
use App\Http\Controllers\Controller;
use Excel;

class ExportController extends Controller
{
    public function store(ExportRequest $request)
    {
        $type = $request->type;
        /**@var $loginUser \App\Models\User */
        $loginUser = $this->user();
        if ($type == 'marketing' || $type == 'marketing_top') {
            if (!$loginUser->hasPermissionTo('download')) {
                abort(403, '无下载权限');
            };
        }

        $path = config('filesystems')['disks']['qiniu']['url'];
        $export = app($type);

        $fileName = $export->fileName . '_' . time() . '_' . '.' . 'xlsx';
        Excel::store($export, $fileName, 'qiniu');
        return $path . urlencode($fileName);
    }

}
