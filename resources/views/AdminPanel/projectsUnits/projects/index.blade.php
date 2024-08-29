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
                                <th class="text-center">{{trans('common.location')}}</th>
                                <th class="text-center">{{trans('common.actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($projects as $project)
                                <tr id="row_{{$project->id}}">
                                    <td>
                                        {{$project['name']}}
                                    </td>
                                    <td class="text-center">
                                        {{$project->governorate->name ?? '-'}}
                                    </td>
                                    <td class="text-center">
                                        {{$project->city->name ?? '-'}}
                                    </td>
                                    <td class="text-center">
                                        {{$project->companyData->name ?? '-'}}
                                    </td>
                                    <td class="text-center">
                                        {{$project->locationData->name ?? '-'}}
                                    </td>
                                    <td class="text-center text-nowrap">
                                        <a href="{{route('admin.projects.view',$project->id)}}" class="btn btn-icon btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.details')}}">
                                            <i data-feather='eye'></i>
                                        </a>

                                        @if(userCan('projects_edit'))
                                            <a href="{{route('admin.projects.edit',$project->id)}}" class="btn btn-icon btn-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.edit')}}">
                                                <i data-feather='edit'></i>
                                            </a>
                                        @endif
                                            
                                        @if(userCan('projects_delete'))
                                            <?php $delete = route('admin.projects.delete',['id'=>$project->id]); ?>
                                            <button type="button" class="btn btn-icon btn-danger" onclick="confirmDelete('{{$delete}}','{{$project->id}}')" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.delete')}}">
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

                {{ $projects->links('vendor.pagination.default') }}
            </div>
        </div>
    </div>
    <!-- Bordered table end -->

@stop

@section('page_buttons')
    @if(userCan('projects_create'))
        @include('AdminPanel.projectsUnits.projects.create')
    @endif
    <a href="javascript:;" data-bs-target="#searchProjects" data-bs-toggle="modal" class="btn btn-primary btn-sm">
        {{trans('common.search')}}
    </a>

    <div class="modal fade text-md-start" id="searchProjects" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-project">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-5 px-sm-5 pt-50">
                    {{Form::open(['id'=>'createprojectForm', 'class'=>'row gy-1 pt-75', 'method'=>'GET'])}}
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-3">
                            <label class="form-label" for="name">{{trans('common.name')}}</label>
                            {{Form::text('name',isset($_GET['name']) ? $_GET['name'] : '',['id'=>'name', 'class'=>'form-control'])}}
                        </div> 
                        <div class="col-12 col-md-3">
                            <label class="form-label" for="company">{{trans('common.company')}}</label>
                            {{Form::select('company',['all'=>'الجميع'] + companiesList(),isset($_GET['company']) ? $_GET['company'] : '',['id'=>'company', 'class'=>'selectpicker', 'data-live-search'=>'true'])}}
                        </div> 
                        <div class="col-12 col-md-3">
                            <label class="form-label" for="location">{{trans('common.location')}}</label>
                            {{Form::select('location',['all'=>'الجميع'] + locationsList(),isset($_GET['location']) ? $_GET['location'] : '',['id'=>'location', 'class'=>'selectpicker', 'data-live-search'=>'true'])}}
                        </div> 
                        <div class="col-12 col-md-3">
                            <label class="form-label" for="city">{{trans('common.city')}}</label>
                            {{Form::select('city',['all'=>'الجميع'] + citiesList(),isset($_GET['city']) ? $_GET['city'] : '',['id'=>'city', 'class'=>'selectpicker', 'data-live-search'=>'true'])}}
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