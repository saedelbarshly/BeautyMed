@extends('AdminPanel.layouts.master')

@section('content')
    <div class="row">
        <div class="col-12">
            <!-- profile -->
            <div class="card">
                <div class="card-body py-2 my-25">
                    {{Form::open(['files'=>'true','class'=>'validate-form'])}}
                        <input autocomplete="false" name="hidden" type="text" style="display:none;">

                        <div class="divider">
                            <div class="divider-text">{{trans('common.MainProfileData')}}</div>
                        </div>
                        <div class="row pt-3">
                            <div class="col-12 col-sm-3 mb-1">
                                <label class="form-label" for="name">{{trans('common.name')}}</label>
                                {{Form::text('name',$user->name,['id'=>'name','class'=>'form-control','required'])}}
                                @if($errors->has('name'))
                                    <span class="text-danger" role="alert">
                                        <b>{{ $errors->first('name') }}</b>
                                    </span>
                                @endif
                            </div>
                            <div class="col-12 col-sm-3 mb-1">
                                <label class="form-label" for="leader">{{trans('common.TeamWork')}}</label>
                                {{Form::select('leader',[''=>'بدون فريق عمل'] + leadersList(),$user->leader,['id'=>'leader','class'=>'form-select'])}}
                            </div>
                            <div class="col-12 col-sm-3 mb-1">
                                <label class="form-label" for="another_phone">{{trans('common.phone')}}</label>
                                {{Form::text('another_phone',$user->another_phone,['id'=>'another_phone','class'=>'form-control'])}}
                                @if($errors->has('another_phone'))
                                    <span class="text-danger" role="alert">
                                        <b>{{ $errors->first('another_phone') }}</b>
                                    </span>
                                @endif
                            </div>
                            <div class="col-12 col-sm-3 mb-1">
                                <label class="form-label" for="address">{{trans('common.address')}}</label>
                                {{Form::text('address',$user->address,['id'=>'address','class'=>'form-control'])}}
                            </div>
                        </div>

                        <div class="divider">
                            <div class="divider-text">{{trans('common.loginData')}}</div>
                        </div>

                        <div class="row pt-3">
                            <div class="col-12 col-sm-3 mb-1">
                                <label class="form-label" for="username">{{trans('common.username')}}</label>
                                {{Form::text('username',$user->username,['id'=>'username','class'=>'form-control'])}}
                            </div>
                            <div class="col-12 col-sm-3 mb-1">
                                <label class="form-label" for="email">{{trans('common.email')}}</label>
                                {{Form::email('email',$user->email,['id'=>'email','class'=>'form-control'])}}
                                @if($errors->has('email'))
                                    <span class="text-danger" role="alert">
                                        <b>{{ $errors->first('email') }}</b>
                                    </span>
                                @endif
                            </div>
                            <div class="col-12 col-sm-3 mb-1">
                                <label class="form-label" for="phone">{{trans('common.personalPhone')}}</label>
                                {{Form::text('phone',$user->phone,['id'=>'phone','class'=>'form-control'])}}
                                @if($errors->has('phone'))
                                    <span class="text-danger" role="alert">
                                        <b>{{ $errors->first('phone') }}</b>
                                    </span>
                                @endif
                            </div>
                            <div class="col-12 col-sm-3 mb-1">
                                <label class="form-label" for="phone">{{trans('common.password')}}</label>
                                {{Form::password('password',['id'=>'phone','class'=>'form-control','autoComplete'=>'new-password'])}}
                            </div>
                            <div class="col-12 col-sm-3 mb-1">
                                <label class="form-label" for="role">{{trans('common.role')}}</label>
                                {!! Form::hidden('role', 2) !!}                            
                            </div>
                        </div>

                        <div class="divider">
                            <div class="divider-text">{{trans('common.employmentDetails')}}</div>
                        </div>

                        <div class="row pt-3">
                            <div class="col-12 col-sm-2 mb-1">
                                <label class="form-label" for="sallary">{{trans('common.sallary')}}</label>
                                {{Form::number('sallary',$user->sallary,['id'=>'sallary','class'=>'form-control','required'])}}
                            </div>
                           
                            @if(env('APP_BRANCH') == 1)
                            <div class="col-12 col-sm-3 mb-1">
                                <label class="form-label" for="branch_id">{{trans('common.branch')}}</label>
                                {{Form::select('branch_id',branchesList(),$user->branch_id,['id'=>'branch_id','class'=>'form-select','required'])}}
                            </div>
                            @endif
                            <div class="col-12 col-sm-3 mb-1">
                                <label class="form-label" for="employment_date">{{trans('common.employmentDate')}}</label>
                                {{Form::date('employment_date',$user->employment_date,['id'=>'employment_date','class'=>'form-control','required'])}}
                            </div>
                            <div class="col-12 col-sm-2 mb-1">
                                <label class="form-label" for="zk_id">{{trans('common.zk_id')}}</label>
                                {{Form::number('zk_id',$user->zk_id,['id'=>'zk_id','class'=>'form-control','required'])}}
                            </div>
                            <div class="col-12 col-sm-2 mb-1">
                                <label class="form-label" for="WorkFrom">{{trans('common.WorkFrom')}}</label>
                                {{Form::time('WorkFrom',$user->WorkFrom,['id'=>'WorkFrom','class'=>'form-control','required'])}}
                            </div>
                            <div class="col-12 col-sm-2 mb-1">
                                <label class="form-label" for="WorkTo">{{trans('common.WorkTo')}}</label>
                                {{Form::time('WorkTo',$user->WorkTo,['id'=>'WorkTo','class'=>'form-control','required'])}}
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label" for="countLateAttendance">{{trans('common.countLateAttendance')}}</label>
                                <div class="form-check form-check-success form-switch">
                                    {{Form::checkbox('countLateAttendance','1',$user->countLateAttendance == 1 ? true : false,['id'=>'countLateAttendance', 'class'=>'form-check-input'])}}
                                    <label class="form-check-label" for="countLateAttendance"></label>
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label" for="countOverTime">{{trans('common.countOverTime')}}</label>
                                <div class="form-check form-check-success form-switch">
                                    {{Form::checkbox('countOverTime','1',$user->countOverTime == 1 ? true : false,['id'=>'countOverTime', 'class'=>'form-check-input'])}}
                                    <label class="form-check-label" for="countOverTime"></label>
                                </div>
                            </div>
                        </div>

                        <div class="divider">
                            <div class="divider-text">{{trans('common.files')}}</div>
                        </div>
 
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-3 text-center">
                                <label class="form-label" for="profile_photo">{{trans('common.profilePhoto')}}</label>
                                <span class="avatar mb-2">
                                    <img class="round" src="{{$user->photoLink()}}" alt="avatar" height="150" width="150">
                                </span>
                                <div class="file-loading"> 
                                    <input class="files" name="profile_photo" type="file">
                                </div>
                            </div>
                            <div class="col-md-3 text-center">
                                <label class="form-label" for="identity">{{trans('common.identity')}}</label>
                                <span class="avatar mb-2">
                                    <img class="round" src="{{$user->identityLink()}}" alt="avatar" height="150" width="150">
                                </span>
                                <div class="file-loading"> 
                                    <input class="files" name="identity" type="file">
                                </div>
                            </div>
                            <div class="col-md-12 text-center mt-2">
                                <label class="form-label" for="files">{{trans('common.files')}}</label>
                                @if($user->files != '')
                                    <div class="row mb-2">
                                        {!!$user->filesHtml()!!}
                                    </div>
                                @endif
                                <div class="file-loading"> 
                                    <input class="files" name="attachments[]" type="file" multiple>
                                </div>
                            </div>
                        </div>

                        <!-- form -->
                        <div class="row pt-3">

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