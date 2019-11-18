<?php
namespace App\Http\Controllers\Backends;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use App\Order;
use Auth;
use Validator;
use Cache;
use App\Helper\Helper;
use App\User;

class StatisticController extends Controller {
    public function index()
    {
        return view('backends.statistic.index');
    }

    public function getDataAjax(Request $request)
    {
        $name_course = trim($request['name_course']);
        $name_teacher = trim($request['name_teacher']);
        $datepicker_from = $request['datepicker_from'];
        $datepicker_to = $request['datepicker_to'];

        $query = \DB::table('orders')
                    ->leftJoin('order_details', 'order_details.order_id', '=', 'orders.id')
                    ->leftJoin('payments', 'payments.id', '=', 'orders.payment_id');

        if( !empty($name_course) ) {
            $query->leftJoin('courses', 'courses.id', '=', 'order_details.course_id');
            $query->where('courses.name', 'like', '%' . $name_course . '%');
        }

        if( !empty($name_teacher) ) {
            $course_id = User::leftJoin('user_roles', 'user_roles.user_id', '=', 'users.id')
                                ->leftJoin('user_courses', 'user_courses.user_role_id', '=', 'user_roles.id')
                                ->where('user_courses.videos', '=', NULL)
                                ->where('users.name', 'like', '%' . $name_teacher . '%')
                                ->pluck('course_id');

            $query->whereIn('order_details.course_id', $course_id);
        }


        if( $datepicker_from != '') {
            $datepicker_from = Helper::formatDate('d/m/Y', $datepicker_from, 'Y-m-d') . ' 00:00:00';;

            if ($datepicker_to != '') {
                $datepicker_to = Helper::formatDate('d/m/Y', $datepicker_to, 'Y-m-d') . ' 23:59:59';;
            } else {
                $datepicker_to = date('Y-m-d') . ' 23:59:59';
            }
            
            $query->where(function($query_detail) use ($datepicker_from, $datepicker_to){
                $query_detail->whereBetween('orders.created_at', [$datepicker_from, $datepicker_to]);
            });
        }

        $query->selectRaw('orders.total_price, orders.id, orders.created_at, payments.name as payment_name')->groupBy('orders.id');
        
        $data = $query->get();
        $total = 0;
        // var_dump($data);
        foreach($data as  $value) {
            $total += $value->total_price;
        }

        return datatables()->of($query)
                ->addColumn('action', function ($order) {
                    return $order->id;
                })
                ->addColumn('rows', function ($order) {
                    return $order->id;
                })
                ->addColumn('code', function ($order) {
                    return  $order->id;
                })
                ->addColumn('total', function ($order) use ($total) {
                    return  $total;
                })
                // ->removeColumn('id')
                ->make(true);
    }

    public function detailOrder(Request $request)
    {
        $data = \DB::table('orders')
                    ->leftJoin('order_details', 'order_details.order_id', '=', 'orders.id')
                    ->leftJoin('payments', 'payments.id', '=', 'orders.payment_id')
                    ->leftJoin('user_roles', 'user_roles.id', '=', 'orders.user_id')
                    ->leftJoin('users', 'users.id', '=', 'user_roles.user_id')
                    ->selectRaw('orders.*, DATE_FORMAT(orders.created_at, "%d-%m-%Y %H:%i:%s") as created_at, payments.name as payment_name, users.name, users.address, users.phone, users.email')
                    ->where('orders.id', $request->order_id)
                    ->first();
        // dd($data);
        return response()->json(['data' => $data, 'status' => 200]);
    }
}