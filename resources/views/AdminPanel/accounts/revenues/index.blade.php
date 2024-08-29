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
            $branch= $_GET['branch_id'];
        }
    }

    if (isset($_GET['safe_id'])) {
        if ($_GET['safe_id'] != '') {
            $safeId = $_GET['safe_id'];
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
                        <h2 class="fw-bolder">{{round(revenuesTotals($branch, $month, $year)['monthTotal'])}}</h2>
                        <p class="card-text">{{trans('common.monthRevenues')}}</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4 col-sm-6">
                <div class="card text-center">
                    <div class="card-body">
                        <h2 class="fw-bolder">{{round(revenuesTotals($branch, $month, $year)['dayRevenues'])}}</h2>
                        <p class="card-text">{{trans('common.dayRevenues')}}</p>
                    </div>
                </div>
            </div>

            <div class="col-xl-2 col-md-4 col-sm-6">
                <div class="card text-center">
                    <div class="card-body">
                        <h2 class="fw-bolder">{{round(revenuesTotals($branch, $month, $year)['revenuesTD'])}}</h2>
                        <p class="card-text">{{trans('common.totalRevenues')}}</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4 col-sm-6">
                <div class="card text-center">
                    <div class="card-body">
                        <h2 class="fw-bolder">{{round(revenuesTotals($branch, $month, $year)['deposits'])}}</h2>
                        <p class="card-text">{{trans('common.totalDeposits')}}</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4 col-sm-6">
                <div class="card text-center">
                    <div class="card-body">
                        <h2 class="fw-bolder">{{round(revenuesTotals($branch, $month, $year)['totalTD'])}}</h2>  
                        <p class="card-text">{{trans('common.totalIncome')}}</p>
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
                                <th>{{trans('common.date')}}</th>
                                <th class="text-center">{{trans('common.type')}}</th>
                                <th class="text-center">{{trans('common.user')}}</th>
                                <th class="text-center">{{trans('common.amount')}}</th>
                                <th class="text-center">{{trans('common.payment_method')}}</th>
                                <th class="text-center">{{trans('common.detailsRevenues')}}</th>
                                @if(userCan('revenues_edit') || userCan('revenues_delete'))
                                    <th class="text-center">{{trans('common.actions')}}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($revenues as $revenue)
                                <tr id="row_{{$revenue->id}}">
                                    <td>
                                        {{$revenue['Date']}}
                                    </td>
                                    <td class="text-center">
                                        {{$revenue->typeText()}}
                                    </td>
                                    <td class="text-center">
                                        {{$revenue->responsible->name ?? '-'}}
                                    </td>
                                    <td class="text-center">
                                        {{$revenue->amount}}
                                    </td>
                                    <td class="text-center">
                                        {{$revenue->Type}}
                                    </td>
                                    <td class="text-center">
                                        {{$revenue->Notes}}
                                    </td>
                                    @if(userCan('revenues_edit') || userCan('revenues_delete'))
                                        <td class="text-center">
                                            @if(userCan('revenues_edit'))
                                                <a href="javascript:;" data-bs-target="#editRevenue{{$revenue->id}}" data-bs-toggle="modal" class="btn btn-icon btn-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.edit')}}">
                                                    <i data-feather='edit'></i>
                                                </a>
                                            @endif

                                            @if(userCan('revenues_delete'))
                                                <?php $delete = route('admin.revenues.delete',['id'=>$revenue->id]); ?>
                                                <button type="button" class="btn btn-icon btn-danger" onclick="confirmDelete('{{$delete}}','{{$revenue->id}}')">
                                                    <i data-feather='trash-2'></i>
                                                </button>
                                            @endif
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    @if(userCan('revenues_edit') || userCan('revenues_delete'))
                                        <td colspan="6" class="p-3 text-center ">
                                    @else
                                        <td colspan="5" class="p-3 text-center ">
                                    @endif
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

@if(userCan('revenues_edit'))

    @foreach($revenues as $revenue)
        <div class="modal fade text-md-start" id="editRevenue{{$revenue->id}}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-Revenue">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pb-5 px-sm-5 pt-50">
                        <div class="text-center mb-2">
                            <h1 class="mb-1">{{trans('common.edit')}}: {{$revenue['name_'.session()->get('Lang')]}}</h1>
                        </div>
                        {{Form::open(['files'=>'true','url'=>route('admin.revenues.update',$revenue->id), 'id'=>'editRevenueForm'.$revenue->id, 'class'=>'row gy-1 pt-75'])}}
                            <div class="col-12 col-md-4">
                                <label class="form-label" for="Date">{{trans('common.date')}}</label>
                                {{Form::date('Date',$revenue->Date,['id'=>'Date', 'class'=>'form-control','required'])}}
                            </div>
                            <div class="col-12 col-md-2">
                                <label class="form-label" for="amount">{{trans('common.amount')}}</label>
                                {{Form::number('amount',$revenue->amount,['step'=>'.01','id'=>'amount', 'class'=>'form-control','required'])}}
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label" for="Type">{{trans('common.type')}}</label>
                                {{Form::select('Type',revenuesTypes(session()->get('Lang')),$revenue->Type,['id'=>'Type', 'class'=>'form-select','required'])}}
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label" for="safe_id">{{trans('common.safe')}}</label>
                                {{Form::select('safe_id',safesList(),$revenue->safe_id,['id'=>'safe_id', 'class'=>'form-select','required'])}}
                            </div>
                            <div class="col-12 col-md-12">
                                <label class="form-label" for="Notes">{{trans('common.detailsRevenues')}}</label>
                                {{Form::textarea('Notes',$revenue->Notes,['rows'=>'2','id'=>'Notes', 'class'=>'form-control','required'])}}
                            </div>

                            <div class="divider">
                                <div class="divider-text">{{trans('common.files')}}</div>
                            </div>

                            <div class="row d-flex justify-content-center">
                                <div class="col-md-12 text-center">
                                    <label class="form-label" for="attachment">{{trans('common.attachment')}}</label>
                                    @if($revenue->Files != '')
                                        <div class="row mb-2">
                                            {!!$revenue->attachmentsHtml()!!}
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
    @if(userCan('revenues_create'))
        @include('AdminPanel.accounts.revenues.create')
    @endif

    <div class="modal fade text-md-start" id="searchSalaries" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-Revenue">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-5 px-sm-5 pt-50">
                    {{Form::open(['files'=>'true','id'=>'createRevenueForm', 'class'=>'row gy-1 pt-75', 'method'=>'GET'])}}
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-4">
                            <label class="form-label" for="month">{{trans('common.month')}}</label>
                            {{Form::select('month',monthArray(session()->get('Lang')),isset($_GET['month']) ? $_GET['month'] : date('m'),['id'=>'month', 'class'=>'form-select'])}}
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label" for="year">{{trans('common.year')}}</label>
                            {{Form::select('year',yearArray(),isset($_GET['year']) ? $_GET['year'] : date('Y'),['id'=>'year', 'class'=>'form-select'])}}
                        </div>
                        @if(env('APP_BRANCH') == 1 && userCan('expenses_view_branch'))
                            <div class="col-12 col-md-4">
                                <label class="form-label" for="branch_id">{{trans('common.branch')}}</label>
                                <?php $branchesList = App\Models\Branches::orderBy('name','asc')->pluck('name','id')->all(); ?>
                                {{Form::select('branch_id',['all'=>'الجميع'] + $branchesList,isset($_GET['branch_id']) ? $_GET['branch_id'] : '',['id'=>'branch_id', 'class'=>'form-select'])}}
                            </div>
                        @endif

                        <div class="col-12 col-md-4">
                            <label class="form-label" for="safe_id">{{trans('common.safe')}}</label>
                            <?php $safesList = App\Models\SafesBanks::orderBy('Title','asc')->pluck('Title','id')->all(); ?>
                            {{Form::select('safe_id',['all'=>'الجميع'] + $safesList,isset($_GET['safe_id']) ? $_GET['safe_id'] : '',['id'=>'safe_id', 'class'=>'form-select'])}}
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
