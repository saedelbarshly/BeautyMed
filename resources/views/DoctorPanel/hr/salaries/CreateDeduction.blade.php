<a href="javascript:;" data-bs-target="#CreateNewDeduction" data-bs-toggle="modal" class="btn btn-primary btn-sm">
    {{trans('common.CreateNewDeduction')}}
</a>

<div class="modal fade text-md-start" id="CreateNewDeduction" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-5 px-sm-5 pt-50">
                <div class="text-center mb-2">
                    <h1 class="mb-1">{{trans('common.CreateNewDeduction')}}</h1>
                </div>
                {{Form::open(['url'=>route('admin.deductions.store'), 'id'=>'createRoleForm', 'class'=>'row gy-1 pt-75'])}}
                    <div class="col-12 col-md-3">
                        <label class="form-label" for="DeductionDate">{{trans('common.date')}}</label>
                        {{Form::date('DeductionDate','',['id'=>'DeductionDate', 'class'=>'form-control','required'])}}
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="form-label" for="Type">{{trans('common.type')}}</label>
                        {{Form::select('Type',deductionTypesArray(session()->get('Lang'))['list'],'',['id'=>'Type', 'class'=>'form-control'])}}
                    </div>
                    <div class="col-12 col-md-2">
                        <label class="form-label" for="Deduction">{{trans('common.amount')}}</label>
                        {{Form::number('Deduction','',['id'=>'Deduction', 'class'=>'form-control'])}}
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label" for="EmployeeID">{{trans('common.user')}}</label>
                        {{Form::select('EmployeeID',getActiveUsersList(),'',['id'=>'EmployeeID', 'class'=>'selectpicker', 'data-live-search'=>'true' ,'required'])}}
                    </div>
                    <div class="col-12 col-md-12">
                        <label class="form-label" for="Reason">{{trans('common.Reason')}}</label>
                        {{Form::textarea('Reason','',['id'=>'Reason', 'class'=>'form-control','rows'=>'3'])}}
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
