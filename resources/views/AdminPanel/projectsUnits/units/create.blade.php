<a href="javascript:;" data-bs-target="#createUnit" data-bs-toggle="modal" class="btn btn-sm btn-primary">
    {{trans('common.CreateNew')}}
</a>

<div class="modal fade text-md-start" id="createUnit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-5 px-sm-5 pt-50">
                <div class="text-center mb-2">
                    <h1 class="mb-1">{{trans('common.CreateNew')}}</h1>
                </div>
                {{Form::open(['files'=>true,'url'=>route('admin.units.store'), 'id'=>'createUnitForm', 'class'=>'row gy-1 pt-75'])}}
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="name">{{trans('common.name')}}</label>
                        {{Form::text('name','',['id'=>'name', 'class'=>'form-control','required'])}}
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="form-label" for="type">{{trans('common.type')}}</label>
                        {{Form::select('type',unitsTypesList(session()->get('Lang')),'',['id'=>'type', 'class'=>'form-select','required'])}}
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="form-label" for="CityID">{{trans('common.city')}}</label>
                        {{Form::select('CityID',citiesList(),'',['id'=>'CityID', 'class'=>'selectpicker','data-live-search'=>'true','required'])}}
                    </div>
                    <div class="col-12 col-md-2">
                        <label class="form-label" for="space">{{trans('common.space')}}</label>
                        {{Form::text('space','',['id'=>'space', 'class'=>'form-control'])}}
                    </div>

                    <div class="col-12 col-md-2">
                        <label class="form-label" for="floor">{{trans('common.floor')}}</label>
                        {{Form::text('floor','',['id'=>'floor', 'class'=>'form-control'])}}
                    </div>

                    <div class="col-12 col-md-2">
                        <label class="form-label" for="rooms">{{trans('common.rooms')}}</label>
                        {{Form::text('rooms','',['id'=>'rooms', 'class'=>'form-control'])}}
                    </div>

                    <div class="col-12 col-md-2">
                        <label class="form-label" for="bathroom">{{trans('common.bathroom')}}</label>
                        {{Form::text('bathroom','',['id'=>'bathroom', 'class'=>'form-control'])}}
                    </div>

                    <div class="col-12 col-md-2">
                        <label class="form-label" for="Kitchen">{{trans('common.Kitchen')}}</label>
                        {{Form::text('Kitchen','',['id'=>'Kitchen', 'class'=>'form-control'])}}
                    </div>

                    <div class="col-12 col-md-2">
                        <label class="form-label" for="Price">{{trans('common.price')}}</label>
                        {{Form::text('Price','',['id'=>'Price', 'class'=>'form-control'])}}
                    </div>

                    <div class="col-12 col-md-4">
                        <label class="form-label" for="project">{{trans('common.project')}}</label>
                        {{Form::select('ProjectID',projectsList(),'',['id'=>'project', 'class'=>'selectpicker','data-live-search'=>'true','required'])}}
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label" for="AgentID">{{trans('common.responsible')}}</label>
                        {{Form::select('AgentID',agentsList(),'',['id'=>'AgentID', 'class'=>'selectpicker','data-live-search'=>'true','required'])}}
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label" for="ClientID">{{trans('common.client')}}</label>
                        {{Form::select('ClientID',['None' => 'بدون عميل'] + clientsList(),'',['id'=>'ClientID', 'class'=>'selectpicker','data-live-search'=>'true','required'])}}
                    </div>
                    <div class="col-12 col-md-12">
                        <label class="form-label" for="address">{{trans('common.address')}}</label>
                        {{Form::text('address','',['id'=>'address', 'class'=>'form-control'])}}
                    </div>
                    <div class="col-12 col-md-12">
                        <label class="form-label" for="notes">{{trans('common.details')}}</label>
                        {{Form::textarea('notes','',['rows'=>'2','id'=>'notes', 'class'=>'form-control editor_ar'])}}
                    </div>

                    <div class="divider">
                        <div class="divider-text">{{trans('common.files')}}</div>
                    </div>

                    <div class="row d-flex justify-content-center">
                        <div class="col-md-12 text-center">
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
