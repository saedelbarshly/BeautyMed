@extends('DoctorPanel.layouts.master')
@section('content')
<?php
    $month = date('m');
    $year = date('Y');
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

    <!-- Bordered table start -->
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">

                <div class="table-responsive">
                    <table class="table table-bordered mb-2">
                        <thead class="dark-table">
                            <tr>
                                <th width="30%" style="text-align:center;">مستحقات</th>
                                <th style="text-align:center;">المبلغ</th>
                                <th width="30%" style="text-align:center;">استقطاعات</th>
                                <th style="text-align:center;">المبلغ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>راتب ثابت</td>
                                <td>
                                    {{$user->currentMonthSalary($month,$year)}}
                                </td>
                                <td>
                                    <a href="javascript:;" data-bs-target="#management" data-bs-toggle="modal" class="btn btn-primary btn-sm">
                                        خصومات إدارية
                                    </a>
                                    @include('AdminPanel.hr.salaries.salaryDetailsIncludes.deductions',['deductionType'=>'management'])
                                </td>
                                <td>
                                    {{$user->monthDeductions()['management']}}
                                </td>
                            </tr>
                            <tr>
                                <td>إجمالي مبيعات</td>
                                <td>
                                    {{$user->mySales()}}
                                </td>
                                <td>
                                    <a href="javascript:;" data-bs-target="#onAccount" data-bs-toggle="modal" class="btn btn-primary btn-sm">
                                        سلفه
                                    </a>
                                    @include('AdminPanel.hr.salaries.salaryDetailsIncludes.deductions',['deductionType'=>'onAccount'])
                                </td>
                                <td>
                                    {{$user->monthDeductions()['onAccount']}}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a href="javascript:;" data-bs-target="#commission" data-bs-toggle="modal" class="btn btn-primary btn-sm">
                                        {{trans('common.commission')}}
                                    </a>
                                    @include('AdminPanel.hr.salaries.salaryDetailsIncludes.deductions',['deductionType'=>'commission'])
                                </td>
                                <td>
                                    {{$user->monthDeductions()['commission']}}
                                </td>
                                <td>
                                    <a href="javascript:;" data-bs-target="#attendance" data-bs-toggle="modal" class="btn btn-primary btn-sm">
                                        {{trans('common.absence')}}
                                    </a>
                                    @include('AdminPanel.hr.salaries.salaryDetailsIncludes.attendance')
                                </td>
                                <td>
                                    {{$user->monthAbsence($month, $year)}}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a href="javascript:;" data-bs-target="#incentive" data-bs-toggle="modal" class="btn btn-primary btn-sm">
                                        {{trans('common.incentive')}}
                                    </a>
                                    @include('AdminPanel.hr.salaries.salaryDetailsIncludes.deductions',['deductionType'=>'incentive'])
                                </td>
                                <td>
                                    {{$user->monthDeductions()['incentive']}}
                                </td>
                                <td>
                                    <a href="javascript:;" data-bs-target="#attendance" data-bs-toggle="modal" class="btn btn-primary btn-sm">
                                        {{trans('common.attendInLate')}}
                                    </a>
                                </td>
                                <td>
                                    {{$user->monthAttendanceStats($month,$year)['late']}} دقيقة
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a href="javascript:;" data-bs-target="#attendance" data-bs-toggle="modal" class="btn btn-primary btn-sm">
                                        {{trans('common.overTime')}}
                                    </a>
                                </td>
                                <td>
                                    {{$user->monthAttendanceStats($month,$year)['overTime']}} دقيقة
                                </td>
                                <td style="background-color:#666;color:#fff;text-align:center;">إجمالي راتب مستلم</td>
                                <td style="background-color:#666;color:#fff;text-align:center;">
                                    {{$user->monthSalary($month,$year)['delivered']}}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a href="javascript:;" data-bs-target="#reward" data-bs-toggle="modal" class="btn btn-primary btn-sm">
                                        {{trans('common.reward')}}
                                    </a>
                                    @include('AdminPanel.hr.salaries.salaryDetailsIncludes.deductions',['deductionType'=>'reward'])
                                </td>
                                <td>
                                    {{$user->monthDeductions()['reward']}}
                                </td>
                                <td style="background-color:#666;color:#fff;text-align:center;">إجمالي مستقطعات</td>
                                <td style="background-color:#666;color:#fff;text-align:center;">
                                    {{$user->monthSalary($month,$year)['minus']}}
                                </td>
                            </tr>
                            <tr>
                                <td style="background-color:#666;color:#fff;text-align:center;">إجمالي مستحقات</td>
                                <td style="background-color:#666;color:#fff;text-align:center;">
                                    {{$user->monthSalary($month,$year)['plus']}}
                                </td>
                                <td style="background-color:#666;color:#fff;text-align:center;">صافي الراتب</td>
                                <td style="background-color:#666;color:#fff;text-align:center;">
                                    {{$user->monthSalary($month,$year)['net']}}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <!-- Bordered table end -->

@stop


@section('page_buttons')
    @if(userCan('employees_account_pay_salary') && $active != 'mySalary')
        @include('AdminPanel.hr.salaries.PayMonthSalary')
    @endif
    <a href="javascript:;" data-bs-target="#searchSalaries" data-bs-toggle="modal" class="btn btn-primary btn-sm">
        {{trans('common.search')}}
    </a>

    <div class="modal fade text-md-start" id="searchSalaries" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered modal-edit-user">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-5 px-sm-5 pt-50">
                    {{Form::open(['id'=>'createRoleForm', 'method'=>'GET'])}}
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

@section('scripts')
    <script src="{{asset('AdminAssets/app-assets/js/scripts/pages/modal-add-role.js')}}"></script>
@stop