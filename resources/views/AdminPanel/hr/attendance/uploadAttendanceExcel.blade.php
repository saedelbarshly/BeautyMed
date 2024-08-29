<a href="javascript:;" data-bs-target="#uploadAttendaceExcel" data-bs-toggle="modal" class="btn btn-primary btn-sm">
    {{trans('common.uploadAttendaceExcel')}}
</a>

<div class="modal fade text-md-start" id="uploadAttendaceExcel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-5 px-sm-5 pt-50">
                <div class="text-center mb-2">
                    <h1 class="mb-1">{{trans('common.uploadAttendaceExcel')}}</h1>
                </div>
                {{Form::open(['files'=>'true','url'=>route('admin.attendace.excel'), 'id'=>'uploadAttendaceExcelForm', 'class'=>'row gy-1 pt-75'])}}
                    <div class="col-12 col-md-9">
                        <label class="form-label" for="file">{{trans('common.file')}}</label>
                        <div class="file-loading">
                            <input class="files" name="file" type="file">
                        </div>
                        @if($errors->has('file'))
                            <span class="text-danger" role="alert">
                                <b>{{ $errors->first('file') }}</b>
                            </span>
                        @endif
                    </div>
                    @if(env('APP_BRANCH') == 1) )
                    <div class="col-12 col-md-3">
                        <label class="form-label" for="branch">{{trans('common.branch')}}</label>
                        <?php $branchesList = App\Models\Branches::orderBy('name','asc')->pluck('name','id')->all(); ?>
                        {{Form::select('branch_id',$branchesList,'',['id'=>'branch', 'class'=>'form-control'])}}
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
