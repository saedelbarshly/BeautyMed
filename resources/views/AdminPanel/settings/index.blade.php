@extends('AdminPanel.layouts.master')
@section('content')


    <!-- Bordered table start -->
    <div class="row" id="table-bordered">
        <div class="col-12">
            {{Form::open(['url'=>route('admin.settings.update'), 'files'=>'true'])}}
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="hr-tab" data-bs-toggle="tab" href="#hr" aria-controls="home" role="tab" aria-selected="true">
                                <i data-feather="home"></i> {{trans('common.hrSettings')}}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="accounts-tab" data-bs-toggle="tab" href="#accounts" aria-controls="accounts" role="tab" aria-selected="false">
                                <i data-feather="tool"></i> {{trans('common.accountsSettings')}}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="demo-tab" data-bs-toggle="tab" href="#demo" aria-controls="demo" role="tab" aria-selected="false">
                                <i data-feather="tool"></i> {{trans('common.demo')}}
                            </a>
                        </li>
                      
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="hr" aria-labelledby="hr-tab" role="tabpanel">
                            @include('AdminPanel.settings.includes.hr')
                        </div>
                        <div class="tab-pane" id="accounts" aria-labelledby="accounts-tab" role="tabpanel">
                            @include('AdminPanel.settings.includes.accounts')
                        </div>
                        <div class="tab-pane" id="demo" aria-labelledby="demo-tab" role="tabpanel">
                            @include('AdminPanel.settings.includes.demo')
                        </div>
                   
                    </div>
                </div>
                <div class="card-footer">
                    <input type="submit" value="{{trans('common.Save changes')}}" class="btn btn-primary">
                </div>
            </div>
            {{Form::close()}}
        </div>
    </div>
    <!-- Bordered table end -->
@stop