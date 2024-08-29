<a href="javascript:;" data-bs-target="#PayMonthSalary" data-bs-toggle="modal" class="btn btn-primary btn-sm">
    {{trans('common.PayMonthSalary')}}
</a>

<div class="modal fade text-md-start" id="PayMonthSalary" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-5 px-sm-5 pt-50">
                <div class="text-center mb-2">
                    <h1 class="mb-1">{{trans('common.PayMonthSalary')}}</h1>
                </div>
                {{Form::open(['url'=>route('admin.payOutSalary',['id'=>$user->id,'month'=>$month,'year'=>$year]), 'id'=>'createSalaryForm'])}}
                    <div class="row justify-content-center">
                        <div class="col-md-3 my-2">
                            <b>{{trans('common.forMonth')}}: </b>
                            {{arabicMonth($year.'-'.$month.'-1')}}
                        </div>
                        <div class="col-md-3 my-2">
                            <b>{{trans('common.forYear')}}: </b>
                            {{$year}}
                        </div>
                        <div class="col-md-4 my-2">
                            <b>{{trans('common.byUser')}}: </b>
                            {{auth()->user()->name}}
                        </div>
                        <div class="col-12 col-md-3 my-2">
                            <label class="form-label" for="Date">{{trans('common.date')}}</label>
                            {{Form::date('Date',date('Y-m-d'),['id'=>'Date', 'class'=>'form-control','required'])}}
                        </div>
                        <div class="col-12 col-md-3 my-2">
                            <label class="form-label" for="DeliveredSalary">{{trans('common.amount')}}</label>
                            {{Form::number('DeliveredSalary',round($user->monthSalary($month,$year)['net']),['step'=>'.01','id'=>'DeliveredSalary', 'class'=>'form-control'])}}
                        </div>
                        <div class="col-12 col-md-3 my-2">
                            <label class="form-label" for="SafeID">{{trans('common.safe')}}</label>
                            {{Form::select('SafeID',safesList(),'',['id'=>'SafeID', 'class'=>'form-select','required'])}}
                        </div>
                        <div class="col-12 text-center mt-2 pt-50">
                            <button type="submit" class="btn btn-primary me-1">{{trans('common.Save changes')}}</button>
                            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                                {{trans('common.Cancel')}}
                            </button>
                        </div>
                    </div>        
                {{Form::close()}}
            </div>
        </div>
    </div>
</div>
