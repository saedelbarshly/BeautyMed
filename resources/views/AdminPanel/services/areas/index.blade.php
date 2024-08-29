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
                                <th class="text-center">{{trans('common.name')}}</th>
                                <th class="text-center">{{trans('common.pulses')}}</th>
                                <th class="text-center">{{trans('common.estimatedtime')}} ( {{ trans('common.inminutes') }} ) </th>
                                <th class="text-center">{{trans('common.actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($areas as $area)
                            <tr id="row_{{$area->id}}">
                                <td>
                                    {{$area['name']}}
                                </td>
                                <td>
                                    {{$area['pulses']}}
                                </td>
                                <td>
                                    {{$area['time']}}
                                </td>
                                <td class="text-center">
                                    <a href="javascript:;" data-bs-target="#editarea{{$area->id}}" data-bs-toggle="modal" class="btn btn-icon btn-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.edit')}}">
                                        <i data-feather='edit'></i>
                                    </a>
                                    <?php $delete = route('admin.areas.delete',['areaId'=>$area->id]); ?>
                                    <button type="button" class="btn btn-icon btn-danger" onclick="confirmDelete('{{$delete}}','{{$area->id}}')">
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

                {{ $areas->links('vendor.pagination.default') }}


            </div>
        </div>
    </div>
    <!-- Bordered table end -->

@foreach($areas as $area)

    <div class="modal fade text-md-start" id="editarea{{$area->id}}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered modal-edit-user">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-5 px-sm-5 pt-50">
                    <div class="text-center mb-2">
                        <h1 class="mb-1">{{trans('common.edit')}}: {{$area['name']}}</h1>
                    </div>
                    {{Form::open(['url'=>route('admin.areas.update',$area->id), 'id'=>'editareaForm'.$area->id, 'class'=>'row gy-1 pt-75 justify-content-center'])}}
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="name">{{trans('common.name')}}</label>
                            {{Form::text('name',$area->name,['id'=>'name', 'class'=>'form-control'])}}
                        </div>
                                 
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="pulses">{{trans('common.pulses')}}</label>
                            {{Form::text('pulses',$area->pulses,['id'=>'pulses', 'class'=>'form-control'])}}
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label" for="estimatedtime">{{ trans('common.estimatedtime') }}  ( {{ trans('common.inminutes') }} ) </label>
                            {{Form::text('time',$area->time,['id'=>'estimatedtime', 'class'=>'form-control'])}}
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
    <a href="javascript:;" data-bs-target="#createarea" data-bs-toggle="modal" class="btn btn-primary">
        {{trans('common.CreateNew')}}
    </a>

    <div class="modal fade text-md-start" id="createarea" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered modal-edit-user">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-5 px-sm-5 pt-50">
                    <div class="text-center mb-2">
                        <h1 class="mb-1">{{trans('common.CreateNew')}}</h1>
                    </div>
                    {{Form::open(['url'=>route('admin.areas.store'), 'id'=>'createareaForm', 'class'=>'row gy-1 pt-75 justify-content-center'])}}
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="name">{{trans('common.name')}}</label>
                            {{Form::text('name','',['id'=>'name', 'class'=>'form-control'])}}
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="pulses">{{trans('common.pulses')}}</label>
                            {{Form::text('pulses','',['id'=>'pulses', 'class'=>'form-control'])}}
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="estimatedtime">{{trans('common.estimatedtime')}} ( {{ trans('common.inminutes') }} ) </label>
                            {{Form::text('time','',['id'=>'estimatedtime', 'class'=>'form-control'])}}
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
<script src="{{asset('AdminAssets/app-assets/js/scripts/pages/modal-add-service.js')}}"></script>
@stop