@extends('AdminPanel.layouts.master')
@section('content')

    {{Form::open(['url'=>route('admin.noAgentClients.asignAgent'),'id'=>'searchClientsForm'])}}
        <!-- Bordered table start -->
        <div class="row" id="table-bordered">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            {{$title}}
                            <br>
                            <small>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="selectAll" />
                                    <label class="form-check-label" for="selectAll"> {{trans('common.Select All')}} </label>
                                </div>
                            </small>
                        </h4>
                        <a href="javascript:;" data-bs-target="#transferClients" data-bs-toggle="modal" class="btn btn-primary btn-sm">
                            {{trans('common.transferClients')}}
                        </a>

                        <div class="modal fade text-md-start" id="transferClients" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-md modal-dialog-centered modal-edit-user">
                                <div class="modal-content">
                                    <div class="modal-header bg-transparent">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body pb-5 px-sm-5 pt-50">
                                        @if(userCan('clients_view') || userCan('clients_view_branch') || userCan('clients_view_team'))
                                            <div class="col-12 col-md-12">
                                                <label class="form-label" for="AgentID">{{trans('common.agent')}}</label>
                                                {{Form::select('AgentID',agentsListForSearch(),isset($_GET['AgentID']) ? $_GET['AgentID'] : '',['id'=>'AgentID', 'class'=>'selectpicker','data-live-search'=>'true'])}}
                                            </div>
                                        @endif
                                        <div class="col-12 text-center mt-2 pt-50">
                                            <button type="submit" class="btn btn-primary me-1">{{trans('common.Save Changes')}}</button>
                                            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                                                {{trans('common.Cancel')}}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered mb-2">
                            <thead>
                                <tr>
                                    <th>
                                        {{trans('common.name')}}
                                    </th>
                                    <th>{{trans('common.data')}}</th>
                                    <th>{{trans('common.contacts')}}</th>
                                    <th>{{trans('common.refferal')}}</th>
                                    <th>{{trans('common.lastContactDetails')}}</th>
                                    <th class="text-center">{{trans('common.actions')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($clients as $client)
                                <tr id="row_{{$client->id}}">
                                    <td>
                                        <div class="form-check me-3 me-lg-1">
                                            <input class="form-check-input" type="checkbox" id="client{{$client->id}}" name="clients[]" value="{{$client->id}}" />
                                            <label class="form-check-label" for="client{{$client->id}}">
                                                {{$client->Name}}
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <b>{{trans('common.job')}}: </b>
                                        {{$client->Job ?? '-'}}
                                        <br>
                                        <b>{{trans('common.company')}}: </b>
                                        {{$client->Company ?? '-'}}
                                        <br>
                                        <b>{{trans('common.class')}}: </b>
                                        {{$client->class ?? '-'}}
                                    </td>
                                    <td class="text-wrap">
                                        @if($client->phone != '')
                                            <span class="btn btn-sm btn-info mb-1">
                                                <b>{{trans('common.phone')}}: </b>
                                                <a href="call:{{$client->phone}}" class="text-white">
                                                    {{$client->phone ?? '-'}}
                                                </a>
                                            </span>
                                        @endif
                                        @if($client->cellphone != '')
                                            <span class="btn btn-sm btn-primary mb-1">
                                                <b>{{trans('common.mobile')}}: </b>
                                                <a href="call:{{$client->cellphone}}" class="text-white">
                                                    {{$client->cellphone ?? '-'}}
                                                </a>
                                            </span>
                                        @endif
                                        @if($client->whatsapp != '')
                                            <span class="btn btn-sm btn-danger">
                                                <b>{{trans('common.whatsapp')}}: </b>
                                                <a href="call:{{$client->whatsapp}}" class="text-white">
                                                    {{$client->whatsapp ?? '-'}}
                                                </a>
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        {{refferalList(session()->get('Lang'))[$client->refferal] ?? '-'}}
                                    </td>
                                    <td>
                                        @if($client->lastFollowUp() != '')
                                            {{$client->lastFollowUp()->contactingDateTime}}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="text-nowrap text-center">
                                        <a href="javascript:;" data-bs-target="#createFollowUp{{$client->id}}" data-bs-toggle="modal" class="btn btn-sm btn-primary mb-1">
                                            {{trans('common.CreateNewFollowUp')}}
                                        </a>
                                        <div class="col-12"></div>

                                        <a href="{{route('admin.followups',['client_id'=>$client->id])}}" class="btn btn-icon btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.followups')}}">
                                            <i data-feather='list'></i>
                                        </a>
                                        <a href="javascript:;" data-bs-target="#editclient{{$client->id}}" data-bs-toggle="modal" class="btn btn-icon btn-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.edit')}}">
                                            <i data-feather='edit'></i>
                                        </a>
                                        <?php $delete = route('admin.clients.delete',['id'=>$client->id]); ?>
                                        <button type="button" class="btn btn-icon btn-danger" onclick="confirmDelete('{{$delete}}','{{$client->id}}')">
                                            <i data-feather='trash-2'></i>
                                        </button>
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

                    {{ $clients->links('vendor.pagination.default') }}


                </div>
            </div>
        </div>
        <!-- Bordered table end -->
    {{Form::close()}}



    @foreach($clients as $client)
        <div class="modal fade text-md-start" id="editclient{{$client->id}}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pb-5 px-sm-5 pt-50">
                        <div class="text-center mb-2">
                            <h1 class="mb-1">{{trans('common.edit')}}: {{$client['name_'.session()->get('Lang')]}}</h1>
                        </div>
                        {{Form::open(['url'=>route('admin.clients.update',$client->id), 'id'=>'editclientForm'.$client->id, 'class'=>'row gy-1 pt-75'])}}
                            <div class="col-12 col-md-3">
                                <label class="form-label" for="Name">{{trans('common.name')}}</label>
                                {{Form::text('Name',$client->Name,['id'=>'Name', 'class'=>'form-control','required'])}}
                                @if($errors->has('Name'))
                                    <span class="text-danger" role="alert">
                                        <b>{{ $errors->first('Name') }}</b>
                                    </span>
                                @endif
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label" for="Company">{{trans('common.company')}}</label>
                                {{Form::text('Company',$client->Company,['id'=>'Company', 'class'=>'form-control'])}}
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label" for="Job">{{trans('common.job')}}</label>
                                {{Form::text('Job',$client->Job,['id'=>'Job', 'class'=>'form-control'])}}
                            </div>
                            <div class="col-12"></div>
                            <div class="col-12 col-md-3">
                                <label class="form-label" for="phone">{{trans('common.phone')}}</label>
                                {{Form::text('phone',$client->phone,['id'=>'phone', 'class'=>'form-control'])}}
                                @if($errors->has('phone'))
                                    <span class="text-danger" role="alert">
                                        <b>{{ $errors->first('phone') }}</b>
                                    </span>
                                @endif
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label" for="cellphone">{{trans('common.mobile')}}</label>
                                {{Form::text('cellphone',$client->cellphone,['id'=>'cellphone', 'class'=>'form-control','required'])}}
                                @if($errors->has('cellphone'))
                                    <span class="text-danger" role="alert">
                                        <b>{{ $errors->first('cellphone') }}</b>
                                    </span>
                                @endif
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label" for="whatsapp">{{trans('common.whatsapp')}}</label>
                                {{Form::text('whatsapp',$client->whatsapp,['id'=>'whatsapp', 'class'=>'form-control'])}}
                                @if($errors->has('whatsapp'))
                                    <span class="text-danger" role="alert">
                                        <b>{{ $errors->first('whatsapp') }}</b>
                                    </span>
                                @endif
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label" for="email">{{trans('common.email')}}</label>
                                {{Form::text('email',$client->email,['id'=>'email', 'class'=>'form-control'])}}
                                @if($errors->has('email'))
                                    <span class="text-danger" role="alert">
                                        <b>{{ $errors->first('email') }}</b>
                                    </span>
                                @endif
                            </div>
                            <div class="col-12 col-md-12">
                                <label class="form-label" for="address">{{trans('common.address')}}</label>
                                {{Form::text('address',$client->address,['id'=>'address', 'class'=>'form-control'])}}
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label" for="refferal">{{trans('common.refferal')}}</label>
                                {{Form::select('refferal',refferalList(session()->get('Lang')),$client->refferal,['id'=>'refferal', 'class'=>'form-control'])}}
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label" for="clientClass">{{trans('common.class')}}</label>
                                {{Form::select('clientClass',clientClassArray(),$client->clientClass,['id'=>'clientClass', 'class'=>'form-control'])}}
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label" for="status">{{trans('common.status')}}</label>
                                {{Form::select('status',clientStatusArray(session()->get('Lang')),$client->status,['id'=>'status', 'class'=>'form-control'])}}
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

        <div class="modal fade text-md-start" id="createFollowUp{{$client->id}}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pb-5 px-sm-5 pt-50">
                        <div class="text-center mb-2">
                            <h1 class="mb-1">{{trans('common.CreateNewFollowUp')}}</h1>
                        </div>
                        {{Form::open(['url'=>route('admin.followups.store'), 'id'=>'createFollowUpForm', 'class'=>'row gy-1 pt-75'])}}
                            <div class="row">
                                <div class="col-md-4">
                                    <b>{{trans('common.agent')}}: </b>
                                    {{auth()->user()->name}}
                                </div>
                                <div class="col-md-4">
                                    <b>{{trans('common.date')}}: </b>
                                    {{date('Y-m-d')}}
                                </div>
                                <div class="col-md-4">
                                    <b>{{trans('common.time')}}: </b>
                                    {{date('H:i:s')}}
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label" for="ClientID">{{trans('common.client')}}</label>
                                <p>{{$client->Name}}</p>
                                {{Form::hidden('ClientID',$client->id)}}
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label" for="contactingType">{{trans('common.followUpType')}}</label>
                                {{Form::select('contactingType',followUpTypeList(session()->get('Lang')),'',['id'=>'contactingType', 'class'=>'form-control'])}}
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label" for="whoIsContacting">{{trans('common.whoIsContacting')}}</label>
                                {{Form::select('whoIsContacting',whoIsContactingList(session()->get('Lang')),'',['id'=>'whoIsContacting', 'class'=>'form-control'])}}
                            </div>
                            <div class="col-12"></div>
                            <div class="col-12 col-md-12">
                                <label class="form-label" for="offerDetails">{{trans('common.offerDetails')}}</label>
                                {{Form::text('offerDetails','',['id'=>'offerDetails', 'class'=>'form-control'])}}
                            </div>
                            <div class="col-12 col-md-12">
                                <label class="form-label" for="offerResponse">{{trans('common.offerResponse')}}</label>
                                {{Form::text('offerResponse','',['id'=>'offerResponse', 'class'=>'form-control','required'])}}
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label" for="ProjectID">{{trans('common.project')}}</label>
                                {{Form::select('ProjectID',['All' => 'كل المشروعات'] + projectsList(),'',['id'=>'ProjectID', 'class'=>'selectpicker'])}}
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label" for="UnitID">{{trans('common.unitVisited')}}</label>
                                {{Form::select('UnitID',['All' => 'كل الوحدات'] + unitsList(),'',['id'=>'UnitID', 'class'=>'selectpicker'])}}
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label" for="UnitVisitUID">{{trans('common.visitUser')}}</label>
                                {{Form::select('UnitVisitUID',[''=>'بدون معاينة'] + agentsVisitList(),'',['id'=>'UnitVisitUID', 'class'=>'selectpicker'])}}
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label" for="status">{{trans('common.statusChanger')}}</label>
                                {{Form::select('status',clientStatusArray(session()->get('Lang')),'',['id'=>'status', 'class'=>'form-control'])}}
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label" for="nextFollowUpType">{{trans('common.nextFollowUpType')}}</label>
                                {{Form::select('nextFollowUpType',[''=>'بدون متابعة'] + followUpTypeList(session()->get('Lang')),'',['id'=>'nextFollowUpType', 'class'=>'form-control'])}}
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label" for="nextContactingDateTime">{{trans('common.nextContactingDate')}}</label>
                                {{Form::date('nextContactingDateTime','',['id'=>'nextContactingDateTime', 'class'=>'form-control'])}}
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


@stop

@section('page_buttons')
    @if(userCan('clients_create_excel'))
        @include('AdminPanel.clients.createExcel')
    @endif
    @if(userCan('clients_create'))
        @include('AdminPanel.clients.create')
    @endif

    <a href="javascript:;" data-bs-target="#searchClients" data-bs-toggle="modal" class="btn btn-primary btn-sm">
        {{trans('common.search')}}
    </a>

    <div class="modal fade text-md-start" id="searchClients" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-5 px-sm-5 pt-50">
                    {{Form::open(['id'=>'searchClientsForm', 'class'=>'row gy-1 pt-75', 'method'=>'GET'])}}
                        @if(userCan('clients_view'))
                            <div class="col-12 col-md-3">
                                <label class="form-label" for="branch_id">{{trans('common.branch')}}</label>
                                <?php $branchesList = App\Models\Branches::orderBy('name','asc')->pluck('name','id')->all(); ?>
                                {{Form::select('branch_id',['all'=>'الجميع'] + $branchesList,isset($_GET['branch_id']) ? $_GET['branch_id'] : '',['id'=>'branch_id', 'class'=>'form-select'])}}
                            </div>
                        @endif
                        @if(userCan('clients_view') || userCan('clients_view_branch') || userCan('clients_view_team'))
                            <div class="col-12 col-md-3">
                                <label class="form-label" for="AgentID">{{trans('common.agent')}}</label>
                                {{Form::select('AgentID',['all' => 'الجميع'] + agentsListForSearch(),isset($_GET['AgentID']) ? $_GET['AgentID'] : '',['id'=>'AgentID', 'class'=>'selectpicker','data-live-search'=>'true'])}}
                            </div>
                        @endif
                        <div class="col-12 col-md-3">
                            <label class="form-label" for="status">{{trans('common.status')}}</label>
                            {{Form::select('status',['all'=>'الجميع'] + clientStatusArray(session()->get('Lang')),isset($_GET['status']) ? $_GET['status'] : '',['id'=>'status', 'class'=>'form-select'])}}
                        </div>
                        <div class="col-12 col-md-3">
                            <label class="form-label" for="class">{{trans('common.class')}}</label>
                            {{Form::select('class',['all'=>'الجميع'] + clientClassArray(),isset($_GET['class']) ? $_GET['class'] : '',['id'=>'class', 'class'=>'form-select'])}}
                        </div>
                        <div class="col-12 col-md-3">
                            <label class="form-label" for="Name">{{trans('common.name')}}</label>
                            {{Form::text('Name', isset($_GET['Name']) ? $_GET['Name'] : '',['id'=>'Name', 'class'=>'form-control'])}}
                        </div>
                        <div class="col-12 col-md-3">
                            <label class="form-label" for="phone">{{trans('common.phone')}}</label>
                            {{Form::text('phone', isset($_GET['phone']) ? $_GET['phone'] : '',['id'=>'phone', 'class'=>'form-control'])}}
                        </div>
                        <div class="col-12 col-md-3">
                            <label class="form-label" for="cellphone">{{trans('common.mobile')}}</label>
                            {{Form::text('cellphone', isset($_GET['cellphone']) ? $_GET['cellphone'] : '',['id'=>'cellphone', 'class'=>'form-control'])}}
                        </div>
                        <div class="col-12 col-md-3">
                            <label class="form-label" for="whatsapp">{{trans('common.whatsapp')}}</label>
                            {{Form::text('whatsapp', isset($_GET['whatsapp']) ? $_GET['whatsapp'] : '',['id'=>'whatsapp', 'class'=>'form-control'])}}
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
