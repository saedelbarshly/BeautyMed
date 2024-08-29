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
                        <div class="row pt-1">
                            <div class="col-12 col-sm-6 mb-1">
                                <label class="form-label" for="name_ar">
                                    <b>الإسم</b>
                                    <br><small>من واقع البطاقة الشخصية</small>
                                </label>
                                {{Form::text('name_ar',$user->employmentProfile->name_ar ?? '',['id'=>'name_ar','class'=>'form-control'])}}
                                @if($errors->has('name_ar'))
                                    <span class="text-danger" role="alert">
                                        <b>{{ $errors->first('name_ar') }}</b>
                                    </span>
                                @endif
                            </div>
                            <div class="col-12 col-sm-6 mb-1">
                                <label class="form-label" for="name_en">
                                    <b>الاســـم الثلاثي باللغة الانجليزية</b>
                                    <br><small>اكتب جميع الأحرف واترك خانة فارغة بين مقاطع الاسم CAPITAL</small>
                                </label>
                                {{Form::text('name_en',$user->employmentProfile->name_en ?? '',['id'=>'name_en','class'=>'form-control'])}}
                                @if($errors->has('name_en'))
                                    <span class="text-danger" role="alert">
                                        <b>{{ $errors->first('name_en') }}</b>
                                    </span>
                                @endif
                            </div>
                            <div class="col-12 col-sm-3 mb-1">
                                <label class="form-label" for="gender">{{trans('common.gender')}}</label>
                                {{Form::select('gender',[
                                                        'male' => trans('common.male'),
                                                        'female' => trans('common.female')
                                                        ],$user->employmentProfile->gender ?? '',['id'=>'gender','class'=>'form-select'])}}
                            </div>
                            <div class="col-12 col-sm-3 mb-1">
                                <label class="form-label" for="birth_date">{{trans('common.birth_date')}}</label>
                                {{Form::date('birth_date',$user->employmentProfile->birth_date ?? '',['id'=>'birth_date','class'=>'form-select'])}}
                            </div>
                            <div class="col-12 col-sm-3 mb-1">
                                <label class="form-label" for="national_id">{{trans('common.national_id')}}</label>
                                {{Form::text('national_id',$user->employmentProfile->national_id ?? '',['id'=>'national_id','class'=>'form-control'])}}
                                @if($errors->has('national_id'))
                                    <span class="text-danger" role="alert">
                                        <b>{{ $errors->first('national_id') }}</b>
                                    </span>
                                @endif
                            </div>
                            <div class="col-12 col-sm-3 mb-1">
                                <label class="form-label" for="passport_id">{{trans('common.passport_id')}}</label>
                                {{Form::text('passport_id',$user->employmentProfile->passport_id ?? '',['id'=>'passport_id','class'=>'form-control'])}}
                                @if($errors->has('passport_id'))
                                    <span class="text-danger" role="alert">
                                        <b>{{ $errors->first('passport_id') }}</b>
                                    </span>
                                @endif
                            </div>

                            
                            <div class="col-12 col-sm-3 mb-1">
                                <label class="form-label" for="nationality">{{trans('common.nationality')}}</label>
                                {{Form::text('nationality',$user->employmentProfile->nationality ?? '',['id'=>'nationality','class'=>'form-control'])}}
                                @if($errors->has('nationality'))
                                    <span class="text-danger" role="alert">
                                        <b>{{ $errors->first('nationality') }}</b>
                                    </span>
                                @endif
                            </div>
                            <div class="col-12 col-sm-3 mb-1">
                                <label class="form-label" for="religion">{{trans('common.religion')}}</label>
                                {{Form::text('religion',$user->employmentProfile->religion ?? '',['id'=>'religion','class'=>'form-control'])}}
                                @if($errors->has('religion'))
                                    <span class="text-danger" role="alert">
                                        <b>{{ $errors->first('religion') }}</b>
                                    </span>
                                @endif
                            </div>
                            <div class="col-12 col-sm-3 mb-1">
                                <label class="form-label" for="martial_status">{{trans('common.martial_status')}}</label>
                                {{Form::select('martial_status',[
                                                        'single' => trans('common.single'),
                                                        'engagged' => trans('common.engagged'),
                                                        'married' => trans('common.married'),
                                                        'divorced' => trans('common.divorced'),
                                                        'widower' => trans('common.widower')
                                                        ],$user->employmentProfile->martial_status ?? '',['id'=>'martial_status','class'=>'form-select'])}}
                            </div>
                            <div class="col-12 col-sm-3 mb-1">
                                <label class="form-label" for="military_status">{{trans('common.military_status')}}</label>
                                {{Form::select('military_status',[
                                                        '' => '',
                                                        'postpone' => trans('common.postpone'),
                                                        'passed' => trans('common.passed'),
                                                        'exempt' => trans('common.exempt')
                                                        ],$user->employmentProfile->military_status ?? '',['id'=>'military_status','class'=>'form-select'])}}
                            </div>
                        </div>

                        <div class="divider mt-3">
                            <div class="divider-text">{{trans('common.contacts')}}</div>
                        </div>

                        <div class="row pt-1">
                            <div class="col-12 col-sm-2 mb-1">
                                <label class="form-label" for="neighbourhood">{{trans('common.neighbourhood')}}</label>
                                {{Form::text('neighbourhood',$user->employmentProfile->neighbourhood ?? '',['id'=>'neighbourhood','class'=>'form-control'])}}
                            </div>
                            <div class="col-12 col-sm-2 mb-1">
                                <label class="form-label" for="city">{{trans('common.city')}}</label>
                                {{Form::text('city',$user->employmentProfile->city ?? '',['id'=>'city','class'=>'form-control'])}}
                            </div>
                            <div class="col-12 col-sm-2 mb-1">
                                <label class="form-label" for="governorate">{{trans('common.governorate')}}</label>
                                {{Form::text('governorate',$user->employmentProfile->governorate ?? '',['id'=>'governorate','class'=>'form-control'])}}
                            </div>
                            <div class="col-12 col-sm-6 mb-1">
                                <label class="form-label" for="address">{{trans('common.address')}}</label>
                                {{Form::text('address',$user->employmentProfile->address ?? '',['id'=>'address','class'=>'form-control'])}}
                            </div>
                            <div class="col-12 col-sm-3 mb-1">
                                <label class="form-label" for="landline1">{{trans('common.landline1')}}</label>
                                {{Form::text('landline1',$user->employmentProfile->landline1 ?? '',['id'=>'landline1','class'=>'form-control'])}}
                            </div>
                            <div class="col-12 col-sm-3 mb-1">
                                <label class="form-label" for="landline2">{{trans('common.landline2')}}</label>
                                {{Form::text('landline2',$user->employmentProfile->landline2 ?? '',['id'=>'landline2','class'=>'form-control'])}}
                            </div>
                            <div class="col-12 col-sm-3 mb-1">
                                <label class="form-label" for="mobile1">{{trans('common.mobile1')}}</label>
                                {{Form::text('mobile1',$user->employmentProfile->mobile1 ?? '',['id'=>'mobile1','class'=>'form-control'])}}
                            </div>
                            <div class="col-12 col-sm-3 mb-1">
                                <label class="form-label" for="mobile2">{{trans('common.mobile2')}}</label>
                                {{Form::text('mobile2',$user->employmentProfile->mobile2 ?? '',['id'=>'mobile2','class'=>'form-control'])}}
                            </div>
                            <div class="col-12 col-sm-6 mb-1">
                                <label class="form-label" for="email">{{trans('common.email')}}</label>
                                {{Form::email('email',$user->employmentProfile->email ?? '',['id'=>'email','class'=>'form-control'])}}
                            </div>
                        </div>

                        <div class="divider">
                            <div class="divider-text">{{trans('common.qualifications&experience')}}</div>
                        </div>

                        <div class="row pt-1">
                            <div class="repeatableQualifications col-sm-12">
                                <h4> {{trans('common.qualifications')}} </h4>
                                @if($user->employmentProfile != '' && count($user->employmentProfile->qualificationsArr()) > 0)
                                    @foreach($user->employmentProfile->qualificationsArr() as $qualification)
                                        <div class="More row">
                                            <div class="col-12 col-md-4">
                                                <label class="form-label">{{trans('common.name')}}</label>
                                                {{ Form::text('qualifications[Title][]',$qualification['Title'],['id'=>'qualificationsTitle','class'=>'form-control']) }}
                                            </div>
                                            <div class="col-12 col-md-3">
                                                <label class="form-label">{{trans('common.university')}}</label>
                                                {{ Form::text('qualifications[University][]',$qualification['University'],['class'=>'form-control']) }}
                                            </div>
                                            <div class="col-12 col-md-2">
                                                <label class="form-label">{{trans('common.college')}}</label>
                                                {{ Form::text('qualifications[College][]',$qualification['College'],['class'=>'form-control']) }}
                                            </div>
                                            <div class="col-12 col-md-2">
                                                <label class="form-label">{{trans('common.year')}}</label>
                                                {{ Form::text('qualifications[Year][]',$qualification['Year'],['class'=>'form-control']) }}
                                            </div>
                                            <div class="col-1 col-md-1 mt-2">
                                                <span class="delete btn btn-icon btn-danger">
                                                    {{trans('common.delete')}}
                                                </span>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="row">
                                        <div class="col-12 col-md-4">
                                            <label class="form-label">{{trans('common.name')}}</label>
                                            {{ Form::text('qualifications[Title][]','',['id'=>'qualificationsTitle','class'=>'form-control']) }}
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <label class="form-label">{{trans('common.university')}}</label>
                                            {{ Form::text('qualifications[University][]','',['class'=>'form-control']) }}
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <label class="form-label">{{trans('common.college')}}</label>
                                            {{ Form::text('qualifications[College][]','',['class'=>'form-control']) }}
                                        </div>
                                        <div class="col-12 col-md-2">
                                            <label class="form-label">{{trans('common.year')}}</label>
                                            {{ Form::text('qualifications[Year][]','',['class'=>'form-control']) }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="col-12 mt-2">
                                <span class="add_Qualification btn btn-sm btn-info">{{trans('common.addnew')}} </span>
                            </div>
                        </div>

                        <div class="row pt-3">
                            <div class="repeatableExperiences col-sm-12">
                                <h4> {{trans('common.experience')}} </h4>
                                @if($user->employmentProfile != '' && count($user->employmentProfile->experienceArr()) > 0)
                                    @foreach($user->employmentProfile->experienceArr() as $experience)
                                        <div class="More row">
                                            <div class="col-12 col-md-4">
                                                <label class="form-label">{{trans('common.job')}}</label>
                                                {{ Form::text('experience[Job][]',$experience['Job'],['class'=>'form-control']) }}
                                            </div>
                                            <div class="col-12 col-md-3">
                                                <label class="form-label">{{trans('common.company')}}</label>
                                                {{ Form::text('experience[Company][]',$experience['Company'],['class'=>'form-control']) }}
                                            </div>
                                            <div class="col-12 col-md-2">
                                                <label class="form-label">{{trans('common.EmploymentDate')}}</label>
                                                {{ Form::text('experience[EmploymentDate][]',$experience['EmploymentDate'],['class'=>'form-control']) }}
                                            </div>
                                            <div class="col-12 col-md-2">
                                                <label class="form-label">{{trans('common.EndEmploymentDate')}}</label>
                                                {{ Form::text('experience[EndEmploymentDate][]',$experience['EndEmploymentDate'],['class'=>'form-control']) }}
                                            </div>
                                            <div class="col-1 col-md-1 mt-2">
                                                <span class="delete btn btn-icon btn-danger">
                                                    {{trans('common.delete')}}
                                                </span>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="row">
                                        <div class="col-12 col-md-4">
                                            <label class="form-label">{{trans('common.job')}}</label>
                                            {{ Form::text('experience[Job][]','',['class'=>'form-control']) }}
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <label class="form-label">{{trans('common.company')}}</label>
                                            {{ Form::text('experience[Company][]','',['class'=>'form-control']) }}
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <label class="form-label">{{trans('common.EmploymentDate')}}</label>
                                            {{ Form::text('experience[EmploymentDate][]','',['class'=>'form-control']) }}
                                        </div>
                                        <div class="col-12 col-md-2">
                                            <label class="form-label">{{trans('common.EndEmploymentDate')}}</label>
                                            {{ Form::text('experience[EndEmploymentDate][]','',['class'=>'form-control']) }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="col-12 mt-2">
                                <span class="add_Experience btn btn-sm btn-info">{{trans('common.addnew')}} </span>
                            </div>
                        </div>

                        <div class="divider mt-3">
                            <div class="divider-text">الليـاقة البـدنية والـذهنية</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mb-1">
                                <label class="form-label" for="chronic_internal_diseases">{{trans('common.chronic_internal_diseases')}}</label>
                            </div>
                            <div class="col-sm-3">
                                <div class="demo-inline-spacing mt-0">
                                    <div class="form-check form-check-inline">
                                        {{Form::radio('chronic_internal_diseases[status]','1',$user->employmentProfile != '' ? $user->employmentProfile->toGetChoiceData('chronic_internal_diseases',1)['checked'] : false,['class'=>'form-check-input','id'=>'chronic_internal_diseases_yes'])}}
                                        <label class="form-check-label" for="chronic_internal_diseases_yes">{{trans('common.yes')}}</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        {{Form::radio('chronic_internal_diseases[status]','0',$user->employmentProfile != '' ? $user->employmentProfile->toGetChoiceData('chronic_internal_diseases',0)['checked'] : false,['class'=>'form-check-input','id'=>'chronic_internal_diseases_no'])}}
                                        <label class="form-check-label" for="chronic_internal_diseases_no">{{trans('common.no')}}</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        {{Form::radio('chronic_internal_diseases[status]','2',$user->employmentProfile != '' ? $user->employmentProfile->toGetChoiceData('chronic_internal_diseases',2)['checked'] : false,['class'=>'form-check-input','id'=>'chronic_internal_diseases_do_not_know'])}}
                                        <label class="form-check-label" for="chronic_internal_diseases_do_not_know">{{trans('common.don\'t_know')}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label">{{trans('common.specify')}}</label>
                                {{ Form::text('chronic_internal_diseases[text]',$user->employmentProfile != '' ? $user->employmentProfile->toGetChoiceData('chronic_internal_diseases')['text'] : '',['class'=>'form-control form-control-sm']) }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mb-1 pt-2">
                                <label class="form-label" for="pandemic_viruses">{{trans('common.pandemic_viruses')}}</label>
                            </div>
                            <div class="col-sm-3">
                                <div class="demo-inline-spacing mt-0">
                                    <div class="form-check form-check-inline">
                                        {{Form::radio('pandemic_viruses[status]','1',$user->employmentProfile != '' ? $user->employmentProfile->toGetChoiceData('pandemic_viruses',1)['checked'] : false,['class'=>'form-check-input','id'=>'pandemic_viruses_yes'])}}
                                        <label class="form-check-label" for="pandemic_viruses_yes">{{trans('common.yes')}}</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        {{Form::radio('pandemic_viruses[status]','0',$user->employmentProfile != '' ? $user->employmentProfile->toGetChoiceData('pandemic_viruses',0)['checked'] : false,['class'=>'form-check-input','id'=>'pandemic_viruses_no'])}}
                                        <label class="form-check-label" for="pandemic_viruses_no">{{trans('common.no')}}</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        {{Form::radio('pandemic_viruses[status]','2',$user->employmentProfile != '' ? $user->employmentProfile->toGetChoiceData('pandemic_viruses',2)['checked'] : false,['class'=>'form-check-input','id'=>'pandemic_viruses_do_not_know'])}}
                                        <label class="form-check-label" for="pandemic_viruses_do_not_know">{{trans('common.don\'t_know')}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label">{{trans('common.specify')}}</label>
                                {{ Form::text('pandemic_viruses[text]',$user->employmentProfile != '' ? $user->employmentProfile->toGetChoiceData('pandemic_viruses')['text'] : '',['class'=>'form-control form-control-sm']) }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mb-1 pt-2">
                                <label class="form-label" for="medicine">{{trans('common.medicine')}}</label>
                            </div>
                            <div class="col-sm-3">
                                <div class="demo-inline-spacing mt-0">
                                    <div class="form-check form-check-inline">
                                        {{Form::radio('medicine[status]','1',$user->employmentProfile != '' ? $user->employmentProfile->toGetChoiceData('medicine',1)['checked'] : false,['class'=>'form-check-input','id'=>'medicine_yes'])}}
                                        <label class="form-check-label" for="medicine_yes">{{trans('common.yes')}}</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        {{Form::radio('medicine[status]','0',$user->employmentProfile != '' ? $user->employmentProfile->toGetChoiceData('medicine',0)['checked'] : false,['class'=>'form-check-input','id'=>'medicine_no'])}}
                                        <label class="form-check-label" for="medicine_no">{{trans('common.no')}}</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        {{Form::radio('medicine[status]','2',$user->employmentProfile != '' ? $user->employmentProfile->toGetChoiceData('medicine',2)['checked'] : false,['class'=>'form-check-input','id'=>'medicine_do_not_know'])}}
                                        <label class="form-check-label" for="medicine_do_not_know">{{trans('common.don\'t_know')}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label">{{trans('common.specify')}}</label>
                                {{ Form::text('medicine[text]',$user->employmentProfile != '' ? $user->employmentProfile->toGetChoiceData('medicine')['text'] : '',['class'=>'form-control form-control-sm']) }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mb-1 pt-2">
                                <label class="form-label" for="hypersensitivity">{{trans('common.hypersensitivity')}}</label>
                            </div>
                            <div class="col-sm-3">
                                <div class="demo-inline-spacing mt-0">
                                    <div class="form-check form-check-inline">
                                        {{Form::radio('hypersensitivity[status]','1',$user->employmentProfile != '' ? $user->employmentProfile->toGetChoiceData('hypersensitivity',1)['checked'] : false,['class'=>'form-check-input','id'=>'hypersensitivity_yes'])}}
                                        <label class="form-check-label" for="hypersensitivity_yes">{{trans('common.yes')}}</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        {{Form::radio('hypersensitivity[status]','0',$user->employmentProfile != '' ? $user->employmentProfile->toGetChoiceData('hypersensitivity',0)['checked'] : false,['class'=>'form-check-input','id'=>'hypersensitivity_no'])}}
                                        <label class="form-check-label" for="hypersensitivity_no">{{trans('common.no')}}</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        {{Form::radio('hypersensitivity[status]','2',$user->employmentProfile != '' ? $user->employmentProfile->toGetChoiceData('hypersensitivity',2)['checked'] : false,['class'=>'form-check-input','id'=>'hypersensitivity_do_not_know'])}}
                                        <label class="form-check-label" for="hypersensitivity_do_not_know">{{trans('common.don\'t_know')}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label">{{trans('common.specify')}}</label>
                                {{ Form::text('hypersensitivity[text]',$user->employmentProfile != '' ? $user->employmentProfile->toGetChoiceData('hypersensitivity')['text'] : '',['class'=>'form-control form-control-sm']) }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mb-1 pt-2">
                                <label class="form-label" for="disability">{{trans('common.disability')}}</label>
                            </div>
                            <div class="col-sm-3">
                                <div class="demo-inline-spacing mt-0">
                                    <div class="form-check form-check-inline">
                                        {{Form::radio('disability[status]','1',$user->employmentProfile != '' ? $user->employmentProfile->toGetChoiceData('disability',1)['checked'] : false,['class'=>'form-check-input','id'=>'disability_yes'])}}
                                        <label class="form-check-label" for="disability_yes">{{trans('common.yes')}}</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        {{Form::radio('disability[status]','0',$user->employmentProfile != '' ? $user->employmentProfile->toGetChoiceData('disability',0)['checked'] : false,['class'=>'form-check-input','id'=>'disability_no'])}}
                                        <label class="form-check-label" for="disability_no">{{trans('common.no')}}</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        {{Form::radio('disability[status]','2',$user->employmentProfile != '' ? $user->employmentProfile->toGetChoiceData('disability',2)['checked'] : false,['class'=>'form-check-input','id'=>'disability_do_not_know'])}}
                                        <label class="form-check-label" for="disability_do_not_know">{{trans('common.don\'t_know')}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label">{{trans('common.specify')}}</label>
                                {{ Form::text('disability[text]',$user->employmentProfile != '' ? $user->employmentProfile->toGetChoiceData('disability')['text'] : '',['class'=>'form-control form-control-sm']) }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-5 mb-0 pt-2">
                                <label class="form-label" for="smoker">{{trans('common.smoker')}}</label>
                            </div>
                            <div class="col-sm-3">
                                <div class="demo-inline-spacing mt-0">
                                    <div class="form-check form-check-inline">
                                        {{Form::radio('smoker','1',$user->employmentProfile != '' ? $user->employmentProfile->toGetChoiceData('smoker',1)['checked'] : false,['class'=>'form-check-input','id'=>'smoker_yes'])}}
                                        <label class="form-check-label" for="smoker_yes">{{trans('common.yes')}}</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        {{Form::radio('smoker','1',$user->employmentProfile != '' ? $user->employmentProfile->toGetChoiceData('smoker',0)['checked'] : false,['class'=>'form-check-input','id'=>'smoker_no'])}}
                                        <label class="form-check-label" for="smoker_no">{{trans('common.no')}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-5 mb-0 pt-2">
                                <label class="form-label" for="medical_glasses">{{trans('common.medical_glasses')}}</label>
                            </div>
                            <div class="col-sm-3">
                                <div class="demo-inline-spacing mt-0">
                                    <div class="form-check form-check-inline">
                                        {{Form::radio('medical_glasses','1',$user->employmentProfile != '' ? $user->employmentProfile->toGetChoiceData('medical_glasses',1)['checked'] : false,['class'=>'form-check-input','id'=>'medical_glasses_yes'])}}
                                        <label class="form-check-label" for="medical_glasses_yes">{{trans('common.yes')}}</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        {{Form::radio('medical_glasses','1',$user->employmentProfile != '' ? $user->employmentProfile->toGetChoiceData('medical_glasses',0)['checked'] : false,['class'=>'form-check-input','id'=>'medical_glasses_no'])}}
                                        <label class="form-check-label" for="medical_glasses_no">{{trans('common.no')}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-5 mb-0 pt-2">
                                <label class="form-label" for="medical_ear_headphones">{{trans('common.medical_ear_headphones')}}</label>
                            </div>
                            <div class="col-sm-3">
                                <div class="demo-inline-spacing mt-0">
                                    <div class="form-check form-check-inline">
                                        {{Form::radio('medical_ear_headphones','1',$user->employmentProfile != '' ? $user->employmentProfile->toGetChoiceData('medical_ear_headphones',1)['checked'] : false,['class'=>'form-check-input','id'=>'medical_ear_headphones_yes'])}}
                                        <label class="form-check-label" for="medical_ear_headphones_yes">{{trans('common.yes')}}</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        {{Form::radio('medical_ear_headphones','1',$user->employmentProfile != '' ? $user->employmentProfile->toGetChoiceData('medical_ear_headphones',0)['checked'] : false,['class'=>'form-check-input','id'=>'medical_ear_headphones_no'])}}
                                        <label class="form-check-label" for="medical_ear_headphones_no">{{trans('common.no')}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-5 mb-0 pt-2">
                                <label class="form-label" for="severe_injuries">{{trans('common.severe_injuries')}}</label>
                            </div>
                            <div class="col-sm-3">
                                <div class="demo-inline-spacing mt-0">
                                    <div class="form-check form-check-inline">
                                        {{Form::radio('severe_injuries','1',$user->employmentProfile != '' ? $user->employmentProfile->toGetChoiceData('severe_injuries',1)['checked'] : false,['class'=>'form-check-input','id'=>'severe_injuries_yes'])}}
                                        <label class="form-check-label" for="severe_injuries_yes">{{trans('common.yes')}}</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        {{Form::radio('severe_injuries','1',$user->employmentProfile != '' ? $user->employmentProfile->toGetChoiceData('severe_injuries',0)['checked'] : false,['class'=>'form-check-input','id'=>'severe_injuries_no'])}}
                                        <label class="form-check-label" for="severe_injuries_no">{{trans('common.no')}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-5 mb-0 pt-2">
                                <label class="form-label" for="surgery">{{trans('common.surgery')}}</label>
                            </div>
                            <div class="col-sm-3">
                                <div class="demo-inline-spacing mt-0">
                                    <div class="form-check form-check-inline">
                                        {{Form::radio('surgery','1',$user->employmentProfile != '' ? $user->employmentProfile->toGetChoiceData('surgery',1)['checked'] : false,['class'=>'form-check-input','id'=>'surgery_yes'])}}
                                        <label class="form-check-label" for="surgery_yes">{{trans('common.yes')}}</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        {{Form::radio('surgery','1',$user->employmentProfile != '' ? $user->employmentProfile->toGetChoiceData('surgery',0)['checked'] : false,['class'=>'form-check-input','id'=>'surgery_no'])}}
                                        <label class="form-check-label" for="surgery_no">{{trans('common.no')}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label">{{trans('common.medical_issues')}}</label>
                                {{ Form::textarea('medical_issues','',['rows'=>'3','class'=>'form-control form-control-sm']) }}
                            </div>
                        </div>


                        <div class="divider mt-3">
                            <div class="divider-text">الحالة الجنائية والأهلية القانونية</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-7 mb-0 pt-2">
                                <label class="form-label" for="judged">{{trans('common.judged')}}</label>
                            </div>
                            <div class="col-sm-3">
                                <div class="demo-inline-spacing mt-0">
                                    <div class="form-check form-check-inline">
                                        {{Form::radio('judged','1',$user->employmentProfile != '' ? $user->employmentProfile->toGetChoiceData('judged',1)['checked'] : false,['class'=>'form-check-input','id'=>'judged_yes'])}}
                                        <label class="form-check-label" for="judged_yes">{{trans('common.yes')}}</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        {{Form::radio('judged','0',$user->employmentProfile != '' ? $user->employmentProfile->toGetChoiceData('judged',0)['checked'] : false,['class'=>'form-check-input','id'=>'judged_no'])}}
                                        <label class="form-check-label" for="judged_no">{{trans('common.no')}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-7 mb-0 pt-2">
                                <label class="form-label" for="wanted_for_cases">{{trans('common.wanted_for_cases')}}</label>
                            </div>
                            <div class="col-sm-3">
                                <div class="demo-inline-spacing mt-0">
                                    <div class="form-check form-check-inline">
                                        {{Form::radio('wanted_for_cases','1',$user->employmentProfile != '' ? $user->employmentProfile->toGetChoiceData('wanted_for_cases',1)['checked'] : false,['class'=>'form-check-input','id'=>'wanted_for_cases_yes'])}}
                                        <label class="form-check-label" for="wanted_for_cases_yes">{{trans('common.yes')}}</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        {{Form::radio('wanted_for_cases','0',$user->employmentProfile != '' ? $user->employmentProfile->toGetChoiceData('wanted_for_cases',0)['checked'] : false,['class'=>'form-check-input','id'=>'wanted_for_cases_no'])}}
                                        <label class="form-check-label" for="wanted_for_cases_no">{{trans('common.no')}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-7 mb-0 pt-2">
                                <label class="form-label" for="lecturer_against_you">{{trans('common.lecturer_against_you')}}</label>
                            </div>
                            <div class="col-sm-3">
                                <div class="demo-inline-spacing mt-0">
                                    <div class="form-check form-check-inline">
                                        {{Form::radio('lecturer_against_you','1',$user->employmentProfile != '' ? $user->employmentProfile->toGetChoiceData('lecturer_against_you',1)['checked'] : false,['class'=>'form-check-input','id'=>'lecturer_against_you_yes'])}}
                                        <label class="form-check-label" for="lecturer_against_you_yes">{{trans('common.yes')}}</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        {{Form::radio('lecturer_against_you','0',$user->employmentProfile != '' ? $user->employmentProfile->toGetChoiceData('lecturer_against_you',0)['checked'] : false,['class'=>'form-check-input','id'=>'lecturer_against_you_no'])}}
                                        <label class="form-check-label" for="lecturer_against_you_no">{{trans('common.no')}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-7 mb-0 pt-2">
                                <label class="form-label" for="judicial_Disputes">{{trans('common.judicial_Disputes')}}</label>
                            </div>
                            <div class="col-sm-3">
                                <div class="demo-inline-spacing mt-0">
                                    <div class="form-check form-check-inline">
                                        {{Form::radio('judicial_Disputes','1',$user->employmentProfile != '' ? $user->employmentProfile->toGetChoiceData('judicial_Disputes',1)['checked'] : false,['class'=>'form-check-input','id'=>'judicial_Disputes_yes'])}}
                                        <label class="form-check-label" for="judicial_Disputes_yes">{{trans('common.yes')}}</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        {{Form::radio('judicial_Disputes','0',$user->employmentProfile != '' ? $user->employmentProfile->toGetChoiceData('judicial_Disputes',0)['checked'] : false,['class'=>'form-check-input','id'=>'judicial_Disputes_no'])}}
                                        <label class="form-check-label" for="judicial_Disputes_no">{{trans('common.no')}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-7 mb-0 pt-2">
                                <label class="form-label" for="debts_or_mortgages">{{trans('common.debts_or_mortgages')}}</label>
                            </div>
                            <div class="col-sm-3">
                                <div class="demo-inline-spacing mt-0">
                                    <div class="form-check form-check-inline">
                                        {{Form::radio('debts_or_mortgages','1',$user->employmentProfile != '' ? $user->employmentProfile->toGetChoiceData('debts_or_mortgages',1)['checked'] : false,['class'=>'form-check-input','id'=>'debts_or_mortgages_yes'])}}
                                        <label class="form-check-label" for="debts_or_mortgages_yes">{{trans('common.yes')}}</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        {{Form::radio('debts_or_mortgages','0',$user->employmentProfile != '' ? $user->employmentProfile->toGetChoiceData('debts_or_mortgages',0)['checked'] : false,['class'=>'form-check-input','id'=>'debts_or_mortgages_no'])}}
                                        <label class="form-check-label" for="debts_or_mortgages_no">{{trans('common.no')}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="divider mt-3">
                            <div class="divider-text">بيانات الوظيفة</div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-4">
                                <label class="form-label" for="management_id">{{trans('common.management')}}</label>
                                {{Form::select('management_id',managementsList(),$user->employmentProfile->management_id ?? '',['id'=>'management_id', 'class'=>'form-select'])}}
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label" for="job_id">{{trans('common.job')}}</label>
                                {{Form::select('job_id',jobsList(),$user->employmentProfile->job_id ?? '',['id'=>'job_id', 'class'=>'form-select'])}}
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label" for="emplpoyment_date">{{trans('common.job')}}</label>
                                {{Form::date('emplpoyment_date',$user->employmentProfile->emplpoyment_date ?? date('Y-m-d'),['id'=>'emplpoyment_date', 'class'=>'form-select'])}}
                            </div>
                            <div class="col-sm-6 mb-0 pt-2">
                                <label class="form-label" for="judicial_Disputes">نظام احتساب الأجر</label>
                                <div class="demo-inline-spacing mt-0">
                                    <div class="form-check form-check-inline">
                                        {{Form::checkbox('salary_type[]','hours',$user->employmentProfile != '' ? $user->employmentProfile->salaryType('hours')['checked'] : false,['class'=>'form-check-input','id'=>'salary_type_hours'])}}
                                        <label class="form-check-label" for="salary_type_hours">بالساعة</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        {{Form::checkbox('salary_type[]','salary',$user->employmentProfile != '' ? $user->employmentProfile->salaryType('salary')['checked'] : false,['class'=>'form-check-input','id'=>'salary_type_salary'])}}
                                        <label class="form-check-label" for="salary_type_salary">بالمرتب</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        {{Form::checkbox('salary_type[]','reward',$user->employmentProfile != '' ? $user->employmentProfile->salaryType('reward')['checked'] : false,['class'=>'form-check-input','id'=>'salary_type_reward'])}}
                                        <label class="form-check-label" for="salary_type_reward">بالمكافأة</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        {{Form::checkbox('salary_type[]','commission',$user->employmentProfile != '' ? $user->employmentProfile->salaryType('commission')['checked'] : false,['class'=>'form-check-input','id'=>'salary_type_commission'])}}
                                        <label class="form-check-label" for="salary_type_commission">بالنسبة</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 mb-0 pt-2">
                                <label class="form-label" for="judicial_Disputes">نظام تقاضي الأجر</label>
                                <div class="demo-inline-spacing mt-0">
                                    <div class="form-check form-check-inline">
                                        {{Form::radio('salary_request_type','per_project',$user->employmentProfile != '' ? $user->employmentProfile->toGetChoiceData('salary_request_type','per_project')['checked'] : false,['class'=>'form-check-input','id'=>'salary_request_type_per_project'])}}
                                        <label class="form-check-label" for="salary_request_type_per_project">نظير إتمام العمل</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        {{Form::radio('salary_request_type','daily',$user->employmentProfile != '' ? $user->employmentProfile->toGetChoiceData('salary_request_type','daily')['checked'] : false,['class'=>'form-check-input','id'=>'salary_request_type_daily'])}}
                                        <label class="form-check-label" for="salary_request_type_daily">يومياً</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        {{Form::radio('salary_request_type','reward',$user->employmentProfile != '' ? $user->employmentProfile->toGetChoiceData('salary_request_type','reward')['checked'] : false,['class'=>'form-check-input','id'=>'salary_request_type_reward'])}}
                                        <label class="form-check-label" for="salary_request_type_reward">أسبوعياً</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        {{Form::radio('salary_request_type','commission',$user->employmentProfile != '' ? $user->employmentProfile->toGetChoiceData('salary_request_type','commission')['checked'] : false,['class'=>'form-check-input','id'=>'salary_request_type_commission'])}}
                                        <label class="form-check-label" for="salary_request_type_commission">شهرياً</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="divider mt-3">
                            <div class="divider-text">{{trans('common.attachments')}}</div>
                        </div>


                        <div class="row d-flex justify-content-center">
                            <div class="col-md-12 text-center mt-2">
                                @if($user->employmentProfile != '' && $user->employmentProfile->attachments != '')
                                    <div class="row mb-2">
                                        {!!$user->employmentProfile->attachmentsHtml()!!}
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

@section('scripts')
    <script type="text/template" id="RepeatQualificationTPL">
        <div class="More row">
            <div class="col-12 col-md-4">
                <label class="form-label">{{trans('common.name')}}</label>
                {{ Form::text('qualifications[Title][]','',['id'=>'qualificationsTitle','class'=>'form-control']) }}
            </div>
            <div class="col-12 col-md-3">
                <label class="form-label">{{trans('common.university')}}</label>
                {{ Form::text('qualifications[University][]','',['class'=>'form-control']) }}
            </div>
            <div class="col-12 col-md-2">
                <label class="form-label">{{trans('common.college')}}</label>
                {{ Form::text('qualifications[College][]','',['class'=>'form-control']) }}
            </div>
            <div class="col-12 col-md-2">
                <label class="form-label">{{trans('common.year')}}</label>
                {{ Form::text('qualifications[Year][]','',['class'=>'form-control']) }}
            </div>
            <div class="col-1 col-md-1 mt-2">
                <span class="delete btn btn-icon btn-danger">
                    {{trans('common.delete')}}
                </span>
            </div>
        </div>
    </script>

    <script type="text/template" id="RepeatExperienceTPL">
        <div class="More row">
            <div class="col-12 col-md-4">
                <label class="form-label">{{trans('common.job')}}</label>
                {{ Form::text('experience[Job][]','',['class'=>'form-control']) }}
            </div>
            <div class="col-12 col-md-3">
                <label class="form-label">{{trans('common.company')}}</label>
                {{ Form::text('experience[Company][]','',['class'=>'form-control']) }}
            </div>
            <div class="col-12 col-md-2">
                <label class="form-label">{{trans('common.EmploymentDate')}}</label>
                {{ Form::text('experience[EmploymentDate][]','',['class'=>'form-control']) }}
            </div>
            <div class="col-12 col-md-2">
                <label class="form-label">{{trans('common.EndEmploymentDate')}}</label>
                {{ Form::text('experience[EndEmploymentDate][]','',['class'=>'form-control']) }}
            </div>
            <div class="col-1 col-md-1 mt-2">
                <span class="delete btn btn-icon btn-danger">
                    {{trans('common.delete')}}
                </span>
            </div>
        </div>
    </script>

    <script type="text/javascript">
        $(document).ready(function() {

            var max_fields              = 50;
            var Qualification_wrapper   = $(".repeatableQualifications");
            var add_Qualification       = $(".add_Qualification");
            var RepeatQualificationTPL  = $("#RepeatQualificationTPL").html();


            var x = 1;
            $(add_Qualification).click(function(e){
                e.preventDefault();
                if(x < max_fields){
                    x++;
                    $(Qualification_wrapper).append(RepeatQualificationTPL); //add input box
                }else{
                    alert('You Reached the limits')
                }
            });

            $(Qualification_wrapper).on("click",".delete", function(e){
                e.preventDefault(); $(this).closest('.More').remove(); x--;
            });


            /**
             * 
             * 
             */
            var max_fields              = 50;
            var Experience_wrapper   = $(".repeatableExperiences");
            var add_Experience       = $(".add_Experience");
            var RepeatExperienceTPL  = $("#RepeatExperienceTPL").html();


            var x = 1;
            $(add_Experience).click(function(e){
                e.preventDefault();
                if(x < max_fields){
                    x++;
                    $(Experience_wrapper).append(RepeatExperienceTPL); //add input box
                }else{
                    alert('You Reached the limits')
                }
            });

            $(Experience_wrapper).on("click",".delete", function(e){
                e.preventDefault(); $(this).closest('.More').remove(); x--;
            });


        });
    </script>

@stop
