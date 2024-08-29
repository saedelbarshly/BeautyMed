<!-- form -->
<div class="row">


     <!-- home -->
    <div class="divider">
        <div class="divider-text">{{trans('common.demoData')}}</div>
    </div>
   
        <div class="row pt-2 pb-4">
            <h3>{{trans('common.photo')}} </h3>
            
            <div class="col-md-12"></div>
            <div class="col-12 col-md-4" style="margin-top:20px">
                {!! getSettingImageValue('logoImage') !!}
                <div class="file-loading"> 
                    <input class="files" name="logoImage" type="file">
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="col-12 col-md-12">
                <label class="form-label" for="logoTitle">{{trans('common.title')}}</label>
                {{Form::text('logoTitle',getSettingValue('logoTitle'),['id'=>'logoTitle','class'=>'form-control'])}}
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="col-12 col-md-12">
                <label class="form-label" for="clientCode">{{trans('common.code')}}</label>
                {{Form::text('clientCode',getSettingValue('clientCode'),['id'=>'clientCode','class'=>'form-control'])}}
                </div>
            </div>

            <div class="col-md-12"></div>
            <div class="col-12 col-md-12">
                <div class="col-12 col-md-12">
                    <label class="form-label" for="logoDescription">{{trans('common.des')}}</label>
                    {{Form::textarea('logoDescription',getSettingValue('logoDescription'),['id'=>'logoDescription','class'=>'form-control','rows'=>'3'])}}
                </div>
            </div>
            
        </div>
 

   

</div>
<!--/ form -->