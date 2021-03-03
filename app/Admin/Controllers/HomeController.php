<?php

namespace App\Admin\Controllers;

use DateTime;   
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\AuthUser;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;

class HomeController extends Controller
{
    public function index(Content $content)
    {
        return $content
            ->title('Dashboard')
            ->description('Quản lý khách hàng...')
            ->row(Dashboard::title())
            ->row(function (Row $row) {
                $row->column(4, function (Column $column) {
                    $column->append(view('admin.charts.all', ["blocks" => Constant::BLOCK, "count" => Customer::groupBy('block_no')
                            ->selectRaw('count(*) as total, block_no')
                            ->get()]));
                });

                $row->column(4, function (Column $column) {
                    $column->append(view('admin.charts.status', ["status" => Constant::CUSTOMER_STATUS, "count" => Customer::groupBy('status')
                            ->selectRaw('count(*) as total, status')
                            ->get()]));
                });

                $row->column(4, function (Column $column) {
                    $column->append(view('admin.charts.sale', ["count" => Customer::groupBy('sale_id')
                            ->selectRaw('count(*) as total, sale_id')
                            ->get(), "countSaleNew" => Customer::where('status', '=', 0)->groupBy('sale_id')
                            ->selectRaw('count(*) as total, sale_id')
                            ->get()]
                    ));
                });
            })
            ->row(function (Row $row) {
                $row->column(4, function (Column $column) {
                    $column->append(view('admin.charts.salestatus', ["status" => Constant::CUSTOMER_STATUS, 
                    "count" => Customer::where("sale_id", Admin::user()->id)->groupBy('status')
                            ->selectRaw('count(*) as total, status')
                            ->get(),
                    "name" => Admin::user()->name]
                    ));
                });
            });
    }

    public function report(Content $content, Request $request)
    {
        $sale_id = $request->get('sale_id');
        $time = is_null($request->get('time')) ? 30 : $request->get('time');
        $dayBefore = (new DateTime())->modify('-'.$time.' day')->format('Y-m-d');

        $count =  Appointment::groupBy('app_date')
            ->selectRaw('count(*) as total, app_date')
            ->where('app_date', '>=', $dayBefore)
            ->where("type", '=', 0)
            ->get();
        
        $countShow = Appointment::groupBy('app_date')
        ->selectRaw('count(*) as total, app_date')
        ->where('app_date', '>=', $dayBefore)
        ->where('show', '!=', 0)
        ->get();

        $countSetup = Appointment::groupBy('app_date')
        ->selectRaw('count(*) as total, app_date')
        ->where('app_date', '>=', $dayBefore)
        ->where('setup', '!=', 0)
        ->get();

        $countDone = Appointment::groupBy('app_date')
        ->selectRaw('count(*) as total, app_date')
        ->where('app_date', '>=', $dayBefore)
        ->whereNotNull('done')
        ->get();

        if (!is_null($sale_id)){     
            $count =  Appointment::groupBy('app_date')
            ->selectRaw('count(*) as total, app_date')
            ->where('app_date', '>=', $dayBefore)
            ->where("type", '=', 0)
            ->where("sale_id", '=', $sale_id)
            ->get();

            $countShow = Appointment::groupBy('app_date')
            ->selectRaw('count(*) as total, app_date')
            ->where('app_date', '>=', $dayBefore)
            ->where("sale_id", '=', $sale_id)
            ->where('show', '!=', 0)
            ->get();
    
            $countSetup = Appointment::groupBy('app_date')
            ->selectRaw('count(*) as total, app_date')
            ->where('app_date', '>=', $dayBefore)
            ->where("sale_id", '=', $sale_id)
            ->where('setup', '!=', 0)
            ->get();
    
            $countDone = Appointment::groupBy('app_date')
            ->selectRaw('count(*) as total, app_date')
            ->where('app_date', '>=', $dayBefore)
            ->where("sale_id", '=', $sale_id)
            ->whereNotNull('done')
            ->get();
        }
        return $content
            ->title('Báo cáo')
            ->description('Báo cáo lịch hẹn...')
            ->row(Dashboard::title())
            ->row(function (Row $row) use ($time, $count, $sale_id, $countShow, $countSetup, $countDone) {
                $row->column(12, function (Column $column)  use ($time, $count, $sale_id, $countShow, $countSetup, $countDone) {
                    $column->append(view('admin.charts.report', ["blocks" => Constant::BLOCK, 
                            "sales" => AuthUser::all()->pluck('name','id'),
                            "time" => $time,
                            "sale_id" => $sale_id,
                            "count" => $count,
                            "countShow" => $countShow,
                            "countSetup" => $countSetup,
                            "countDone" => $countDone]));
                });
            });
    }
}
