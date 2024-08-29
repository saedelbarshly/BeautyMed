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
                                <th>{{trans('common.name')}}</th>
                                <th>{{trans('common.contacts')}}</th>
                                <th>{{trans('common.code')}}</th>
                                <th>{{trans('common.refferal')}}</th>
                                <th>{{trans('common.visit')}}</th>
                                <th class="text-center">{{trans('common.actions')}}</th>
                            </tr>
                        </thead> 
                        <tbody>
                            @forelse($clients as $client)
                            <tr id="row_{{$client->id}}">
                                <td>
                                    {{$client->Name}}
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
                                    @if($client->whatsapp != '')
                                        <span class="btn btn-sm btn-danger mb-1">
                                            <b>{{trans('common.whatsapp')}}: </b>
                                            <a href="call:{{$client->whatsapp}}" class="text-white">
                                                {{$client->whatsapp ?? '-'}}
                                            </a>
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    {{$client->code ?? '-'}}
                                </td>
                                <td >
                                    @if($client->refferal_id)
                                      {{$client->refferal->name }}
                                    @else
                                      -  
                                    @endif
                                </td>
                               
                                <td class="text-center text-nowrap">
                                    {{ trans('common.lastVisit') }} -  <br>
                                    {{ trans('common.nextVisit') }} - 
                                </td>
                                <td class="text-nowrap">
                                    @if($client->status == 'Active')
                                        <a href="{{route('admin.clients.block',['id'=>$client->id,'action'=>'1'])}}" class="btn btn-sm btn-icon btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.block')}}">
                                            <i data-feather='shield-off'></i>
                                        </a>
                                    @else
                                        <a href="{{route('admin.clients.block',['id'=>$client->id,'action'=>'0'])}}" class="btn btn-sm btn-icon btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.unblock')}}">
                                            <i data-feather='shield'></i>
                                        </a>
                                    @endif
                                
                                   <a href="{{route('admin.clients.profile',$client->id)}}" class="btn btn-icon btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.profile')}}">
                                        <i data-feather='list'></i>
                                    </a> 
 
                                    <button type="button" class="btn btn-icon dropdown-toggle hide-arrow btn-danger" data-bs-toggle="dropdown">
                                            <i data-feather="more-vertical"></i>
                                    </button>
                                        {{-- create reserviton --}}
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a href="javascript:;" data-bs-target="#addReservation{{$client->id}}" data-bs-toggle="modal" class="dropdown-item">
                                            <span>{{trans('common.addAppointment')}}</span>
                                        </a>
                                        <a href="javascript:;" data-bs-target="#addComplaint{{$client->id}}" data-bs-toggle="modal" class="dropdown-item">
                                            <span>{{trans('common.addComplaint')}}</span>
                                        </a>
                                    </div>

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
                        <label class="form-label" for="phone">{{trans('common.phone')}}</label>
                        {{Form::text('phone',$client->phone,['id'=>'phone', 'class'=>'form-control'])}}
                        @if($errors->has('phone'))
                            <span class="text-danger" role="alert">
                                <b>{{ $errors->first('phone') }}</b>
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
                        <label class="form-label" for="code">{{trans('common.code')}}</label>
                        {{Form::text('code',$client->code,['id'=>'code', 'class'=>'form-control'])}}
                    </div>
                  
                    <div class="col-12 col-md-3">
                        <label class="form-label" for="refferal_id">{{trans('common.refferal')}}</label>
                        {{Form::select('refferal_id', ['0'=>'بدون تحديد'] + refferalList(),$client->refferal_id,['id'=>'refferal_id', 'class'=>'form-control'])}}
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


@foreach($clients as $client)
        @if(userCan('reservations_create'))
            @include('AdminPanel.clients.createReservation',['clientData'=>$client])  
        @endif
        @if(userCan('complaints_create'))
            @include('AdminPanel.clients.createComplaint',['client'=>$client])
        @endif
@endforeach

@stop

@section('page_buttons')

    @if(!isset($_GET['status']) || (isset($_GET['status']) && $_GET['status'] != 'Archive'))
        <a href="{{route('admin.clients',['status'=>'Archive'])}}" class="btn btn-danger btn-sm">
            {{trans('common.Archive')}}
        </a> 
    @endif
    @if(isset($_GET['status']) && $_GET['status'] != 'Active')
        <a href="{{route('admin.clients',['status'=>'Active'])}}" class="btn btn-success btn-sm">
            {{trans('common.ActiveUsers')}}
        </a>
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
                        
                        <div class="col-12 col-md-3">
                            <label class="form-label" for="Name">{{trans('common.name')}}</label>
                            {{Form::text('Name', isset($_GET['Name']) ? $_GET['Name'] : '',['id'=>'Name', 'class'=>'form-control'])}}
                        </div>
                        <div class="col-12 col-md-3">
                            <label class="form-label" for="phone">{{trans('common.phone')}}</label>
                            {{Form::text('phone', isset($_GET['phone']) ? $_GET['phone'] : '',['id'=>'phone', 'class'=>'form-control'])}}
                        </div>
                        <div class="col-12 col-md-3">
                            <label class="form-label" for="from_date">{{trans('common.from_date')}}</label>
                            {{Form::date('from_date',isset($_GET['from_date']) ? $_GET['from_date'] : '',['id'=>'from_date', 'class'=>'form-control'])}}
                        </div>
                        <div class="col-12 col-md-3">
                            <label class="form-label" for="to_date">{{trans('common.to_date')}}</label>
                            {{Form::date('to_date',isset($_GET['to_date']) ? $_GET['to_date'] : '',['id'=>'to_date', 'class'=>'form-control'])}}
                        </div>   
                        <div class="col-12 col-md-3">
                            <label class="form-label" for="refferal_id">{{trans('common.refferal')}}</label>
                            {{Form::select('refferal_id', ['0'=>'بدون تحديد'] + refferalList(),'',['id'=>'refferal_id', 'class'=>'form-control'])}}
                        </div>
                        <div class="col-12 col-md-3">
                            <label class="form-label" for="code">{{trans('common.code')}}</label>
                            {{Form::text('code', isset($_GET['code']) ? $_GET['code'] : '',['id'=>'phone', 'class'=>'form-control'])}}
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