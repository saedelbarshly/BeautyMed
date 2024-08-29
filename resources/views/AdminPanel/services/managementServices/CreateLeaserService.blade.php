
    <div class="modal fade text-md-start" id="CreateLeaserService" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-5 px-sm-5 pt-50">
                    <div class="text-center mb-2">
                        <h1 class="mb-1">{{trans('common.CreateLeaserService')}}</h1>
                    </div>
                    {{Form::open(['url'=>route('admin.services.store'), 'id'=>'CreateLeaserServiceForm', 'class'=>'row gy-1 pt-75 justify-content-center'])}}
                        <div class="col-12 col-md-4">
                            <label class="form-label" for="name">{{trans('common.name')}}</label>
                            {{Form::text('name','',['id'=>'name', 'class'=>'form-control'])}}
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label" for="price">{{trans('common.price')}}</label>
                            {{Form::number('price','',['id'=>'price', 'class'=>'form-control'])}}
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label" for="pulses">{{trans('common.pulses')}}</label>
                            {{Form::number('pulses','',['id'=>'pulses', 'class'=>'form-control'])}}
                        </div> 
                        <div class="col-12 col-sm-4">
                            <label class="form-label" for="area_id">{{trans('common.area')}}</label>
                            {{Form::select('area_id',['0'=>'بدون تحديد'] + areasList(),'',['id'=>'area_id','class'=>'form-select','required'])}}
                        </div>  
                        <div class="col-12 col-sm-4">
                            <label class="form-label" for="machine_id">{{trans('common.machine')}}</label>
                            {{Form::select('machine_id',['0'=>'بدون تحديد'] + machinesList(),'',['id'=>'machine_id','class'=>'form-select','required'])}}
                        </div>
                        <div class="col-12 col-sm-4">
                            <label class="form-label" for="calculateCommission">{{trans('common.calculateCommission')}}</label>
                            {{Form::select('calculateCommission',commissionTypes(session()->get('Lang')),'',['id'=>'calculateCommission','class'=>'form-select','required'])}}
                        </div> 
                        <div class="col-12 col-md-4">
                            <label class="form-label" for="doctorCommission">{{trans('common.doctorCommission')}}</label>
                            {{Form::text('commission','',['id'=>'doctorCommission', 'class'=>'form-control'])}}
                        </div>
                        <div class="col-12 col-sm-4">
                            <label class="form-label" for="doubleDate">{{trans('common.doubleDate')}}</label>
                            {{Form::select('doubleDate',doubleDate(session()->get('Lang')),'',['id'=>'doubleDate','class'=>'form-select','required'])}}
                        </div> 
                        <div class="col-12 col-sm-4">
                            <label class="form-label" for="max_clients">عدد العملاء الأقصى</label>
                            {{Form::number('max_clients','0',['id'=>'max_clients','class'=>'form-control','required'])}}
                        </div> 
                        <div class="col-12 col-sm-4">
                            <label class="form-label" for="time">وقت تقديم الخدمة</label>
                            {{Form::number('time','10',['id'=>'time','class'=>'form-control','required'])}}
                        </div> 
                        {!! Form::hidden('type', 1) !!}                            
                     
                          
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
