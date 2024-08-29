@extends('AdminPanel.layouts.master')
@section('content')
<!-- Bordered table start -->
<div class="row" id="table-bordered">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                {{Form::open(['files'=>'true','url'=>route('admin.projects.update',$project->id), 'id'=>'createExpenseForm', 'class'=>'row gy-1 pt-75'])}}
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="name">{{trans('common.name')}}</label>
                        {{Form::text('name',$project->name,['id'=>'name', 'class'=>'form-control','required'])}}
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="form-label" for="type">{{trans('common.type')}}</label>
                        {{Form::select('type',unitsTypesList(session()->get('Lang')),$project->type,['id'=>'type', 'class'=>'form-select','required'])}}
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="form-label" for="CityID">{{trans('common.city')}}</label>
                        {{Form::select('CityID',citiesList(),$project->CityID,['id'=>'CityID', 'class'=>'selectpicker','data-live-search'=>'true','required'])}}
                    </div>
                    <div class="col-12 col-md-2">
                        <label class="form-label" for="space">{{trans('common.space')}}</label>
                        {{Form::text('space',$project->space,['id'=>'space', 'class'=>'form-control'])}}
                    </div>

                    <div class="col-12 col-md-2">
                        <label class="form-label" for="floor">{{trans('common.floor')}}</label>
                        {{Form::text('floor',$project->floor,['id'=>'floor', 'class'=>'form-control'])}}
                    </div>

                    <div class="col-12 col-md-2">
                        <label class="form-label" for="rooms">{{trans('common.rooms')}}</label>
                        {{Form::text('rooms',$project->rooms,['id'=>'rooms', 'class'=>'form-control'])}}
                    </div>

                    <div class="col-12 col-md-2">
                        <label class="form-label" for="bathroom">{{trans('common.bathroom')}}</label>
                        {{Form::text('bathroom',$project->bathroom,['id'=>'bathroom', 'class'=>'form-control'])}}
                    </div>

                    <div class="col-12 col-md-2">
                        <label class="form-label" for="Kitchen">{{trans('common.Kitchen')}}</label>
                        {{Form::text('Kitchen',$project->Kitchen,['id'=>'Kitchen', 'class'=>'form-control'])}}
                    </div>

                    <div class="col-12 col-md-2">
                        <label class="form-label" for="Price">{{trans('common.price')}}</label>
                        {{Form::text('Price',$project->Price,['id'=>'Price', 'class'=>'form-control'])}}
                    </div>

                    <div class="col-12 col-md-4">
                        <label class="form-label" for="project">{{trans('common.project')}}</label>
                        {{Form::select('ProjectID',projectsList(),$project->ProjectID,['id'=>'project', 'class'=>'selectpicker','data-live-search'=>'true','required'])}}
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label" for="AgentID">{{trans('common.responsible')}}</label>
                        {{Form::select('AgentID',agentsList(),$project->AgentID,['id'=>'AgentID', 'class'=>'selectpicker','data-live-search'=>'true','required'])}}
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label" for="ClientID">{{trans('common.client')}}</label>
                        {{Form::select('ClientID',clientsList(),$project->ClientID,['id'=>'ClientID', 'class'=>'selectpicker','data-live-search'=>'true','required'])}}
                    </div>
                    <div class="col-12 col-md-12">
                        <label class="form-label" for="address">{{trans('common.address')}}</label>
                        {{Form::text('address',$project->address,['id'=>'address', 'class'=>'form-control'])}}
                    </div>
                    <div class="col-12 col-md-12">
                        <label class="form-label" for="notes">{{trans('common.details')}}</label>
                        {{Form::textarea('notes',$project->notes,['rows'=>'2','id'=>'notes', 'class'=>'form-control editor_ar'])}}
                    </div>

                    <div class="divider">
                        <div class="divider-text">{{trans('common.files')}}</div>
                    </div>

                    <div class="row d-flex justify-content-center">
                        <div class="col-md-12 text-center">
                            @if($project->files != '')
                                <div class="row mb-2">
                                    {!!$project->filesHtml()!!}
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