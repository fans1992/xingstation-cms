<?php

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

if (!function_exists('formatClientDate')) {
    function formatClientDate($clientRate)
    {
        return date('Y-m-d H:i:s', $clientRate / 1000);
    }
}

if (!function_exists('getRand')) {

    function getRand($proArr)
    {
        $result = array();
        foreach ($proArr as $key => $val) {
            if (is_object($val)) {
                $val = get_object_vars($val);
            }
            $arr[$key] = $val['rate'];
        }
        // 概率数组的总概率
        $proSum = array_sum($arr);
        asort($arr);
        // 概率数组循环
        // 检查奖品容量
        foreach ($arr as $k => $v) {
            $randNum = mt_rand(1, $proSum);
            if ($randNum <= $v) {
                $result = $proArr[$k];
                break;
            } else {
                $proSum -= $v;
            }
        }
        return $result;
    }
}

/**
 * 处理点位查询
 */
if (!function_exists('handPointQuery')) {
    function handPointQuery(Request $request, Builder $builder, $arUserID, bool $selectPoint = false)
    {
        $table = $builder->getModel()->getTable();
        //查询时间范围
        if ($request->start_date && $request->end_date) {
            $startDate = $request->start_date;
            $endDate = $request->end_date;
            $builder->whereRaw("date_format($table.date, '%Y-%m-%d') BETWEEN '$startDate' AND '$endDate' ");
        }

        //按指标查询
        if ($request->index) {
            $indexes = explode(',', $request->index);
            foreach ($indexes as $index) {
                $builder->selectRaw("sum($index) as $index");
            }
        }

        //按场景查询
        if ($request->scene_id) {
            $builder->where('avr_official.sid', '=', $request->scene_id);
        }

        //按区域查询
        if ($request->area_id) {
            $builder->where('avr_official.areaid', '=', $request->area_id);
        }

        //按商场查询
        if ($request->market_id) {
            $builder->where('avr_official.marketid', '=', $request->market_id);
        }

        //按点位查询
        if ($request->point_id) {
            $builder->where('avr_official.oid', '=', $request->point_id);
        }

        $builder->join('avr_official', 'avr_official.oid', '=', "$table.oid")
            ->join('avr_official_market', 'avr_official_market.marketid', '=', 'avr_official.marketid')
            ->join('avr_official_area', 'avr_official_area.areaid', '=', 'avr_official.areaid');

        if ($selectPoint) {
            $builder->selectRaw("avr_official.name as point_name,avr_official_market.name as market_name,avr_official_area.name as area_name");
            $builder->selectRaw("avr_official.oid as point_id,avr_official_market.marketid as market_id,avr_official_area.areaid as area_id");
        }
    }
}