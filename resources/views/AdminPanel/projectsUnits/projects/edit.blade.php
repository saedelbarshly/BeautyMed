@extends('AdminPanel.layouts.master')
@section('content')
<!-- Bordered table start -->
<div class="row" id="table-bordered">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                {{Form::open(['files'=>'true','url'=>route('admin.projects.update',$project->id), 'id'=>'createExpenseForm', 'class'=>'row gy-1 pt-75'])}}
                    <div class="col-12 col-md-9">
                        <label class="form-label" for="name">{{trans('common.name')}}</label>
                        {{Form::text('name',$project->name,['id'=>'name', 'class'=>'form-control','required'])}}
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="form-label" for="type">{{trans('common.type')}}</label>
                        {{Form::select('type',projectsTypesList(session()->get('Lang')),$project->type,['id'=>'type', 'class'=>'form-select','required'])}}
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label" for="company">{{trans('common.company')}}</label>
                        {{Form::select('company',companiesList(),$project->company,['id'=>'company', 'class'=>'selectpicker','data-live-search'=>'true','required'])}}
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label" for="CityID">{{trans('common.city')}}</label>
                        {{Form::select('CityID',citiesList(),$project->CityID,['id'=>'CityID', 'class'=>'selectpicker','data-live-search'=>'true','required'])}}
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label" for="location">{{trans('common.location')}}</label>
                        {{Form::select('location',locationsList(),$project->location,['id'=>'location', 'class'=>'selectpicker','data-live-search'=>'true','required'])}}
                    </div>
                    <div class="col-12 col-md-12">
                        <label class="form-label" for="excel">{{trans('common.excelLink')}}</label>
                        {{Form::text('excel',$project->excel,['id'=>'excel', 'class'=>'form-control'])}}
                    </div>
                    <div class="col-12 col-md-12">
                        <label class="form-label" for="details">{{trans('common.details')}}</label>
                        {!!Form::textarea('details',$project->details,['rows'=>'2','id'=>'details', 'class'=>'form-control editor_ar'])!!}
                    </div>

                    <div class="divider">
                        <div class="divider-text">{{trans('common.files')}}</div>
                    </div>

                    <div class="row d-flex justify-content-center">
                        <div class="col-md-12 text-center">
                            @if($project->images != '')
                                <div class="row mb-2">
                                    {!!$project->imagesHtml()!!}
                                </div>
                            @endif
                            <div class="file-loading"> 
                                <input class="files" name="images[]" type="file" multiple>
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
<!-- Bordered table end -->

@stop