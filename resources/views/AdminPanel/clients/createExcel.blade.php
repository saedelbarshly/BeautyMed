<a href="javascript:;" data-bs-target="#createExcelClient" data-bs-toggle="modal" class="btn btn-sm btn-primary">
    {{trans('common.uploadExcel')}}
</a>

<div class="modal fade text-md-start" id="createExcelClient" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-5 px-sm-5 pt-50">
                <div class="text-center mb-2">
                    <h1 class="mb-1">{{trans('common.uploadExcel')}}</h1>
                </div>
                {{Form::open(['url'=>route('admin.clients.storeExcelClient'), 'id'=>'createExcelClientForm', 'class'=>'row gy-1 pt-75'])}}
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="file"><b>{{trans('common.file')}}</b> <small>يسمح برفع ملفات xlsx فقط</small></label>
                        <input class="form-control" id="file" name="excel" type="file">
                        @if($errors->has('excel'))
                            <span class="text-danger" role="alert">
                                <b>{{ $errors->first('excel') }}</b>
                            </span>
                        @endif
                    </div>
                    @if(userCan('clients_view'))
                        <div class="col-12 col-md-3">
                            <label class="form-label" for="branch"><b>{{trans('common.branch')}}</b></label>
                            <?php $branchesList = App\Models\Branches::orderBy('name','asc')->pluck('name','id')->all(); ?>
                            {{Form::select('branch_id',['all'=>'الجميع'] + $branchesList,'',['id'=>'branch', 'class'=>'selectpicker'])}}
                        </div>
                    @endif
                    @if(userCan('clients_team_create') || userCan('clients_branch_create') || userCan('clients_all_company_create'))
                        <div class="col-12 col-md-3">
                            <label class="form-label" for="user"><b>{{trans('common.user')}}</b></label>
                            {{Form::select('user_id',[
                                                        '0'=>'بدون توزيع',
                                                        'file' => 'توزيع حسب الملف'
                                                        ] + agentsListForSearch(),'',['id'=>'branch', 'class'=>'selectpicker'])}}
                        </div>
                    @endif
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
