<div class="modal fade text-md-start" id="attendancePermission{{$user->id}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-5 px-sm-5 pt-50">
                <div class="text-center mb-2">
                    <h1 class="mb-1">{{trans('common.attendancePermission')}}</h1>
                    <p>{{$user->name}}</p>
                </div>
                {{Form::open(['url'=>route('admin.AddPermission',$user->id), 'id'=>'AddPermissionForm', 'class'=>'row gy-1 pt-75'])}}
                    <div class="col-12 col-md-3">
                        <label class="form-label" for="day">{{trans('common.date')}}</label>
                        {{Form::date('day','',['id'=>'day', 'class'=>'form-control','required'])}}
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="form-label" for="hours">{{trans('common.hours')}}</label>
                        {{Form::number('hours','',['id'=>'hours', 'class'=>'form-control','required'])}}
                    </div> 
                    <div class="col-12 col-md-3">
                        <label class="form-label" for="type">{{trans('common.type')}}</label>
                        {{Form::select('type',attendancePermissions(session()->get('Lang')),'',['id'=>'Type', 'class'=>'form-control'])}}
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
                    <div class="divider-text">{{trans('common.thisMonthPermissions')}}</div>
                </div>

                @if($user->attendancePermissions()->where('month',$month)->where('year',$year)->count() > 0)
                    <table class="table table-bordered mt-2">
                        <thead class="table-dark">
                            <tr>
                                <td>
                                    {{trans('common.date')}}
                                </td>
                                <td>
                                    {{trans('common.hours')}}
                                </td>
                                <td>
                                    {{trans('common.type')}}
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
                            @foreach($user->attendancePermissions as $permission)
                                <tr id="row_{{$permission->id}}">
                                    <td>
                                        {{$permission->day}}
                                    </td>
                                    <td>
                                        {{$permission->hours}}
                                    </td>
                                    <td>
                                        {{$permission->typeText()}}
                                    </td>
                                    <td>
                                        {{$permission->reason}}
                                    </td>
                                    <td>
                                        @if(userCan('attendance_permission_delete'))
                                            <?php $delete = route('admin.DeletePermission',$permission->id); ?>
                                            <button type="button" class="btn btn-icon btn-danger" onclick="confirmDelete('{{$delete}}','{{$permission->id}}')" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.delete')}}">
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
