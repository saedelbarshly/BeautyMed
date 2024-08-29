@extends('AdminPanel.layouts.master')
@section('content')
<?php
    $month = date('m');
    $year = date('Y');
    $branch = 'all';
    if (isset($_GET['month'])) {
        if ($_GET['month'] != '') {
            $month = $_GET['month'];
        }
    }
    if (isset($_GET['year'])) {
        if ($_GET['year'] != '') {
            $year = $_GET['year'];
        }
    }
    if (isset($_GET['branch_id'])) {
        if ($_GET['branch_id'] != '') {
            $branch = $_GET['branch_id'];
        }
    }
?>

<div class="row match-height">
    <!-- Revenue Card -->
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-center align-items-center">
                <h4 class="card-title text-center">
                    {{trans('common.expensesRevenueChart')}}
                    <br>
                    <small class="text-muted">{{trans('common.month')}}: {{$month}}</small>
                    <small class="text-muted">{{trans('common.year')}}: {{$year}}</small>
                </h4>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-center mb-3 text-center">
                    <div class="me-2">
                        <p class="card-text mb-50">{{trans('common.totalOutcome')}}</p>
                        <h3 class="fw-bolder">
                            <sup class="font-medium-1 fw-bold">{{trans('common.L.E')}}</sup>
                            <span class="text-danger">{{round(expensesTotals($branch, $month, $year)['total'])}}</span>
                        </h3>
                    </div>
                    <div class="me-2">
                        <p class="card-text mb-50">{{trans('common.totalIncome')}}</p>
                        <h3 class="fw-bolder">
                            <sup class="font-medium-1 fw-bold">{{trans('common.L.E')}}</sup>
                            <span class="text-success">{{round(revenuesTotals($branch, $month, $year)['total'])}}</span>
                        </h3>
                    </div>
                    <div>
                        <p class="card-text mb-50">{{trans('common.net')}}</p>
                        <h3 class="fw-bolder">
                            <sup class="font-medium-1 fw-bold">{{trans('common.L.E')}}</sup>
                            <span class="text-primary">{{round(revenuesTotals($branch, $month, $year)['total'] - expensesTotals($branch, $month, $year)['total'])}}</span>
                        </h3>
                    </div>
                </div>
                <div id="revenue-chart"></div>
            </div>
        </div>
    </div>
    <!--/ Revenue Card -->
</div>

<div class="row match-height">
    <!-- Revenue Card -->
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-center align-items-center">
                <h4 class="card-title text-center">
                    {{trans('common.expensesRevenueThisYear')}}
                    <br>
                    <small class="text-muted">{{trans('common.year')}}: {{$year}}</small>
                </h4>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-center mb-3 text-center">
                    <div class="me-2">
                        <p class="card-text mb-50">{{trans('common.totalOutcome')}}</p>
                        <h3 class="fw-bolder">
                            <sup class="font-medium-1 fw-bold">{{trans('common.L.E')}}</sup>
                            <span class="text-danger">{{round(expensesTotals($branch, $month, $year)['yearTotal'])}}</span>
                        </h3>
                    </div>
                    <div class="me-2">
                        <p class="card-text mb-50">{{trans('common.totalIncome')}}</p>
                        <h3 class="fw-bolder">
                            <sup class="font-medium-1 fw-bold">{{trans('common.L.E')}}</sup>
                            <span class="text-success">{{round(revenuesTotals($branch, $month, $year)['yearTotal'])}}</span>
                        </h3>
                    </div>
                    <div>
                        <p class="card-text mb-50">{{trans('common.net')}}</p>
                        <h3 class="fw-bolder">
                            <sup class="font-medium-1 fw-bold">{{trans('common.L.E')}}</sup>
                            <span class="text-primary">{{round(revenuesTotals($branch, $month, $year)['yearTotal'] - expensesTotals($branch, $month, $year)['yearTotal'])}}</span>
                        </h3>
                    </div>
                </div>
                <table class="table table-bordered mb-2">
                    <thead class="dark-table">
                        <tr>
                            <th>{{trans('common.month')}}</th>
                            <th class="text-center">{{trans('common.revenues')}}</th>
                            <th class="text-center">{{trans('common.expenses')}}</th>
                            <th class="text-center">{{trans('common.net')}}</th>
                            <th class="text-center">{{trans('common.actions')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $totalNetForAll = $totalRevenueForAll = $totalExpensesForAll = 0; ?>
                        @foreach(allMonthsArray() as $singleMonth)
                            <tr>
                                <td>
                                    {{arabicMonth($singleMonth).', '.date('Y',strtotime($singleMonth))}}
                                </td>
                                <td class="text-center">
                                    <?php $thisMonthRevenue = round(revenuesTotals($branch, date('m',strtotime($singleMonth)), date('Y',strtotime($singleMonth)))['total']); ?>
                                    {{number_format($thisMonthRevenue)}}
                                    <?php $totalRevenueForAll += $thisMonthRevenue;?>
                                </td>
                                <td class="text-center">
                                    <?php $thisMonthExpenses = round(expensesTotals($branch, date('m',strtotime($singleMonth)), date('Y',strtotime($singleMonth)))['total']); ?>
                                    {{number_format($thisMonthExpenses)}}
                                    <?php $totalExpensesForAll += $thisMonthExpenses;?>
                                </td>
                                <td class="text-center">
                                    {{number_format($thisMonthRevenue - $thisMonthExpenses)}}
                                    <?php $totalNetForAll += ($thisMonthRevenue - $thisMonthExpenses); ?>
                                </td>
                                <td class="text-center">
                                    <a href="{{route('admin.accountsReport',['month'=>date('m',strtotime($singleMonth)), 'year'=>date('Y',strtotime($singleMonth)), 'branch_id'=>$branch])}}" class="btn btn-icon btn-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.view')}}">
                                        <i data-feather='eye'></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td>{{trans('common.totals')}}</td>
                            <td>{{number_format($totalRevenueForAll)}}</td>
                            <td>{{number_format($totalExpensesForAll)}}</td>
                            <td colspan="2">{{number_format($totalRevenueForAll - $totalExpensesForAll)}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!--/ Revenue Card -->
</div>
@stop

@section('page_buttons')
    <a href="javascript:;" data-bs-target="#searchunits" data-bs-toggle="modal" class="btn btn-primary btn-sm">
        {{trans('common.search')}}
    </a>

    <div class="modal fade text-md-start" id="searchunits" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-unit">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-5 px-sm-5 pt-50">
                    {{Form::open(['id'=>'createunitForm', 'class'=>'row gy-1 pt-75', 'method'=>'GET'])}}
                    <div class="row justify-content-center">
                    <div class="col-12 col-md-4">
                            <label class="form-label" for="month">{{trans('common.month')}}</label>
                            {{Form::select('month',monthArray(session()->get('Lang')),isset($_GET['month']) ? $_GET['month'] : date('m'),['id'=>'month', 'class'=>'form-select'])}}
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label" for="year">{{trans('common.year')}}</label>
                            {{Form::select('year',yearArray(),isset($_GET['year']) ? $_GET['year'] : date('Y'),['id'=>'year', 'class'=>'form-select'])}}
                        </div>
                        @if(userCan('expenses_view_branch') && userCan('revenues_view_branch'))
                            <div class="col-12 col-md-4">
                                <label class="form-label" for="branch_id">{{trans('common.branch')}}</label>
                                <?php $branchesList = App\Models\Branches::orderBy('name','asc')->pluck('name','id')->all(); ?>
                                {{Form::select('branch_id',['all'=>'الجميع'] + $branchesList,isset($_GET['branch_id']) ? $_GET['branch_id'] : '',['id'=>'branch_id', 'class'=>'form-select'])}}
                            </div>
                        @endif


                        <div class="col-12 text-center mt-2 pt-50">
                            <button type="submit" class="btn btn-primary me-1">{{trans('common.search')}}</button>
                            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                                {{trans('common.Cancel')}}
                            </button>
                        </div>
                    </div>
                    {{Form::close()}}
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <!-- BEGIN: Page Vendor JS-->
    <script src="{{asset('AdminAssets/app-assets/vendors/js/charts/apexcharts.min.js')}}"></script>
    <!-- END: Page Vendor JS-->
    <script>
        $(window).on('load', function () {
            'use strict';
            var $textHeadingColor = '#5e5873';
            var $strokeColor = '#ebe9f1';
            var $labelColor = '#e7eef7';
            var $avgSessionStrokeColor2 = '#ebf0f7';
            var $budgetStrokeColor2 = '#dcdae3';
            var $goalStrokeColor2 = '#51e5a8';
            var $revenueStrokeColor2 = '#d0ccff';
            var $textMutedColor = '#b9b9c3';
            var $salesStrokeColor2 = '#df87f2';
            var $white = '#fff';
            var $earningsStrokeColor2 = '#28c76f66';
            var $earningsStrokeColor3 = '#28c76f33';

            var revenueChartOptions;
            var revenueChart;
            var $revenueChart = document.querySelector('#revenue-chart');

            revenueChartOptions = {
                chart: {
                    height: 240,
                    toolbar: { show: false },
                    zoom: { enabled: false },
                    type: 'line',
                    offsetX: -10
                },
                stroke: {
                    curve: 'smooth', //straight
                    dashArray: [0, 0],
                    width: [2, 2]
                },
                grid: {
                    borderColor: $labelColor
                },
                legend: {
                    show: false
                },
                colors: ['#f55d5d','#2be35b'],
                fill: {
                    type: 'gradient',
                    gradient: {
                        shade: 'dark',
                        inverseColors: false,
                        gradientToColors: ['#f55d5d', '#2be35b'],
                        shadeIntensity: 1,
                        type: 'horizontal',
                        opacityFrom: 1,
                        opacityTo: 1,
                        stops: [0, 100, 100, 100]
                    }
                },
                markers: {
                    size: 0,
                    hover: {
                        size: 5
                    }
                },
                xaxis: {
                    labels: {
                        style: {
                            colors: $textMutedColor,
                            fontSize: '1rem'
                        }
                    },
                    axisTicks: {
                        show: false
                    },
                    categories: [{{daysForChart($month, $year)}}],
                    axisBorder: {
                        show: false
                    },
                    tickPlacement: 'on'
                },
                yaxis: {
                    tickAmount: 5,
                    labels: {
                        style: {
                        colors: $textMutedColor,
                        fontSize: '1rem'
                        },
                        formatter: function (val) {
                            return val > 999 ? (val / 1000).toFixed(0) + '{{trans("common.thousandChart")}}' : val;
                        }
                    }
                },
                grid: {
                    padding: {
                        top: -20,
                        bottom: -10,
                        left: 20
                    }
                },
                tooltip: {
                    x: { show: false }
                },
                series: [
                    {
                        name: '{{trans("common.totalOutcome")}}',
                        data: [{{expensesForChart($branch, $month, $year)}}]
                    },
                    {
                        name: '{{trans("common.totalIncome")}}',
                        data: [{{revenueForChart($branch, $month, $year)}}]
                    }
                ]
            };
            revenueChart = new ApexCharts($revenueChart, revenueChartOptions);
            revenueChart.render();
        });
    </script>
@stop
