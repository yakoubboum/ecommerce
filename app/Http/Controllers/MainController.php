<?php

namespace App\Http\Controllers;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        $chart_options = [
            'chart_title' => 'products by day',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Product',
            'group_by_field' => 'created_at',
            'group_by_period' => 'day',
            'chart_type' => 'bar',
        ];
        $chart1 = new LaravelChart($chart_options);

        return view('Dashboard.Admin.dashboard',\compact('chart1'));
    }
}
