@extends('AdminPanel.layouts.master')
@section('content')


    <!-- Bordered table start -->
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{$title}}</h4>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered mb-2">
                        <thead>
                            <tr>
                                <th>{{trans('common.name')}}</th>
                                <th class="text-center">{{trans('common.users')}}</th>
                                <th class="text-center">{{trans('common.actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $totalUsers = $totalExpenses = $totalRevenues = $totalNet = 0; ?>
                            @forelse($jobs as $job)
                                <tr id="row_{{$job->id}}">
                                    <td>
                                        {{$job['name']}}
                                    </td>
                                    <td class="text-center">
                                        <a href="{{route('admin.adminUsers',['title'=>$job->id])}}" class="btn btn-sm btn-success">
                                        <?php $totalUsers = App\Models\User::where('title',$job->id)->where('status','Active')->count(); ?>
                                              {{ $totalUsers }}
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <a href="javascript:;" data-bs-target="#editbranch{{$job->id}}" data-bs-toggle="modal" class="btn btn-icon btn-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.edit')}}">
                                            <i data-feather='edit'></i>
                                        </a>
                                        <?php $delete = route('admin.jobs.delete',['id'=>$job->id]); ?>
                                        <button type="button" class="btn btn-icon btn-danger" onclick="confirmDelete('{{$delete}}','{{$job->id}}')">
                                            <i data-feather='trash-2'></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="p-3 text-center ">
                                        <h2>{{trans('common.nothingToView')}}</h2>
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>

                {{ $jobs->links('vendor.pagination.default') }}


            </div>
        </div>
    </div>
    <!-- Bordered table end -->

@foreach($jobs as $job)

    <div class="modal fade text-md-start" id="editbranch{{$job->id}}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered modal-edit-user">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-5 px-sm-5 pt-50">
                    <div class="text-center mb-2">
                        <h1 class="mb-1">{{trans('common.edit')}}: {{$job['name_'.session()->get('Lang')]}}</h1>
                    </div>
                    {{Form::open(['url'=>route('admin.jobs.update',$job->id), 'id'=>'editbranchForm'.$job->id, 'class'=>'row gy-1 pt-75'])}}
                        <div class="col-12 col-md-7">
                            <label class="form-label" for="name">{{trans('common.name')}}</label>
                            {{Form::text('name',$job->name,['id'=>'name', 'class'=>'form-control'])}}
                        </div>

                        <div class="col-12 col-md-5">
                            <label class="form-label" for="management_id">{{trans('common.management')}}</label>
                            {{Form::select('management_id',managementsList(),$job->management_id,['id'=>'management_id', 'class'=>'form-select'])}}
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

@endforeach

@stop

@section('page_buttons')
    <a href="javascript:;" data-bs-target="#createbranch" data-bs-toggle="modal" class="btn btn-primary">
        {{trans('common.CreateNew')}}
    </a>

    <div class="modal fade text-md-start" id="createbranch" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered modal-edit-user">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-5 px-sm-5 pt-50">
                    <div class="text-center mb-2">
                        <h1 class="mb-1">{{trans('common.CreateNew')}}</h1>
                    </div>
                    {{Form::open(['url'=>route('admin.jobs.store'), 'id'=>'createbranchForm', 'class'=>'row gy-1 pt-75'])}}
                        <div class="col-12 col-md-7">
                            <label class="form-label" for="name">{{trans('common.name')}}</label>
                            {{Form::text('name','',['id'=>'name', 'class'=>'form-control'])}}
                        </div>

                        <div class="col-12 col-md-5">
                            <label class="form-label" for="management_id">{{trans('common.management')}}</label>
                            {{Form::select('management_id',managementsList(),'',['id'=>'management_id', 'class'=>'form-select'])}}
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
@stop

@section('scripts')
<script src="{{asset('AdminAssets/app-assets/js/scripts/pages/modal-add-branch.js')}}"></script>
@stop
