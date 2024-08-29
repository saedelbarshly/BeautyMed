@extends('DoctorPanel.layouts.master')
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

    $totalSalaries = salariesStats($branch, $month, $year);
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
                        <h2 class="fw-bolder">{{number_format(round($totalSalaries['basic']))}}</h2>
                        <p class="card-text">{{trans('common.sallary')}}</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4 col-sm-6">
                <div class="card text-center">
                    <div class="card-body">
                        <h2 class="fw-bolder">{{number_format(round($totalSalaries['plus']))}}</h2>
                        <p class="card-text">{{trans('common.addons')}}</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4 col-sm-6">
                <div class="card text-center">
                    <div class="card-body">
                        <h2 class="fw-bolder">{{number_format(round($totalSalaries['minus']))}}</h2>
                        <p class="card-text">{{trans('common.deductions')}}</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4 col-sm-6">
                <div class="card text-center">
                    <div class="card-body">
                        <h2 class="fw-bolder">{{number_format(round($totalSalaries['delivered']))}}</h2>
                        <p class="card-text">{{trans('common.receviedSalary')}}</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4 col-sm-6">
                <div class="card text-center">
                    <div class="card-body">
                        <h2 class="fw-bolder">{{number_format(round($totalSalaries['net']))}}</h2>
                        <p class="card-text">{{trans('common.net')}}</p>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Stats Vertical Card -->
    </section>

    <div class="divider">
        <div class="divider-text">{{trans('common.salariesTable')}}</div>
    </div>
    <!-- Bordered table start -->
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>{{trans('common.name')}}</th>
                                <th class="text-center">{{trans('common.sallary')}}</th>
                                <th class="text-center">{{trans('common.addons')}}</th>
                                <th class="text-center">{{trans('common.deductions')}}</th>
                                <th class="text-center">{{trans('common.receviedSalary')}}</th>
                                <th class="text-center">{{trans('common.net')}}</th>
                                <th class="text-center">{{trans('common.actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr id="row_{{$user->id}}">
                                    <td>
                                        {{$user['name']}}
                                    </td>
                                    <td class="text-center">
                                        {{$user->monthSalary($month,$year)['basic']}}
                                    </td>
                                    <td class="text-center">
                                        {{$user->monthSalary($month,$year)['plus']}}
                                    </td>
                                    <td class="text-center">
                                        {{$user->monthSalary($month,$year)['minus']}}
                                    </td>
                                    <td class="text-center">
                                        {{$user->monthSalary($month,$year)['delivered']}}
                                    </td>
                                    <td class="text-center">
                                        {{$user->monthSalary($month,$year)['net']}}
                                    </td>
                                    <td class="text-center text-nowrap">
                                        <button type="button" class="btn btn-icon dropdown-toggle hide-arrow btn-danger" data-bs-toggle="dropdown">
                                            <i data-feather="more-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="javascript:;" data-bs-target="#vacationPermission{{$user->id}}" data-bs-toggle="modal" class="dropdown-item">
                                                <span>{{trans('common.vacationPermission')}}</span>
                                            </a>
                                            <a href="javascript:;" data-bs-target="#attendancePermission{{$user->id}}" data-bs-toggle="modal" class="dropdown-item">
                                                <span>{{trans('common.attendancePermission')}}</span>
                                            </a>
                                        </div>

                                        <a href="{{route('admin.EmployeeSalary',$user->id)}}" class="btn btn-icon btn-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.view')}}">
                                            <i data-feather='eye'></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-3 text-center ">
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
    @foreach($users as $user)
        @if(userCan('attendance_vacation_create'))
            @include('AdminPanel.hr.salaries.CreateVacation',['user'=>$user])
        @endif
        @if(userCan('attendance_permission_create'))
            @include('AdminPanel.hr.salaries.CreatePermission',['user'=>$user])
        @endif
    @endforeach
@stop


@section('page_buttons')
    @if(userCan('employees_account_add_deduction'))
        @include('AdminPanel.hr.salaries.CreateDeduction')
    @endif
    <a href="javascript:;" data-bs-target="#searchSalaries" data-bs-toggle="modal" class="btn btn-primary btn-sm">
        {{trans('common.search')}}
    </a>

    <div class="modal fade text-md-start" id="searchSalaries" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-5 px-sm-5 pt-50">
                    {{Form::open(['id'=>'createRoleForm', 'class'=>'row gy-1 pt-75', 'method'=>'GET'])}}
                        <div class="col-12 col-md-3">
                            <label class="form-label" for="month">{{trans('common.month')}}</label>
                            {{Form::select('month',monthArray(session()->get('Lang')),isset($_GET['month']) ? $_GET['month'] : date('m'),['id'=>'month', 'class'=>'form-select'])}}
                        </div>
                        <div class="col-12 col-md-3">
                            <label class="form-label" for="year">{{trans('common.year')}}</label>
                            {{Form::select('year',yearArray(),isset($_GET['year']) ? $_GET['year'] : date('Y'),['id'=>'year', 'class'=>'form-select'])}}
                        </div>
                        <div class="col-12 col-md-3">
                            <label class="form-label" for="status">{{trans('common.status')}}</label>
                            {{Form::select('status',['all'=>'الجميع'] + employeeStatusArray('ar'),isset($_GET['status']) ? $_GET['status'] : date('Y'),['id'=>'status', 'class'=>'form-select'])}}
                        </div>
                        @if(env('APP_BRANCH') == 1) && userCan('employees_account_view'))
                            <div class="col-12 col-md-3">
                                <label class="form-label" for="branch_id">{{trans('common.branch')}}</label>
                                <?php $branchesList = App\Models\Branches::orderBy('name','asc')->pluck('name','id')->all(); ?>
                                {{Form::select('branch_id',['all'=>'الجميع'] + $branchesList,isset($_GET['branch_id']) ? $_GET['branch_id'] : '',['id'=>'branch_id', 'class'=>'form-select'])}}
                            </div>
                        @endif
                        <div class="col-12 col-md-3">
                                <label class="form-label" for="role_id">{{trans('common.role')}}</label>
                                <?php $rolesList = App\Models\roles::whereIn('id',[1,2])->orderBy('name_ar','asc')->pluck('name_ar','id')->all(); ?>
                                {{Form::select('role',['all'=>'الجميع'] + $rolesList,isset($_GET['role']) ? $_GET['role'] : '',['id'=>'role', 'class'=>'form-select'])}}
                        </div>
                        <div class="col-12 text-center mt-2 pt-50">
                            <button type="submit" class="btn btn-primary me-1">{{trans('common.search')}}</button>
                            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                                {{trans('common.Cancel')}}
                            </button>
                        </div>
                    {{Form::close()}}
                </div>
            </div>
        </div>
    </div>
@stop
