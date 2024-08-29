@extends('AdminPanel.layouts.master')
@section('content')
<?php

use App\Models\Reservation;

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

?>

    <section id="statistics-card">
        <div class="divider">
            <div class="divider-text">{{trans('common.totals')}}</div>
        </div>
        <!-- Stats Vertical Card -->
        <div class="row justify-content-center">

            <div class="col-xl-2 col-md-4 col-sm-6">
                <div class="card text-center">
                    <div class="card-body">
                        <h2 class="fw-bolder"> {{ $service->totals($year,$month)['expenses'] }} </h2>
                        <p class="card-text">{{trans('common.serviceExpenses')}}</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4 col-sm-6">
                <div class="card text-center">
                    <div class="card-body">
                        <h2 class="fw-bolder">{{ $service->totals($year,$month)['revenues'] }} </h2>
                        <p class="card-text">{{trans('common.serviceRevenues')}}</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4 col-sm-6">
                <div class="card text-center">
                    <div class="card-body">
                        <h2 class="fw-bolder">  {{ $service->totals($year,$month)['reservationsCount'] }} </h2>
                        <p class="card-text">{{trans('common.serviceClients')}}</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4 col-sm-6 text-center">
                <a href="javascript:;" data-bs-target="#searchSalaries" data-bs-toggle="modal" class="btn btn-relief-primary btn-lg py-2 pb-3 px-3">
                    <h1 class="text-white">
                        {{trans('common.search')}}
                    </h1>
                </a>
            </div>

        </div>
        <!--/ Stats Vertical Card -->
    </section>


    <div class="divider">
        <div class="divider-text">{{trans('common.serviceExpenses')}}</div>
    </div>
    <!-- Bordered table start -->
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>{{trans('common.date')}}</th>
                                <th class="text-center">{{trans('common.type')}}</th>
                                <th class="text-center">{{trans('common.user')}}</th>
                                <th class="text-center">{{trans('common.amount')}}</th>
                                <th class="text-center">{{trans('common.detailsExpenses')}}</th>

                            </tr>
                        </thead>
                        <tbody>
                            @forelse($service->expenses as $expense)
                                <tr id="row_{{$expense->id}}">
                                    <td>
                                        {{$expense['ExpenseDate']}}
                                    </td>
                                    <td class="text-center">
                                        {{$expense->typeText()}}
                                    </td>
                                    <td class="text-center">
                                        {{$expense->responsible->name ?? '-'}}
                                    </td>
                                    <td class="text-center">
                                        {{$expense->Expense}}
                                    </td>
                                    <td class="text-center">
                                        {!!$expense->Des!!}
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-3 text-center ">
                                        <h2>{{trans('common.nothingToView')}}</h2>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <!-- Bordered table end -->









    <div class="divider">
        <div class="divider-text">{{trans('common.serviceRevenues')}}</div>
    </div>
    <!-- Bordered table start -->
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th class="text-center">{{trans('common.date')}}</th>
                                <th class="text-center">{{trans('common.amount')}}</th>
                                <th class="text-center">{{trans('common.details')}}</th>

                            </tr>
                        </thead>
                        <tbody>
                            @forelse($service->totals($year,$month)['reservationsArr'] as $reservation)
                                <tr id="row_{{$reservation->id}}">
                                    <td>
                                       {{ $reservation->reservation_id }}
                                    </td>
                                    <td class="text-center">
                                       {{ $reservation->date }}
                                    </td>
                                    <td class="text-center">
                                        {{ $reservation->note }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-3 text-center ">
                                        <h2>{{trans('common.nothingToView')}}</h2>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <!-- Bordered table end -->


@stop


@section('page_buttons')
    <div class="modal fade text-md-start" id="searchSalaries" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-expense">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-5 px-sm-5 pt-50">
                    {{Form::open(['files'=>'true','id'=>'createexpenseForm', 'class'=>'row gy-1 pt-75', 'method'=>'GET'])}}
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-4">
                            <label class="form-label" for="month">{{trans('common.month')}}</label>
                            {{Form::select('month',monthArray(session()->get('Lang')),isset($_GET['month']) ? $_GET['month'] : date('m'),['id'=>'month', 'class'=>'form-select'])}}
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label" for="year">{{trans('common.year')}}</label>
                            {{Form::select('year',yearArray(),isset($_GET['year']) ? $_GET['year'] : date('Y'),['id'=>'year', 'class'=>'form-select'])}}
                        </div>
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
