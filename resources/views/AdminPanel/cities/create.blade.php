@extends('AdminPanel.layouts.master')

@section('content')
    <div class="row">
        <div class="col-12">
            <!-- profile -->
            <div class="card">
                <div class="card-body py-2 my-25">
                    {{Form::open(['files'=>'true','class'=>'validate-form','url'=>route('admin.adminUsers.store')])}}
                        <input autocomplete="false" name="hidden" type="text" style="display:none;">
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-3 text-center">
                                <div class="file-loading"> 
                                    <input class="files" name="photo" type="file">
                                </div>
                            </div>
                        </div>

                        <!-- form -->
                        <div class="row pt-3">
                            <div class="col-12 col-sm-3 mb-1">
                                <label class="form-label" for="name">{{trans('common.name')}}</label>
                                {{Form::text('name','',['id'=>'name','class'=>'form-control','required'])}}
                            </div>
                            <div class="col-12 col-sm-3 mb-1">
                                <label class="form-label" for="userName">{{trans('common.username')}}</label>
                                {{Form::text('userName','',['id'=>'userName','class'=>'form-control'])}}
                            </div>
                            <div class="col-12 col-sm-3 mb-1">
                                <label class="form-label" for="email">{{trans('common.email')}}</label>
                                {{Form::text('email','',['id'=>'email','class'=>'form-control','required'])}}
                            </div>
                            <div class="col-12 col-sm-3 mb-1">
                                <label class="form-label" for="phone">{{trans('common.password')}}</label>
                                {{Form::password('password',['id'=>'phone','class'=>'form-control','autoComplete'=>'new-password','required'])}}
                            </div>

                            <div class="col-12 col-sm-3 mb-1">
                                <label for="language" class="form-label">{{trans('common.language')}}</label>
                                {{Form::select('language',[
                                                            'ar' => trans('common.lang1Name'),
                                                            'en' => trans('common.lang2Name'),
                                                            'fr' => trans('common.lang3Name')
                                                            ],'',['id'=>'language','class'=>'form-control selectpicker'])}}
                            </div>
                            <div class="col-12 col-sm-3 mb-1">
                                <label class="form-label" for="country">{{trans('common.country')}}</label>
                                {{Form::select('country',getCountriesList(session()->get('Lang'),'id'),'',['id'=>'country','class'=>'form-control selectpicker','data-live-search'=>'true'])}}
                            </div>
                            <div class="col-12 col-sm-3 mb-1">
                                <label class="form-label" for="phone">{{trans('common.phone')}}</label>
                                {{Form::text('phone','',['id'=>'phone','class'=>'form-control'])}}
                            </div>

                            <div class="col-12 col-sm-12 mb-1">
                                <label class="form-label" for="address">{{trans('common.address')}}</label>
                                {{Form::text('address','',['id'=>'address','class'=>'form-control'])}}
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary mt-1 me-1">{{trans('common.Save changes')}}</button>
                            </div>
                        </div>
                        <!--/ form -->
                    {{Form::close()}}
                </div>
            </div>
        </div>
    </div>
@stop