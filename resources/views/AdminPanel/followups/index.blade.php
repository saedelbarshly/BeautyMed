@extends('AdminPanel.layouts.master')
@section('content')


    <!-- Bordered table start -->
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{$title}}</h4>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered mb-2">
                        <thead>
                            <tr>
                                <th>{{trans('common.date')}}</th>
                                <th>{{trans('common.user')}}</th>
                                <th>{{trans('common.client')}}</th>
                                <th>{{trans('common.contacts')}}</th>
                                <th>{{trans('common.offerDetails')}}</th>
                                <th>{{trans('common.offerResponse')}}</th>
                                <th class="text-center">
                                    {{trans('common.actions')}}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($followups as $followup)
                            <tr id="row_{{$followup->id}}">
                                <td>
                                    {{$followup->contactingDateTime}}
                                </td>
                                <td>
                                    {{$followup->agent != '' ? $followup->agent->name : '-'}}
                                </td>
                                <td>
                                    {{$followup->client != '' ? $followup->client->Name : '-'}}
                                </td>
                                <td class="text-wrap">
                                    @if($followup->client != '')
                                        @if($followup->client->phone != '')
                                            <span class="btn btn-sm btn-info mb-25">
                                                <b>{{trans('common.phone')}}: </b>
                                                <a href="call:{{$followup->client->phone}}" class="text-white">
                                                    {{$followup->client->phone ?? '-'}}
                                                </a>
                                            </span>
                                        @endif
                                        <div class="col-12"></div>
                                        @if($followup->client->cellphone != '')
                                            <span class="btn btn-sm btn-primary mb-25">
                                                <b>{{trans('common.mobile')}}: </b>
                                                <a href="call:{{$followup->client->cellphone}}" class="text-white">
                                                    {{$followup->client->cellphone ?? '-'}}
                                                </a>
                                            </span>
                                        @endif
                                        <div class="col-12"></div>
                                        @if($followup->client->whatsapp != '')
                                            <span class="btn btn-sm btn-danger">
                                                <b>{{trans('common.whatsapp')}}: </b>
                                                <a href="call:{{$followup->client->whatsapp}}" class="text-white">
                                                    {{$followup->client->whatsapp ?? '-'}}
                                                </a>
                                            </span>
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    {!!$followup->offerDetails ?? '-'!!}
                                </td>
                                <td>
                                    {!!$followup->offerResponse ?? '-'!!}
                                </td>
                                <td class="text-nowrap">
                                    <a href="javascript:;" data-bs-target="#editfollowup{{$followup->id}}" data-bs-toggle="modal" class="btn btn-icon btn-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.edit')}}">
                                        <i data-feather='edit'></i>
                                    </a>
                                    <?php $delete = route('admin.followups.delete',['id'=>$followup->id]); ?>
                                    <button type="button" class="btn btn-icon btn-danger" onclick="confirmDelete('{{$delete}}','{{$followup->id}}')">
                                        <i data-feather='trash-2'></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-3 text-center ">
                                        <h2>{{trans('common.nothingToView')}}</h2>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{ $followups->links('vendor.pagination.default') }}


            </div>
        </div>
    </div>
    <!-- Bordered table end -->


@foreach($followups as $followup)

<div class="modal fade text-md-start" id="editfollowup{{$followup->id}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-5 px-sm-5 pt-50">
                <div class="text-center mb-2">
                    <h1 class="mb-1">{{trans('common.edit')}}: {{$followup['name_'.session()->get('Lang')]}}</h1>
                </div>
                {{Form::open(['url'=>route('admin.followups.update',$followup->id), 'id'=>'editfollowupForm'.$followup->id, 'class'=>'row gy-1 pt-75'])}}
                    <div class="row">
                        <div class="col-md-4">
                            <b>{{trans('common.agent')}}: </b>
                            {{$followup->agent != '' ? $followup->agent->name : '-'}}
                        </div>
                        <div class="col-md-4">
                            <b>{{trans('common.date')}}: </b>
                            {{$followup->contactingDateTime}}
                        </div>
                        <div class="col-md-4">
                            <b>{{trans('common.time')}}: </b>
                            {{date('H:i:s')}}
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label" for="ClientID">{{trans('common.client')}}</label>
                        {{Form::select('ClientID',clientsList(),$followup->ClientID,['id'=>'ClientID', 'class'=>'form-select'])}}
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label" for="contactingType">{{trans('common.followUpType')}}</label>
                        {{Form::select('contactingType',followUpTypeList(session()->get('Lang')),$followup->contactingType,['id'=>'contactingType', 'class'=>'form-control'])}}
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label" for="whoIsContacting">{{trans('common.whoIsContacting')}}</label>
                        {{Form::select('whoIsContacting',whoIsContactingList(session()->get('Lang')),$followup->whoIsContacting,['id'=>'whoIsContacting', 'class'=>'form-control'])}}
                    </div>
                    <div class="col-12"></div>
                    <div class="col-12 col-md-12">
                        <label class="form-label" for="offerDetails">{{trans('common.offerDetails')}}</label>
                        {{Form::textarea('offerDetails',$followup->offerDetails,['rows'=>'3','id'=>'offerDetails', 'class'=>'form-control'])}}
                    </div>
                    <div class="col-12 col-md-12">
                        <label class="form-label" for="offerResponse">{{trans('common.offerResponse')}}</label>
                        {{Form::textarea('offerResponse',$followup->offerResponse,['rows'=>'3','id'=>'offerResponse', 'class'=>'form-control','required'])}}
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="form-label" for="ProjectID">{{trans('common.project')}}</label>
                        {{Form::select('ProjectID',['All' => 'كل المشروعات'] + projectsList(),$followup->ProjectID,['id'=>'ProjectID', 'class'=>'selectpicker'])}}
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="form-label" for="UnitID">{{trans('common.unitVisited')}}</label>
                        {{Form::select('UnitID',['All' => 'كل الوحدات'] + unitsList(),$followup->UnitID,['id'=>'UnitID', 'class'=>'selectpicker'])}}
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="form-label" for="UnitVisitUID">{{trans('common.visitUser')}}</label>
                        {{Form::select('UnitVisitUID',[''=>'بدون معاينة'] + agentsVisitList(),$followup->UnitVisitUID,['id'=>'UnitVisitUID', 'class'=>'selectpicker'])}}
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="form-label" for="status">{{trans('common.statusChanger')}}</label>
                        {{Form::select('status',clientStatusArray(session()->get('Lang')),$followup->status,['id'=>'status', 'class'=>'form-control'])}}
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="form-label" for="nextFollowUpType">{{trans('common.nextFollowUpType')}}</label>
                        {{Form::select('nextFollowUpType',[''=>'بدون متابعة'] + followUpTypeList(session()->get('Lang')),$followup->nextFollowUpType,['id'=>'nextFollowUpType', 'class'=>'form-control'])}}
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="form-label" for="nextContactingDateTime">{{trans('common.nextContactingDate')}}</label>
                        {{Form::date('nextContactingDateTime',$followup->nextContactingDateTime,['id'=>'nextContactingDateTime', 'class'=>'form-control'])}}
                    </div>
                    <div class="col-12 text-center mt-2 pt-50">
                        <button type="submit" class="btn btn-primary me-1" @if($followup->status == 'Done') disabled @endif>{{trans('common.Save changes')}}</button>
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


@stop

@section('page_buttons')
    @if(userCan('followups_create'))
        @include('AdminPanel.followups.create')
    @endif

    <a href="javascript:;" data-bs-target="#searchfollowups" data-bs-toggle="modal" class="btn btn-primary btn-sm">
        {{trans('common.search')}}
    </a>

    <div class="modal fade text-md-start" id="searchfollowups" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-5 px-sm-5 pt-50">
                    {{Form::open(['id'=>'searchfollowupsForm', 'class'=>'row gy-1 pt-75', 'method'=>'GET'])}}
                        @if(userCan('followups_view'))
                            <div class="col-12 col-md-3">
                                <label class="form-label" for="branch_id">{{trans('common.branch')}}</label>
                                <?php $branchesList = App\Models\Branches::orderBy('name','asc')->pluck('name','id')->all(); ?>
                                {{Form::select('branch_id',['all'=>'الجميع'] + $branchesList,isset($_GET['branch_id']) ? $_GET['branch_id'] : '',['id'=>'branch_id', 'class'=>'form-select'])}}
                            </div>
                        @endif
                        @if(userCan('followups_view') || userCan('followups_view_branch') || userCan('followups_view_team'))
                            <div class="col-12 col-md-3">
                                <label class="form-label" for="AgentID">{{trans('common.agent')}}</label>
                                {{Form::select('AgentID',['all' => 'الجميع'] + agentsListForSearch(),isset($_GET['AgentID']) ? $_GET['AgentID'] : '',['id'=>'AgentID', 'class'=>'selectpicker','data-live-search'=>'true'])}}
                            </div>
                        @endif
                        <div class="col-12 col-md-3">
                            <label class="form-label" for="status">{{trans('common.status')}}</label>
                            {{Form::select('status',['all'=>'الجميع'] + clientstatusArray(session()->get('Lang')),isset($_GET['status']) ? $_GET['status'] : date('Y'),['id'=>'status', 'class'=>'form-select'])}}
                        </div>
                        <div class="col-12 col-md-3">
                            <label class="form-label" for="class">{{trans('common.class')}}</label>
                            {{Form::select('class',['all'=>'الجميع'] + clientClassArray(),isset($_GET['class']) ? $_GET['class'] : date('Y'),['id'=>'class', 'class'=>'form-select'])}}
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
