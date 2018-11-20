<?php

namespace App\Http\Controllers\Admin\Common\V1\Api;

use App\Http\Controllers\Admin\Common\V1\Models\Appointment;
use App\Http\Controllers\Admin\Order\V1\Transformer\OrderTransformer;
use App\Http\Controllers\Admin\Common\V1\Request\ChartDataRequest;
use App\Http\Controllers\Admin\Order\V1\Models\Order;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use DB;
use Illuminate\Support\Collection;

class ChartDataController extends Controller
{
    /**
     * 销售详细订单
     * @param Request $request
     * @param Order $order
     * @return \Dingo\Api\Http\Response
     */
    public function index(Request $request, Order $order)
    {

        $query = $order->query();

        $perPage = $request->has('per_page') ? $request->per_page : 10;
        $currentPage = $request->has('page') ? $request->page : 1;

        $this->handleQuery($request, $query);

        $query->selectRaw('DATE_FORMAT(date_added,"%Y-%m-%d") as display_name');

        $searchResults = $query->selectRaw('COUNT(*) AS order_quantity, convert(SUM(total),decimal(10,2)) AS order_total, convert(AVG(total),decimal(10,2)) AS avg_price, oc_optical_store.internal_name')
            ->leftJoin('optical_store',  'optical_store.optical_store_id', '=', 'order.optical_store_id')
            ->groupBy('display_name', 'order.optical_store_id')
            ->orderBy('display_name', 'desc')
            ->get()->toArray();

        //手动分页(groupBy paginate)
        $collection = new Collection($searchResults);
        $currentPageSearchResults = $collection->slice(($currentPage-1) * $perPage, $perPage)->all();
        $paginatedSearchResults = new LengthAwarePaginator($currentPageSearchResults, count($collection), $perPage);

        $output['data'] = $paginatedSearchResults->items();
        $output['meta'] = [
            'pagination' => [
                'total' => $paginatedSearchResults->total(),
                'per_page' => $paginatedSearchResults->perPage(),
                'count' => $paginatedSearchResults->perPage(),
                'current_page' => $paginatedSearchResults->currentPage(),
                'total_pages' => $paginatedSearchResults->lastPage(),
            ],
        ];

        return $this->response->array($output);

    }


    /**
     *图表数据
     * @param ChartDataRequest $request
     * @return mixed
     */
    public function chart(ChartDataRequest $request, Order $order, Appointment $appointment)
    {
        $orderQuery = $order->query();
        $appQuery = $appointment->query();

        switch ($request->id) {
            case 1:
                $data = $this->getOrderStats($request, $orderQuery);
                break;
            case 2:
                $data = $this->getOrderStatsByDate($request, $orderQuery);
                break;
            case 3:
                $data = $this->getMarketingStats($request, $orderQuery);
                break;
            case 4:
                $data = $this->getMarketingOrders($request, $orderQuery);
                break;
            case 5:
                $data = $this->getMarketingStatsByDate($request, $orderQuery);
                break;
            default:
                return null;
        }

        return $this->response->array($data);
    }

    /**
     * 订单统计数据
     * @param ChartDataRequest $request
     * @param Builder $query
     * @return array
     */
    public function getOrderStats(ChartDataRequest $request, Builder $query) {
        $this->handleQuery($request, $query);

        $output = $query->selectRaw("COUNT(*) AS order_quantity, convert(SUM(total),decimal(10,2)) AS order_total, convert(AVG(total),decimal(10,2)) AS avg_price")
                    ->first()->toArray();

        return $output;
    }

    /**
     * 分时订单统计数据
     * @param ChartDataRequest $request
     * @param Builder $query
     * @return array
     */
    public function getOrderStatsByDate(ChartDataRequest $request, Builder $query) {
        $this->handleQuery($request, $query);

        if ($request->start_date == $request->end_date) {
            $query->selectRaw('concat(DATE_FORMAT(date_added,"%H"),":00") as display_name');
        } else {
            $query->selectRaw('DATE_FORMAT(date_added,"%Y-%m-%d") as display_name');
        }

        $output = $query->selectRaw('COUNT(*) AS order_quantity, convert(SUM(total),decimal(10,2)) AS order_total, convert(AVG(total),decimal(10,2)) AS avg_price')
            ->groupBy('display_name')
            ->get()->toArray();

        return $output;

    }

    /**
     * 活动 统计数据
     * @param ChartDataRequest $request
     * @param Builder $query
     * @return array
     */
    public function getMarketingStats(ChartDataRequest $request, Builder $query) {
        //总预约量
        $appointment_quantity = Appointment::query()->where('marketing_id', $request->marketing_id)->count();

        //总订单量和总金额

        $orders = $query->selectRaw("distinct(oc_order.order_id),oc_order.total,oc_order.date_added,oc_customer.mobile,oc_order.optical_store_id,oc_order.customer_id")
            ->leftjoin('customer', 'customer.customer_id','=','order.customer_id')
            ->whereRaw("oc_customer.mobile in (select appointment_mobile from oc_appointment where oc_appointment.marketing_id = " . $request->marketing_id . ")")
            ->whereRaw("oc_order.date_added > (select oc_marketing.date_added from oc_marketing where oc_marketing.marketing_id = " . $request->marketing_id . ")")
            ->whereNotIn('order_status_id', [0, 15, 16])
            ->orderBy('order.date_added', 'desc')
            ->get()->toArray();

        $order_quantity = count($orders);
        $order_total = number_format(array_sum(array_map(function($val){return $val['total'];}, $orders)), 2);

        $output = [
            'appointment_quantity' => $appointment_quantity,
            'order_quantity'       => $order_quantity,
            '$order_total'         => $order_total,
        ];

        return $output;
    }

    /**
     * 活动转化订单列表
     * @param ChartDataRequest $request
     * @param Builder $query
     * @return \Dingo\Api\Http\Response
     */
    public function getMarketingOrders(ChartDataRequest $request, Builder $query) {
        if ($request->filled('optical_store_id')) {
            $query->where('optical_store_id', $request->optical_store_id);
        }

        $orders = $query->selectRaw("distinct(oc_order.order_id),convert(oc_order.total, decimal(10,2)) as total,oc_order.date_added,oc_customer.mobile,oc_order.optical_store_id,oc_order.customer_id")
            ->leftjoin('customer', 'customer.customer_id','=','order.customer_id')
            ->whereRaw("oc_customer.mobile in (select appointment_mobile from oc_appointment where oc_appointment.marketing_id = " . $request->marketing_id . ")")
            ->whereRaw("oc_order.date_added > (select oc_marketing.date_added from oc_marketing where oc_marketing.marketing_id = " . $request->marketing_id . ")")
            ->whereNotIn('order_status_id', [0, 15, 16])
            ->orderBy('order.date_added', 'desc')
            ->paginate(10);

        return $this->response->paginator($orders, new OrderTransformer());
    }

    /**
     * 活动分时统计
     * @param ChartDataRequest $request
     * @param Builder $query
     * @return mixed
     */
    public function getMarketingStatsByDate(ChartDataRequest $request, Builder $query) {
        $output = DB::connection('freecart')->select("select DATE_FORMAT(t.date_added,'%Y-%m-%d') as display_name, count(distinct(t.order_id)) as order_quantity, convert(sum(t.total), decimal(10,2)) as order_total, convert(avg(t.total), decimal(10,2)) as avg_price from 
                (select distinct(o.order_id),o.total, o.date_added from oc_order o left join oc_customer c on o.customer_id = c.customer_id
                where c.mobile in 
                (select a.appointment_mobile 
                from oc_appointment a
                where a.marketing_id = " . $request->marketing_id . ")
                and o.order_status_id not in (0,15,16)
                and o.date_added > (select date_added from oc_marketing where marketing_id = " . $request->marketing_id . ")
                order by o.order_id) t
                group by display_name");

        foreach ($output as &$item) {
            $item->appointment_quantity = Appointment::query()
                ->where('marketing_id', $request->marketing_id)
                ->whereDate('appointment_time', $item->display_name)
                ->count();
        }

        return $output;
    }


    /**
     * 公用条件
     * @param Request $request
     * @param Builder $query
     */
    private function handleQuery(Request $request, Builder $query) {
        if ($request->filled('optical_store_id')) {
            $query->where('order.optical_store_id', $request->optical_store_id);
        }

        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = $request->start_date;
            $endDate = $request->end_date;
            $query->whereRaw("str_to_date(date_added,'%Y-%m-%d') between '$startDate' and '$endDate'");
        }

        $query->whereNotIn('order_status_id', [0, 15, 16]);

    }



}
