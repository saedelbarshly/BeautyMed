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
                                <th class="text-center">{{trans('common.price')}}</th>
                                <th class="text-center">{{trans('common.pulses')}}</th>
                                <th class="text-center">{{trans('common.doctorCommission')}} ( {{ trans('common.percent') }})</th>
                                <th class="text-center">{{trans('common.machine')}}</th>
                                <th class="text-center">{{trans('common.area')}}</th>
                                <th class="text-center">{{trans('common.actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($services as $service)
                            <tr id="row_{{$service->id}}">
                                <td>
                                    {{$service['name']}}
                                </td>
                                <td>
                                    {{$service['price']}}
                                </td>
                                <td>
                                    {{$service['pulses']}}
                                </td>
                                <td>
                                    {{ $service['commission']}}
                                </td>
                                  @if(!isset($service->machine->id))
                                <td>    {{ trans('common.withoutselect') }}   </td>     @else
                                <td>
                                    {{$service->machine->name}}
                                </td>
                                @endif
                                @if(!isset($service->area->id))    <td>   {{ trans('common.withoutselect') }}  </td>     @else
                                <td>
                                    {{ $service->area->name}}
                                </td>
                                @endif
                                <td class="text-center">
                                    <a href="{{route('admin.services.reports',$service->id)}}" class="btn btn-icon btn-dark" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.showService')}}">
                                        <i data-feather='eye'></i>
                                    </a>

                                    <a href="javascript:;" data-bs-target="#editservice{{$service->id}}" data-bs-toggle="modal" class="btn btn-icon btn-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.edit')}}">
                                        <i data-feather='edit'></i>
                                    </a>

                                    <?php $delete = route('admin.services.delete',['serviceId'=>$service->id]); ?>
                                    <button type="button" class="btn btn-icon btn-danger" onclick="confirmDelete('{{$delete}}','{{$service->id}}')">
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

                {{ $services->links('vendor.pagination.default') }}


            </div>
        </div>
    </div>
    <!-- Bordered table end -->

@foreach($services as $service)

    <div class="modal fade text-md-start" id="editservice{{$service->id}}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-5 px-sm-5 pt-50">
                    <div class="text-center mb-2">
                        <h1 class="mb-1">{{trans('common.edit')}}: {{$service['name']}}</h1>
                    </div>
                    {{Form::open(['url'=>route('admin.services.update',$service->id), 'id'=>'editserviceForm'.$service->id, 'class'=>'row gy-1 pt-75 justify-content-center'])}}
                        <div class="col-12 col-md-4">
                            <label class="form-label" for="name">{{trans('common.name')}}</label>
                            {{Form::text('name',$service->name,['id'=>'name', 'class'=>'form-control'])}}
                        </div>

                        <div class="col-12 col-md-4">
                            <label class="form-label" for="price">{{trans('common.price')}}</label>
                            {{Form::text('price',$service->price,['id'=>'price', 'class'=>'form-control'])}}
                        </div>

                        <div class="col-12 col-md-4">
                            <label class="form-label" for="pulses">{{trans('common.pulses')}}</label>
                            {{Form::number('pulses',$service->pulses,['id'=>'pulses', 'class'=>'form-control'])}}
                        </div>

                        @if($service->type == 1)
                            <div class="col-12 col-sm-4">
                                <label class="form-label" for="area_id">{{trans('common.area')}}</label>
                                {{Form::select('area_id',['0'=>'بدون تحديد'] + areasList(),$service->area_id,['id'=>'area_id','class'=>'form-select','required'])}}
                            </div>

                            <div class="col-12 col-sm-4">
                                <label class="form-label" for="machine_id">{{trans('common.machine')}}</label>
                                {{Form::select('machine_id',['0'=>'بدون تحديد'] + machinesList(),$service->machine_id,['id'=>'machine_id','class'=>'form-select','required'])}}
                            </div>
                        @endif

                        <div class="col-12 col-sm-4">
                            <label class="form-label" for="calculateCommission">{{trans('common.calculateCommission')}}</label>
                            {{Form::select('calculateCommission',commissionTypes(session()->get('Lang')),$service->calculateCommission,['id'=>'calculateCommission','class'=>'form-select','required'])}}
                        </div>

                        <div class="col-12 col-md-4">
                            <label class="form-label" for="doctorCommission">{{trans('common.doctorCommission')}}</label>
                            {{Form::text('commission',$service->commission,['id'=>'doctorCommission', 'class'=>'form-control'])}}
                        </div>

                        <div class="col-12 col-sm-4">
                            <label class="form-label" for="max_clients">عدد العملاء الأقصى</label>
                            {{Form::number('max_clients',$service->max_clients,['id'=>'max_clients','class'=>'form-control','required'])}}
                        </div>
                        <div class="col-12 col-sm-4">
                            <label class="form-label" for="time">وقت تقديم الخدمة</label>
                            {{Form::number('time',$service->time,['id'=>'time','class'=>'form-control','required'])}}
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

    <button type="button" class="btn btn-icon dropdown-toggle hide-arrow btn-primary" data-bs-toggle="dropdown">
       {{trans('common.CreateNew')}}
    </button>
    <div class="dropdown-menu dropdown-menu-end">
        <a href="javascript:;" data-bs-target="#CreateCareService" data-bs-toggle="modal" class="dropdown-item">
            <span>{{trans('common.CreateCareService')}}</span>
        </a>
        <a href="javascript:;" data-bs-target="#CreateLeaserService" data-bs-toggle="modal" class="dropdown-item">
            <span>{{trans('common.CreateLeaserService')}}</span>
        </a>
    </div>



    @if(userCan('service_create'))
        @include('AdminPanel.services.managementServices.CreateCareService')
        @include('AdminPanel.services.managementServices.CreateLeaserService')
    @endif

@stop
