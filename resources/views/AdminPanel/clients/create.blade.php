<a href="javascript:;" data-bs-target="#createClient" data-bs-toggle="modal" class="btn btn-sm btn-primary">
    إضافة عميل
</a>

<div class="modal fade text-md-start" id="createClient" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-5 px-sm-5 pt-50">
                <div class="text-center mb-2">
                    <h1 class="mb-1">{{trans('common.CreateNew')}}</h1>
                </div>
                {{Form::open(['url'=>route('admin.clients.store'), 'id'=>'createClientForm', 'class'=>'row gy-1 pt-75'])}}
                    <div class="col-12 col-md-2">
                        <label class="form-label" for="code">{{trans('common.code')}}</label>
                        {{Form::number('code','',['id'=>'code', 'class'=>'form-control','required', 'min'=>1])}}
                        @if($errors->has('code'))
                            <span class="text-danger" role="alert">
                                <b>{{ $errors->first('code') }}</b>
                            </span>
                        @endif
                    </div>
                    <div class="col-12 col-md-5">
                        <label class="form-label" for="Name">{{trans('common.name')}}</label>
                        {{Form::text('Name','',['id'=>'Name', 'class'=>'form-control','required'])}}
                        @if($errors->has('Name'))
                            <span class="text-danger" role="alert">
                                <b>{{ $errors->first('Name') }}</b>
                            </span>
                        @endif
                    </div>
                    <div class="col-12 col-md-5">
                        <label class="form-label" for="phone">{{trans('common.phone')}}</label>
                        {{Form::text('phone','',['id'=>'phone', 'class'=>'form-control'])}}
                        @if($errors->has('phone'))
                            <span class="text-danger" role="alert">
                                <b>{{ $errors->first('phone') }}</b>
                            </span>
                        @endif
                    </div>
                 
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="whatsapp">{{trans('common.whatsapp')}}</label>
                        {{Form::text('whatsapp','',['id'=>'whatsapp', 'class'=>'form-control'])}}
                        @if($errors->has('whatsapp'))
                            <span class="text-danger" role="alert">
                                <b>{{ $errors->first('whatsapp') }}</b>
                            </span>
                        @endif
                    </div>
                  
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="refferal_id">{{trans('common.refferal')}}</label>
                        {{Form::select('refferal_id',['0'=>'بدون تحديد'] + refferalList(),'',['id'=>'refferal_id', 'class'=>'form-control'])}}
                    </div>
  
                    {!! Form::hidden('date',date('Y-m-d')) !!}    
                    {!! Form::hidden('status','Active') !!}    
                  
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
