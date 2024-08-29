<a href="javascript:;" data-bs-target="#createExpense" data-bs-toggle="modal" class="btn btn-sm btn-primary">
    {{trans('common.CreateNew')}}
</a>

<div class="modal fade text-md-start" id="createExpense" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-5 px-sm-5 pt-50">
                <div class="text-center mb-2">
                    <h1 class="mb-1">{{trans('common.CreateNew')}}</h1>
                </div>
                {{Form::open(['files'=>'true','url'=>route('admin.expenses.store'), 'id'=>'createExpenseForm', 'class'=>'row gy-1 pt-75'])}}
                    <div class="col-12 col-md-4">
                        <label class="form-label" for="ExpenseDate">{{trans('common.date')}}</label>
                        {{Form::date('ExpenseDate','',['id'=>'ExpenseDate', 'class'=>'form-control','required'])}}
                    </div> 
                    <div class="col-12 col-md-4">
                        <label class="form-label" for="Expense">{{trans('common.amount')}}</label>
                        {{Form::number('Expense','',['step'=>'.01','id'=>'Expense', 'class'=>'form-control','required'])}}
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label" for="Type">{{trans('common.type')}}</label>
                        {{Form::select('Type',expensesTypes(session()->get('Lang')),'',['id'=>'Type', 'class'=>'form-select','required'])}}
                    </div>

                    <div class="col-12 col-sm-4">
                        <label class="form-label" for="service_id">{{trans('common.service')}}</label>
                        {{Form::select('service_id', ['0'=>'بدون تحديد'] + serviceList(),'',['id'=>'service_id','class'=>'form-select','required'])}}
                    </div>
 
                    <div class="col-12 col-md-4">
                        <label class="form-label" for="safe_id">{{trans('common.safe')}}</label>
                        {{Form::select('safe_id',safesList(),'',['id'=>'safe_id', 'class'=>'form-select','required'])}}
                    </div>
                    <div class="col-12 col-md-12">
                        <label class="form-label" for="Des">{{trans('common.expensesDetails')}}</label>
                        {{Form::textarea('Des','',['rows'=>'2','id'=>'Des', 'class'=>'form-control','required'])}}
                    </div>
  
                    <div class="divider">
                        <div class="divider-text">{{trans('common.files')}}</div>
                    </div>

                    <div class="row d-flex justify-content-center">
                        <div class="col-md-12 text-center">
                            <label class="form-label" for="Attachments">{{trans('common.attachment')}}</label>
                            <div class="file-loading"> 
                                <input class="files" name="Attachments[]" type="file" multiple>
                            </div>
                        </div>
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
