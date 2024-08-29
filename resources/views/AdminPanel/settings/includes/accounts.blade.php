<!-- form -->
<div class="row">
    <div class="col-12 col-md-6">
        <label class="form-label" for="basePulseCost">سعر النبضة الأساسي</label>
        {{Form::text('basePulseCost',getSettingValue('basePulseCost') != '' ? getSettingValue('basePulseCost') : '0.35',['id'=>'basePulseCost','class'=>'form-control'])}}
    </div>
</div>