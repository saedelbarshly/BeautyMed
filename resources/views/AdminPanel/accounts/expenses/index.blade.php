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
    if (isset($_GET['Type'])) {
        if ($_GET['Type'] != '') {
            $branch = $_GET['Type'];
        }
    }
    if (isset($_GET['employee'])) {
        if ($_GET['employee'] != '') {
            $safeId = $_GET['employee'];
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
                    <?php $dayExpenses = App\Models\Expenses::where('ExpenseDate',date('Y-m-d'))->whereNotIn('Type', ['withdrawal','transfeerToAnother'])->sum('Expense'); ?>
                        <h2 class="fw-bolder"> {{ $dayExpenses}}</h2>
                        <p class="card-text">{{trans('common.totalDayExpenses')}}</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4 col-sm-6">
                <div class="card text-center">
                    <div class="card-body">
                    <?php $monthExpenses = App\Models\Expenses::where('month',$month)->whereNotIn('Type',['withdrawal','transfeerToAnother'])->sum('Expense');?>
                        <h2 class="fw-bolder"> {{ $monthExpenses}}</h2>
                        <p class="card-text">{{trans('common.monthExpenses')}}</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4 col-sm-6">
                <div class="card text-center">
                    <div class="card-body">
                        <h2 class="fw-bolder">{{round(expensesTotals($branch, $month, $year)['management'])}}</h2>
                        <p class="card-text">{{trans('common.totalExpenses')}}</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4 col-sm-6">
                <div class="card text-center">
                    <div class="card-body">
                        <h2 class="fw-bolder">{{round(expensesTotals($branch, $month, $year)['salaries'])}}</h2>
                        <p class="card-text">{{trans('common.totalSalaries')}}</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4 col-sm-6">
                <div class="card text-center">
                    <div class="card-body">
                        <h2 class="fw-bolder">{{round(expensesTotals($branch, $month, $year)['withdrawal'])}}</h2>
                        <p class="card-text">{{trans('common.totalWithdrowals')}}</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4 col-sm-6">
                <div class="card text-center">
                    <div class="card-body">
                        <h2 class="fw-bolder">{{round(expensesTotals($branch, $month, $year)['total'])}}</h2>
                        <p class="card-text">{{trans('common.totalOutcome')}}</p>
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
        <div class="divider-text">{{trans('common.expensesTable')}}</div>
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
                                <th class="text-center">{{trans('common.expensesDetails')}}</th>
                                @if(userCan('expenses_edit') || userCan('expenses_delete'))
                                    <th class="text-center">{{trans('common.actions')}}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($expenses as $expense)
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
                                    @if(userCan('expenses_edit') || userCan('expenses_delete'))
                                        <td class="text-center">
                                            @if(userCan('expenses_edit'))
                                                <a href="javascript:;" data-bs-target="#editExpense{{$expense->id}}" data-bs-toggle="modal" class="btn btn-icon btn-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.edit')}}">
                                                    <i data-feather='edit'></i>
                                                </a>
                                            @endif

                                            @if(userCan('expenses_delete'))
                                                <?php $delete = route('admin.expenses.delete',['id'=>$expense->id]); ?>
                                                <button type="button" class="btn btn-icon btn-danger" onclick="confirmDelete('{{$delete}}','{{$expense->id}}')">
                                                    <i data-feather='trash-2'></i>
                                                </button>
                                            @endif
                                        </td>
                                    @endif
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

@if(userCan('expenses_edit'))

    @foreach($expenses as $expense)
        <div class="modal fade text-md-start" id="editExpense{{$expense->id}}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-expense">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pb-5 px-sm-5 pt-50">
                        <div class="text-center mb-2">
                            <h1 class="mb-1">{{trans('common.edit')}}: {{$expense['name_'.session()->get('Lang')]}}</h1>
                        </div>
                        {{Form::open(['files'=>'true','url'=>route('admin.expenses.update',$expense->id), 'id'=>'editExpenseForm'.$expense->id, 'class'=>'row gy-1 pt-75'])}}
                            <div class="col-12 col-md-4">
                                <label class="form-label" for="ExpenseDate">{{trans('common.date')}}</label>
                                {{Form::date('ExpenseDate',$expense->ExpenseDate,['id'=>'ExpenseDate', 'class'=>'form-control','required'])}}
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label" for="Expense">{{trans('common.amount')}}</label>
                                {{Form::number('Expense',$expense->Expense,['step'=>'.01','id'=>'Expense', 'class'=>'form-control','required'])}}
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label" for="Type">{{trans('common.type')}}</label>
                                {{Form::select('Type',expensesTypes(session()->get('Lang')),$expense->Type,['id'=>'Type', 'class'=>'form-select','required'])}}
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label" for="service_id">{{trans('common.service')}}</label>
                                {{Form::select('service_id', ['0'=>'بدون تحديد'] + serviceList(),$expense->service_id,['id'=>'service_id', 'class'=>'form-control','required'])}}
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label" for="safe_id">{{trans('common.safe')}}</label>
                                {{Form::select('safe_id',safesList(),$expense->safe_id,['id'=>'safe_id', 'class'=>'form-select','required'])}}
                            </div>
                            <div class="col-12 col-md-12">
                                <label class="form-label" for="Des">{{trans('common.expensesDetails')}}</label>
                                {{Form::textarea('Des',$expense->Des,['rows'=>'2','id'=>'Des', 'class'=>'form-control','required'])}}
                            </div>

                            <div class="divider">
                                <div class="divider-text">{{trans('common.files')}}</div>
                            </div>

                            <div class="row d-flex justify-content-center">
                                <div class="col-md-12 text-center">
                                    <label class="form-label" for="attachment">{{trans('common.attachment')}}</label>
                                    @if($expense->Attachments != '')
                                        <div class="row mb-2">
                                            {!!$expense->attachmentsHtml()!!}
                                        </div>
                                    @endif
                                    <div class="file-loading">
                                        <input class="files" name="Attachments[]" type="file" multiple>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 text-center mt-2 pt-50">
                                <button type="submit" class="btn btn-primary me-1">{{trans('common.Save changes')}}</button>
                                <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                                    {{trans('common.Cancel')}}
                                </button>
                            </div>
                        {{Form::close()}}
                    </div>
                </div>
            </div>
        </div>
    @endforeach

@endif

@stop

@section('page_buttons')
    @if(userCan('expenses_create'))
        @include('AdminPanel.accounts.expenses.create')
    @endif
    <a href="{{route('admin.expensesTypes')}}" class="btn btn-danger btn-sm">
        {{trans('common.expensesTypes')}}
    </a>

    <div class="modal fade text-md-start" id="searchSalaries" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-expense">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-5 px-sm-5 pt-50">
                    {{Form::open(['files'=>'true','id'=>'createexpenseForm', 'class'=>'row gy-1 pt-75', 'method'=>'GET'])}}
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-3">
                            <label class="form-label" for="month">{{trans('common.month')}}</label>
                            {{Form::select('month',monthArray(session()->get('Lang')),isset($_GET['month']) ? $_GET['month'] : date('m'),['id'=>'month', 'class'=>'form-select'])}}
                        </div>
                        <div class="col-12 col-md-3">
                            <label class="form-label" for="year">{{trans('common.year')}}</label>
                            {{Form::select('year',yearArray(),isset($_GET['year']) ? $_GET['year'] : date('Y'),['id'=>'year', 'class'=>'form-select'])}}
                        </div>
                        <div class="col-12 col-md-3">
                            <label class="form-label" for="employee">{{trans('common.employee')}}</label>
                            {{Form::select('employee',usersList(),isset($_GET['employee']) ? $_GET['employee'] : date('Y'),['id'=>'employee', 'class'=>'form-select'])}}
                        </div>
                        <div class="col-12 col-md-3">
                            <label class="form-label" for="Type">{{trans('common.type')}}</label>
                            {{Form::select('Type',expensesTypes(session()->get('Lang')),isset($_GET['Type']) ? $_GET['Type'] : date('Y'),['id'=>'Type', 'class'=>'form-select'])}}
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
