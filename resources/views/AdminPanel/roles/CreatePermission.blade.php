<a href="javascript:;" data-bs-target="#createPermission" data-bs-toggle="modal" class="btn btn-primary btn-sm">
    صلاحية جديدة
</a>

<div class="modal fade text-md-start" id="createPermission" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-5 px-sm-5 pt-50">
                <div class="text-center mb-2">
                    <h1 class="mb-1">{{trans('common.CreateNew')}}</h1>
                </div>
                {{Form::open(['url'=>route('admin.CreatePermission'), 'id'=>'createRoleForm', 'class'=>'row gy-1 pt-75'])}}
                    <div class="col-12 col-md-4">
                        <label class="form-label" for="name_ar">اسم الصلاحية</label>
                        {{Form::text('name_ar','',['id'=>'name_ar', 'class'=>'form-control','required'])}}
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label" for="can">الصلاحية (بالإنجليزية فقط)</label>
                        {{Form::text('can','',['id'=>'can', 'class'=>'form-control' ,'required'])}}
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label" for="group">مجموعة الصلاحيات</label>
                        {{Form::select('group',systemMainSections(),'',['id'=>'group', 'class'=>'form-control'])}}
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
