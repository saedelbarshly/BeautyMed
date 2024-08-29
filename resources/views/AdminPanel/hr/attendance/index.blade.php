@extends('AdminPanel.layouts.master')
@section('content')
<?php
    $date = date('d-m-Y');
    if (isset($_GET['date'])) {
        if ($_GET['date'] != '') {
            $date = $_GET['date'];
        }
    }
?>


    <div class="divider">
        <div class="divider-text">{{trans('common.attendanceList')}}</div>
    </div>
    <!-- Bordered table start -->
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">

                <div class="table-responsive">
                    <table class="table table-bordered mb-2">
                        <thead class="table-dark">
                            <tr>
                                <th>{{trans('common.name')}}</th>
                                <th class="text-center">{{trans('common.attendIn')}}</th>
                                <th class="text-center">{{trans('common.attendInLate')}}</th>
                                <th class="text-center">{{trans('common.attendOut')}}</th>
                                <th class="text-center">{{trans('common.attendOutEarly')}}</th>
                                <th class="text-center">{{trans('common.attendOutLate')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr id="row_{{$user->id}}">
                                    <td>
                                        {{$user['name']}}
                                    </td>
                                    <td class="text-center">
                                        @if($user->todayAttendance($date) != '')
                                            {{$user->todayAttendance($date)->CheckIn ?? '-'}}
                                        @else
                                            <a href="{{route('admin.attendance.employee.attend',[$user->id,$date])}}" class="btn btn-sm btn-success">
                                                إثبات حضور
                                            </a>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        {{$user->todayAttendance($date)->late ?? '-'}}
                                    </td>
                                    <td class="text-center">
                                        @if($user->todayAttendance($date) != '')
                                            @if($user->todayAttendance($date)->CheckOut != '')
                                                {{$user->todayAttendance($date)->CheckOut ?? '-'}}
                                            @else
                                                <a href="{{route('admin.attendance.employee.go',[$user->id,$date])}}" class="btn btn-sm btn-success">
                                                    إثبات انصراف
                                                </a>
                                            @endif
                                        @else
                                            {{$user->todayAttendance($date)->CheckOut ?? '-'}}
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        {{$user->todayAttendance($date) != '' ? $user->todayAttendance($date)->earlyOutCalculator() : '-'}}
                                    </td>
                                    <td class="text-center">
                                        {{$user->todayAttendance($date)->OverTime ?? '-'}}
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
    @if(userCan('attendance_upload_excel'))
        @include('AdminPanel.hr.attendance.uploadAttendanceExcel')
    @endif
    <a href="javascript:;" data-bs-target="#searchAttendance" data-bs-toggle="modal" class="btn btn-primary btn-sm">
        {{trans('common.search')}}
    </a>

    <div class="modal fade text-md-start" id="searchAttendance" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-5 px-sm-5 pt-50">
                    {{Form::open(['id'=>'createRoleForm', 'class'=>'row gy-1 pt-75', 'method'=>'GET'])}}
                        <div class="col-12 col-md-3">
                            <label class="form-label" for="date">{{trans('common.date')}}</label>
                            {{Form::date('date',isset($_GET['date']) ? $_GET['date'] : date('m'),['id'=>'date', 'class'=>'form-select'])}}
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

@section('scripts')
<script src="{{asset('AdminAssets/app-assets/js/scripts/pages/modal-add-role.js')}}"></script>
@stop
