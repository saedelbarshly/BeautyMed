<div class="modal fade text-md-start" id="vacationPermission{{$user->id}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-5 px-sm-5 pt-50">
                <div class="text-center mb-2">
                    <h1 class="mb-1">{{trans('common.vacationPermission')}}</h1>
                    <p>{{$user->name}}</p>
                </div>
                {{Form::open(['url'=>route('admin.AddVacation',$user->id), 'id'=>'AddVacationForm', 'class'=>'row gy-1 pt-75'])}}
                    <div class="col-12 col-md-3">
                        <label class="form-label" for="from">{{trans('common.from')}}</label>
                        {{Form::date('from','',['id'=>'from', 'class'=>'form-control','required'])}}
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="form-label" for="to">{{trans('common.to')}}</label>
                        {{Form::date('to','',['id'=>'to', 'class'=>'form-control','required'])}}
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="form-label" for="type">{{trans('common.type')}}</label>
                        {{Form::select('type',vacationTypesArray(session()->get('Lang')),'',['id'=>'Type', 'class'=>'form-control'])}}
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="form-label" for="isPaid">{{trans('common.isPaid')}}</label>
                        <div class="form-check form-check-success form-switch">
                            {{Form::checkbox('isPaid','1',false,['id'=>'isPaid', 'class'=>'form-check-input'])}}
                            <label class="form-check-label" for="isPaid"></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-12">
                        <label class="form-label" for="reason">{{trans('common.Reason')}}</label>
                        {{Form::textarea('reason','',['id'=>'reason', 'class'=>'form-control','rows'=>'3'])}}
                    </div>
                                
                    <div class="col-12 text-center mt-2 pt-50">
                        <button type="submit" class="btn btn-primary me-1">{{trans('common.Save changes')}}</button>
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                            {{trans('common.Cancel')}}
                        </button>
                    </div>
                {{Form::close()}}

                <div class="divider">
                    <div class="divider-text">{{trans('common.thisYearVacations')}}</div>
                </div>

                @if($user->vacations()->where('year',$year)->count() > 0)
                    <table class="table table-bordered mt-2">
                        <thead class="table-dark">
                            <tr>
                                <td>
                                    {{trans('common.from')}}
                                </td>
                                <td>
                                    {{trans('common.to')}}
                                </td>
                                <td>
                                    {{trans('common.total')}}
                                </td>
                                <td>
                                    {{trans('common.Reason')}}
                                </td>
                                <td>
                                    {{trans('common.actions')}}
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($user->vacations as $vacation)
                                <tr id="row_{{$vacation->id}}">
                                    <td>
                                        {{$vacation->from}}
                                    </td>
                                    <td>
                                        {{$vacation->to}}
                                    </td>
                                    <td>
                                        {{count(unserialize(base64_decode($vacation->daysList)))}}
                                    </td>
                                    <td>
                                        {{$vacation->reason}}
                                    </td>
                                    <td>
                                        @if(userCan('attendance_vacation_delete'))
                                            <?php $delete = route('admin.DeleteVacation',['id'=>$vacation->id]); ?>
                                            <button type="button" class="btn btn-icon btn-danger" onclick="confirmDelete('{{$delete}}','{{$vacation->id}}')" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.delete')}}">
                                                <i data-feather='trash-2'></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <span class="alert alert-success d-block text-center py-2">{{trans('common.nothingToView')}}</span>
                @endif
            </div>
        </div>
    </div>
</div>
