@extends('AdminPanel.layouts.master')
@section('content')
    <!-- Bordered table start -->
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>{{trans('common.date')}}</th>
                                <th class="text-center">{{trans('common.governorate')}}</th>
                                <th class="text-center">{{trans('common.city')}}</th>
                                <th class="text-center">{{trans('common.company')}}</th>
                                <th class="text-center">{{trans('common.client')}}</th>
                                <th class="text-center">{{trans('common.responsible')}}</th>
                                <th class="text-center">{{trans('common.actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($units as $unit)
                                <tr id="row_{{$unit->id}}">
                                    <td>
                                        {{$unit['name']}}
                                    </td>
                                    <td class="text-center">
                                        {{$unit->governorate->name ?? '-'}}
                                    </td>
                                    <td class="text-center">
                                        {{$unit->city->name ?? '-'}}
                                    </td>
                                    <td class="text-center">
                                        {{$unit->companyData->name ?? '-'}}
                                    </td>
                                    <td class="text-center">
                                        {{$unit->client->name ?? '-'}}
                                    </td>
                                    <td class="text-center">
                                        {{$unit->agent->name ?? '-'}}
                                    </td>
                                    <td class="text-center text-nowrap">
                                        <a href="{{route('admin.units.view',$unit->id)}}" class="btn btn-icon btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.details')}}">
                                            <i data-feather='eye'></i>
                                        </a>

                                        @if(userCan('units_edit'))
                                            <a href="{{route('admin.units.edit',$unit->id)}}" class="btn btn-icon btn-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.edit')}}">
                                                <i data-feather='edit'></i>
                                            </a>
                                        @endif
                                            
                                        @if(userCan('units_delete'))
                                            <?php $delete = route('admin.units.delete',['id'=>$unit->id]); ?>
                                            <button type="button" class="btn btn-icon btn-danger" onclick="confirmDelete('{{$delete}}','{{$unit->id}}')" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.delete')}}">
                                                <i data-feather='trash-2'></i>
                                            </button>
                                        @endif
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

                {{ $units->links('vendor.pagination.default') }}
            </div>
        </div>
    </div>
    <!-- Bordered table end -->

@stop

@section('page_buttons')
    @if(userCan('units_create'))
        @include('AdminPanel.projectsUnits.units.create')
    @endif
    <a href="javascript:;" data-bs-target="#searchunits" data-bs-toggle="modal" class="btn btn-primary btn-sm">
        {{trans('common.search')}}
    </a>

    <div class="modal fade text-md-start" id="searchunits" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-unit">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-5 px-sm-5 pt-50">
                    {{Form::open(['id'=>'createunitForm', 'class'=>'row gy-1 pt-75', 'method'=>'GET'])}}
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-5">
                            <label class="form-label" for="name">{{trans('common.name')}}</label>
                            {{Form::text('name',isset($_GET['name']) ? $_GET['name'] : '',['id'=>'name', 'class'=>'form-control'])}}
                        </div> 
                        <div class="col-12 col-md-3">
                            <label class="form-label" for="city">{{trans('common.city')}}</label>
                            {{Form::select('city',['all'=>'الجميع'] + citiesList(),isset($_GET['city']) ? $_GET['city'] : '',['id'=>'city', 'class'=>'selectpicker', 'data-live-search'=>'true'])}}
                        </div> 
                        <div class="col-12 col-md-2">
                            <label class="form-label" for="spaceFrom">{{trans('common.spaceFrom')}}</label>
                            {{Form::text('spaceFrom',isset($_GET['spaceFrom']) ? $_GET['spaceFrom'] : '',['id'=>'spaceFrom', 'class'=>'form-control'])}}
                        </div>
                        <div class="col-12 col-md-2">
                            <label class="form-label" for="spaceTo">{{trans('common.spaceTo')}}</label>
                            {{Form::text('spaceTo',isset($_GET['spaceTo']) ? $_GET['spaceTo'] : '',['id'=>'spaceTo', 'class'=>'form-control'])}}
                        </div>
                        <div class="col-12 col-md-2">
                            <label class="form-label" for="id">{{trans('common.code')}}</label>
                            {{Form::text('id',isset($_GET['id']) ? $_GET['id'] : '',['id'=>'id', 'class'=>'form-control'])}}
                        </div>
                        
                        <div class="col-12 col-md-2 mt-2">
                            <label class="form-label" for="floor">{{trans('common.floor')}}</label>
                            {{Form::text('floor',isset($_GET['floor']) ? $_GET['floor'] : '',['id'=>'floor', 'class'=>'form-control'])}}
                        </div>

                        <div class="col-12 col-md-2 mt-2">
                            <label class="form-label" for="rooms">{{trans('common.rooms')}}</label>
                            {{Form::text('rooms',isset($_GET['rooms']) ? $_GET['rooms'] : '',['id'=>'rooms', 'class'=>'form-control'])}}
                        </div>

                        <div class="col-12 col-md-2 mt-2">
                            <label class="form-label" for="bathroom">{{trans('common.bathroom')}}</label>
                            {{Form::text('bathroom',isset($_GET['bathroom']) ? $_GET['bathroom'] : '',['id'=>'bathroom', 'class'=>'form-control'])}}
                        </div>

                        <div class="col-12 col-md-2 mt-2">
                            <label class="form-label" for="Kitchen">{{trans('common.Kitchen')}}</label>
                            {{Form::text('Kitchen',isset($_GET['Kitchen']) ? $_GET['Kitchen'] : '',['id'=>'Kitchen', 'class'=>'form-control'])}}
                        </div>

                        <div class="col-12"></div>
                        <div class="col-12 col-md-2 mt-2">
                            <label class="form-label" for="PriceFrom">{{trans('common.PriceFrom')}}</label>
                            {{Form::text('PriceFrom',isset($_GET['PriceFrom']) ? $_GET['PriceFrom'] : '',['id'=>'PriceFrom', 'class'=>'form-control'])}}
                        </div>

                        <div class="col-12 col-md-2 mt-2">
                            <label class="form-label" for="PriceTo">{{trans('common.PriceTo')}}</label>
                            {{Form::text('PriceTo',isset($_GET['PriceTo']) ? $_GET['PriceTo'] : '',['id'=>'PriceTo', 'class'=>'form-control'])}}
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