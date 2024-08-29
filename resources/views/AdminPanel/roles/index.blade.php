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
                                <th class="text-center">{{trans('common.users')}}</th>
                                <th class="text-center">{{trans('common.actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($roles as $role)
                            <tr id="row_{{$role->id}}">
                                <td>
                                    {{$role['name_ar']}}
                                </td>
                                <td class="text-center">

                                @if($role->id == 2)     
                                    <a href="{{route('admin.doctors')}}" class="btn btn-sm btn-success">                                  
                                    {{$role->users()->where('status','Active')->count()}}
                                    </a>
                                @else
                                    <a href="{{route('admin.adminUsers',['role'=>$role->id])}}" class="btn btn-sm btn-success">                                  
                                    {{$role->users()->where('status','Active')->count()}}
                                    </a>
                                @endif
                                </td>
                                <td class="text-center">
                                    @if(!in_array($role->id,['1','2']))
                                        <a href="javascript:;" data-bs-target="#editRole{{$role->id}}" data-bs-toggle="modal" class="btn btn-icon btn-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.edit')}}">
                                            <i data-feather='edit'></i>
                                        </a>
                                        <?php $delete = route('admin.roles.delete',['id'=>$role->id]); ?>
                                        <button type="button" class="btn btn-icon btn-danger" onclick="confirmDelete('{{$delete}}','{{$role->id}}')">
                                            <i data-feather='trash-2'></i>
                                        </button>
                                    @else
                                    -
                                    @endif
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

                {{ $roles->links('vendor.pagination.default') }}


            </div>
        </div>
    </div>
    <!-- Bordered table end -->

@foreach($roles as $role)

    <div class="modal fade text-md-start" id="editRole{{$role->id}}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-edit-user">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-5 px-sm-5 pt-50">
                    <div class="text-center mb-2">
                        <h1 class="mb-1">{{trans('common.edit')}}: {{$role['name_'.session()->get('Lang')]}}</h1>
                    </div>
                    {{Form::open(['url'=>route('admin.roles.update',$role->id), 'id'=>'editRoleForm'.$role->id, 'class'=>'row gy-1 pt-75'])}}
                        <div class="col-12 col-md-4">
                            <label class="form-label" for="name_ar">{{trans('common.name')}}</label>
                            {{Form::text('name_ar',$role->name_ar,['id'=>'name_ar', 'class'=>'form-control'])}}
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <h4 class="mt-2 pt-50">{{trans('common.Role Permissions')}}</h4>
                                <!-- Permission table -->
                                <div class="table-responsive">
                                    <table class="table table-flush-spacing">
                                        <tbody>
                                            <tr>
                                                <td class="text-nowrap fw-bolder">
                                                    {{trans('common.Select All')}}
                                                    <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{trans('common.Allows a full access to the system')}}">
                                                        <i data-feather="info"></i>
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="selectAll" />
                                                        <label class="form-check-label" for="selectAll"> {{trans('common.Select All')}} </label>
                                                    </div>
                                                </td>
                                            </tr>
                                            @foreach(getPermissions($role->id) as $permissionGroup)
                                                <tr>
                                                    <td class="text-nowrap fw-bolder">{{$permissionGroup['name'] ?? ''}}</td>
                                                    <td>
                                                        <div class="d-flex">
                                                            @foreach($permissionGroup['permissions'] as $permission)
                                                                <div class="form-check me-3 me-lg-1">
                                                                    <input class="form-check-input" type="checkbox" id="permission{{$permission['id']}}" name="permissions[]" value="{{$permission['id']}}" @if($permission['hasIt'] == 1) checked @endif />
                                                                    <label class="form-check-label" for="permission{{$permission['id']}}"> {{$permission['name']}} </label>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- Permission table -->
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

@stop

@section('page_buttons')
    @if(auth()->user()->id == 1)
        @include('AdminPanel.roles.CreatePermission')
    @endif
    <a href="javascript:;" data-bs-target="#createRole" data-bs-toggle="modal" class="btn btn-primary">
        {{trans('common.CreateNew')}}
    </a>

    <div class="modal fade text-md-start" id="createRole" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-edit-user">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-5 px-sm-5 pt-50">
                    <div class="text-center mb-2">
                        <h1 class="mb-1">{{trans('common.CreateNew')}}</h1>
                    </div>
                    {{Form::open(['url'=>route('admin.roles.store'), 'id'=>'createRoleForm', 'class'=>'row gy-1 pt-75'])}}
                        <div class="col-12 col-md-4">
                            <label class="form-label" for="name_ar">{{trans('common.name')}}</label>
                            {{Form::text('name_ar','',['id'=>'name_ar', 'class'=>'form-control'])}}
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <h4 class="mt-2 pt-50">{{trans('common.Role Permissions')}}</h4>
                                <!-- Permission table -->
                                <div class="table-responsive">
                                    <table class="table table-flush-spacing">
                                        <tbody>
                                            <tr>
                                                <td class="text-nowrap fw-bolder">
                                                    {{trans('common.Select All')}}
                                                    <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{trans('common.Allows a full access to the system')}}">
                                                        <i data-feather="info"></i>
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="selectAll" />
                                                        <label class="form-check-label" for="selectAll"> {{trans('common.Select All')}} </label>
                                                    </div>
                                                </td>
                                            </tr>
                                            @foreach(getPermissions() as $permissionGroup)
                                                <tr>
                                                    <td class="text-nowrap fw-bolder">{{$permissionGroup['name'] ?? ''}}</td>
                                                    <td>
                                                        <div class="d-flex">
                                                            @foreach($permissionGroup['permissions'] as $permission)
                                                                <div class="form-check me-3 me-lg-1">
                                                                    <input class="form-check-input" type="checkbox" id="permission{{$permission['id']}}" name="permissions[]" value="{{$permission['id']}}" />
                                                                    <label class="form-check-label" for="permission{{$permission['id']}}">
                                                                        {{$permission['name']}}
                                                                        @if(auth()->user()->id == 1)
                                                                            <br> <small>({{$permission['can']}})</small>
                                                                        @endif
                                                                    </label>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- Permission table -->
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
@stop

@section('scripts')
<script src="{{asset('AdminAssets/app-assets/js/scripts/pages/modal-add-role.js')}}"></script>
@stop