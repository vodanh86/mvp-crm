<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
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
}
