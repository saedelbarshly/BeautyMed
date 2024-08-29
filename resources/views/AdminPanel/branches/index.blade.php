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
                                <th class="text-center">{{trans('common.income')}}</th>
                                <th class="text-center">{{trans('common.outcome')}}</th>
                                <th class="text-center">{{trans('common.balance')}}</th>
                                <th class="text-center">{{trans('common.actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $totalUsers = $totalExpenses = $totalRevenues = $totalNet = 0; ?>
                            @forelse($branches as $branch)
                                <tr id="row_{{$branch->id}}">
                                    <td>
                                        {{$branch['name']}}
                                    </td>
                                    <td class="text-center">
                                        <a href="{{route('admin.adminUsers',['branch'=>$branch->id])}}" class="btn btn-sm btn-success">
                                            {{$branch->users()->where('status','Active')->count()}}
                                        </a>
                                        <?php $totalUsers += $branch->users()->where('status','Active')->count(); ?>
                                    </td>
                                    <td class="text-center">
                                        {{$branch->totals()['income']}}
                                        <?php $totalRevenues += $branch->totals()['income']; ?>
                                    </td>
                                    <td class="text-center">
                                        {{$branch->totals()['outcome']}}
                                        <?php $totalExpenses += $branch->totals()['outcome']; ?>
                                    </td>
                                    <td class="text-center">
                                        {{$branch->totals()['balance']}}
                                        <?php $totalNet += $branch->totals()['balance']; ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="javascript:;" data-bs-target="#editbranch{{$branch->id}}" data-bs-toggle="modal" class="btn btn-icon btn-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.edit')}}">
                                            <i data-feather='edit'></i>
                                        </a>
                                        <?php $delete = route('admin.branches.delete',['id'=>$branch->id]); ?>
                                        <button type="button" class="btn btn-icon btn-danger" onclick="confirmDelete('{{$delete}}','{{$branch->id}}')">
                                            <i data-feather='trash-2'></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-3 text-center ">
                                        <h2>{{trans('common.nothingToView')}}</h2>
                                    </td>
                                </tr>
                            @endforelse
                            @if(count($branches) > 0)
                                <tr>
                                    <td>
                                        {{trans('common.totals')}}
                                    </td>
                                    <td class="text-center">
                                        {{$totalUsers}}
                                    </td>
                                    <td class="text-center">
                                        {{$totalRevenues}}
                                    </td>
                                    <td class="text-center">
                                        {{$totalExpenses}}
                                    </td>
                                    <td class="text-center">
                                        {{$totalNet}}
                                    </td>
                                    <td class="text-center">
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                {{ $branches->links('vendor.pagination.default') }}


            </div>
        </div>
    </div>
    <!-- Bordered table end -->

@foreach($branches as $branch)

    <div class="modal fade text-md-start" id="editbranch{{$branch->id}}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered modal-edit-user">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-5 px-sm-5 pt-50">
                    <div class="text-center mb-2">
                        <h1 class="mb-1">{{trans('common.edit')}}: {{$branch['name_'.session()->get('Lang')]}}</h1>
                    </div>
                    {{Form::open(['url'=>route('admin.branches.update',$branch->id), 'id'=>'editbranchForm'.$branch->id, 'class'=>'row gy-1 pt-75'])}}
                        <div class="col-12 col-md-12">
                            <label class="form-label" for="name">{{trans('common.name')}}</label>
                            {{Form::text('name',$branch->name,['id'=>'name', 'class'=>'form-control'])}}
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
                    {{Form::open(['url'=>route('admin.branches.store'), 'id'=>'createbranchForm', 'class'=>'row gy-1 pt-75'])}}
                        <div class="col-12 col-md-12">
                            <label class="form-label" for="name">{{trans('common.name')}}</label>
                            {{Form::text('name','',['id'=>'name', 'class'=>'form-control'])}}
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