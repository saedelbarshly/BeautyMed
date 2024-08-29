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
                                <th>#</th>
                                <th>{{trans('common.name')}}</th>
                                <th>{{trans('common.email')}}</th>
                                <th>{{trans('common.phone')}}</th>
                                <th>{{trans('common.serviceCommission')}}</th>
                                <th class="text-center">{{trans('common.actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                            <tr id="row_{{$user->id}}">
                                <td>
                                    {{$user->id}}
                                </td>
                                <td>
                                    {{$user->name}}
                                </td>
                                <td>
                                    {{$user->email}}
                                </td>
                                <td>
                                    {{$user->phone}}
                                </td>  
                                <td>  
                                    @foreach($user->services->unique() as $service)
                                        <li> 
                                            <a href="javascript:;" data-bs-target="#editcommission{{$service->pivot->id}}" data-bs-toggle="modal" >
                                                <small>
                                                    {{ $service->name }} -
                                                    {{ $service->pivot->commission }} 
                                                </small>
                                            </a>

                                        </li>
                                    @endforeach
                                </td>
                               
                                <td class="text-center text-nowrap">
                                  
                                    @if($user->status == 'Active')
                                        <a href="{{route('admin.doctors.block',['id'=>$user->id,'action'=>'1'])}}" class="btn btn-sm btn-icon btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.block')}}">
                                            <i data-feather='shield-off'></i>
                                        </a>
                                    @else
                                        <a href="{{route('admin.doctors.block',['id'=>$user->id,'action'=>'0'])}}" class="btn btn-sm btn-icon btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.unblock')}}">
                                            <i data-feather='shield'></i>
                                        </a>
                                    @endif
                                    <a href="{{route('admin.doctors.hrProfile',['id'=>$user->id])}}" class="btn btn-sm btn-icon btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.hrProfile')}}">
                                        <i data-feather='list'></i>
                                    </a>
                                    <a href="{{route('admin.doctors.edit',['id'=>$user->id])}}" class="btn btn-sm btn-icon btn-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.edit')}}">
                                        <i data-feather='edit'></i>
                                    </a>
                                    <?php $delete = route('admin.doctors.delete',['id'=>$user->id]); ?>
                                    <button type="button" class="btn btn-sm btn-icon btn-danger" onclick="confirmDelete('{{$delete}}','{{$user->id}}')" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.delete')}}">
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

                {{ $users->links('vendor.pagination.default') }}


            </div>
        </div>
    </div>
    <!-- Bordered table end -->
 

@foreach($users as $user)
    @foreach($user->services as $service)
    <div class="modal fade text-md-start" id="editcommission{{$service->pivot->id}}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered modal-edit-user">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-5 px-sm-5 pt-50">
                    <div class="text-center mb-2">
                        <h1 class="mb-1">{{trans('common.edit')}}: {{$service['name_'.session()->get('Lang')]}}</h1>
                    </div>
                    {{Form::open(['url'=>route('admin.commission.update',[$user->id,$service->id]), 'id'=>'editCommissionForm'.$service->id, 'class'=>'row gy-1 pt-75'])}}
                        <div class="col-12">
                            <label class="form-label" for="Commission">{{trans('common.commission')}}</label>
                            {!! Form::number('commission',$service->pivot->commission,['id'=>'commission','min'=>'1','max' => '100', 'class'=>'form-control'])   !!}
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
@endforeach


@stop




@section('page_buttons')
    @if(!isset($_GET['status']) || (isset($_GET['status']) && $_GET['status'] != 'Archive'))
        <a href="{{route('admin.doctors',['status'=>'Archive'])}}" class="btn btn-danger">
            {{trans('common.Archive')}}
        </a>
    @endif
    @if(isset($_GET['status']) && $_GET['status'] != 'Active')
        <a href="{{route('admin.doctors',['status'=>'Active'])}}" class="btn btn-success">
            {{trans('common.ActiveUsers')}}
        </a>
    @endif
    <a href="{{route('admin.doctors.create')}}" class="btn btn-primary">
        {{trans('common.CreateNew')}}
    </a>


    
    <a href="javascript:;" data-bs-target="#searchusers" data-bs-toggle="modal" class="btn btn-primary">
        {{trans('common.search')}}
    </a>

    <div class="modal fade text-md-start" id="searchusers" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-5 px-sm-5 pt-50">
                    {{Form::open(['id'=>'searchusersForm', 'class'=>'row gy-1 pt-75', 'method'=>'GET'])}}
                        
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="name">{{trans('common.name')}}</label>
                            {{Form::text('name', isset($_GET['name']) ? $_GET['name'] : '',['id'=>'name', 'class'=>'form-control'])}}
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="phone">{{trans('common.phone')}}</label>
                            {{Form::text('phone', isset($_GET['phone']) ? $_GET['phone'] : '',['id'=>'phone', 'class'=>'form-control'])}}
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


