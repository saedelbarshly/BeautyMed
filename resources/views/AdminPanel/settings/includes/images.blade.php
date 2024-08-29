<!-- form -->
<div class="row">
    <div class="col-md-3 text-center">
        {!! getSettingImageValue('logo') !!}
        <div class="file-loading"> 
            <input class="files" name="logo" type="file">
        </div>
    </div>
    <div class="col-md-3 text-center">
        {!! getSettingImageValue('fav') !!}
        <div class="file-loading"> 
            <input class="files" name="fav" type="file">
        </div>
    </div>
    <div class="divider">
        <div class="divider-text">{{trans('common.homeSlider')}}</div>
    </div>
    @for($i=1;$i<=5;$i++)
        <div class="row pt-2 pb-4">
            <h3>{{trans('common.photo')}} #{{$i}}</h3>
            <div class="col-md-4 text-center">
                {!! getSettingImageValue('home_slide'.$i.'img') !!}
                <div class="file-loading"> 
                    <input class="files" name="home_slide{{$i}}img" type="file">
                </div>
            </div>
            <div class="col-md-12"></div>
            <div class="col-12 col-md-4">
                <label class="form-label" for="slide{{$i}}title_ar">{{trans('common.title_ar')}}</label>
                {{Form::text('home_slide'.$i.'title_ar',getSettingValue('home_slide'.$i.'title_ar'),['id'=>'home_slide'.$i.'title_ar','class'=>'form-control'])}}
            </div>
            <div class="col-12 col-md-4">
                <label class="form-label" for="slide{{$i}}title_en">{{trans('common.title_en')}}</label>
                {{Form::text('home_slide'.$i.'title_en',getSettingValue('home_slide'.$i.'title_en'),['id'=>'home_slide'.$i.'title_en','class'=>'form-control'])}}
            </div>
            <div class="col-12 col-md-4">
                <label class="form-label" for="slide{{$i}}title_fr">{{trans('common.title_fr')}}</label>
                {{Form::text('home_slide'.$i.'title_fr',getSettingValue('home_slide'.$i.'title_fr'),['id'=>'home_slide'.$i.'title_fr','class'=>'form-control'])}}
            </div>
            <div class="col-md-12"></div>
            <div class="col-12 col-md-4">
                <label class="form-label" for="slide{{$i}}des_ar">{{trans('common.des_ar')}}</label>
                {{Form::textarea('home_slide'.$i.'des_ar',getSettingValue('home_slide'.$i.'des_ar'),['id'=>'home_slide'.$i.'des_ar','class'=>'form-control','rows'=>'3'])}}
            </div>
            <div class="col-12 col-md-4">
                <label class="form-label" for="slide{{$i}}des_en">{{trans('common.des_en')}}</label>
                {{Form::textarea('home_slide'.$i.'des_en',getSettingValue('home_slide'.$i.'des_en'),['id'=>'home_slide'.$i.'des_en','class'=>'form-control','rows'=>'3'])}}
            </div>
            <div class="col-12 col-md-4">
                <label class="form-label" for="slide{{$i}}des_fr">{{trans('common.des_fr')}}</label>
                {{Form::textarea('home_slide'.$i.'des_fr',getSettingValue('home_slide'.$i.'des_fr'),['id'=>'home_slide'.$i.'des_fr','class'=>'form-control','rows'=>'3'])}}
            </div>
            <div class="col-md-12"></div>
            <div class="col-12 col-md-4">
                <label class="form-label" for="slide{{$i}}btnTxt_ar">{{trans('common.btnTxt_ar')}}</label>
                {{Form::text('home_slide'.$i.'btnTxt_ar',getSettingValue('home_slide'.$i.'btnTxt_ar'),['id'=>'home_slide'.$i.'btnTxt_ar','class'=>'form-control'])}}
            </div>
            <div class="col-12 col-md-4">
                <label class="form-label" for="slide{{$i}}btnTxt_en">{{trans('common.btnTxt_en')}}</label>
                {{Form::text('home_slide'.$i.'btnTxt_en',getSettingValue('home_slide'.$i.'btnTxt_en'),['id'=>'home_slide'.$i.'btnTxt_en','class'=>'form-control'])}}
            </div>
            <div class="col-12 col-md-4">
                <label class="form-label" for="slide{{$i}}btnTxt_fr">{{trans('common.btnTxt_fr')}}</label>
                {{Form::text('home_slide'.$i.'btnTxt_fr',getSettingValue('home_slide'.$i.'btnTxt_fr'),['id'=>'home_slide'.$i.'btnTxt_fr','class'=>'form-control'])}}
            </div>
            <div class="col-md-12"></div>
            <div class="col-12 col-md-12">
                <label class="form-label" for="slide{{$i}}btnLink">{{trans('common.btnLink')}}</label>
                {{Form::text('home_slide'.$i.'btnLink',getSettingValue('home_slide'.$i.'btnLink'),['id'=>'home_slide'.$i.'btnLink','class'=>'form-control'])}}
            </div>
        </div>
    @endfor
</div>
<!--/ form -->