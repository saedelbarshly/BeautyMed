@extends('AdminPanel.layouts.master')
@section('content')

    <section class="app-user-view-account">
        <div class="row">
            <!-- User Sidebar -->
            <div class="col-md-3 order-0 order-md-0">
                <!-- User Card -->
                <div class="card">
                    <div class="card-body" style="height: 70vh;">
                        <div class="user-avatar-section">
                            <div class="d-flex align-items-center flex-column">
                                <div class="user-info text-center">
                                    <h4> {{ $client->Name }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-around my-2 pt-75">
                            <div class="align-items-start me-2">
                                <span class="badge bg-light-primary p-75 rounded">
                                    <i data-feather="check" class="font-medium-2"></i>
                                </span>
                                <div class="ms-75">
                                    <h4 class="mb-0"> {{ $client->reservations->count() }}</h4>
                                    <small> مرات حجز </small>
                                </div>
                            </div>
                            <div class="align-items-start">
                                <span class="badge bg-light-primary p-75 rounded">
                                    <i data-feather="briefcase" class="font-medium-2"></i>
                                </span>
                                <div class="ms-75">
                                    <h4 class="mb-0">{{ $client->payments->sum('amount')}}</h4>
                                    <small>مدفوع</small>
                                </div>
                            </div>
                        </div> <br>
                        <h4 class="fw-bolder border-bottom pb-50 mb-1">البيانات</h4>
                        <div class="info-container">

                            <ul class="list-unstyled">
                                <li class="mb-75">
                                    <span class="fw-bolder me-25"> كود:</span>
                                    <span>{{ $client->code }}</span>
                                </li>

                                <li class="mb-75">
                                    <span class="fw-bolder me-25">هاتف:</span>
                                    <span>{{ $client->phone }}</span>
                                </li>

                            </ul>
                            <div class="d-flex justify-content-center pt-2">
                                <a href="javascript:;" class="btn btn-primary me-1" data-bs-target="#editUser" data-bs-toggle="modal">
                                    تعديل
                                </a>

                                <a href="javascript:;" data-bs-target="#cashBack" data-bs-toggle="modal" class="btn btn-icon btn-dark">
                                    <span data-bs-toggle="tooltip" d  ata-bs-placement="top" data-bs-original-title="استرجاع">
                                        استرجاع الأموال
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /User Card -->

            </div>
            <!--/ User Sidebar -->

            <!-- User Content -->
            <div class="col-md-9 order-1 order-md-1">


                <!-- Activity Timeline -->
                <div class="card">
                    <h4 class="card-header">{{trans('common.reservations')}}</h4>
                    <div class="card-body pt-1">

                    <div class="table-responsive">
                        <table class="table table-bordered mb-2">
                            <thead>
                                <tr>
                                    <th class="text-center"> # </th>
                                    <th class="text-center">{{trans('common.date')}}  </th>
                                    <th class="text-center">{{trans('common.Officials')}}</th>
                                    <th class="text-center">{{trans('common.serviceoffer')}}</th>
                                    <th class="text-center">{{trans('common.pulses')}}</th>
                                    <th class="text-center">{{trans('common.actions')}}</th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse($reservations as $reservation)
                                    <tr id="row_{{$reservation->id}}">
                                        <td>
                                            {{$reservation['id']  }}
                                        </td>
                                        <td class="text-center text-nowrap">
                                            {{trans('common.day')}} :{{$reservation['date']  }} <br>
                                            {{trans('common.hour')}}: {{$reservation['time'] }}
                                        </td>
                                        <td class="text-center text-nowrap">
                                            @if(isset($reservation->doctor->id))
                                            {{trans('common.doctorname')}}  :   {{$reservation->doctor->name}} <br>
                                            @else
                                                - <br>
                                            @endif

                                            @if(isset($reservation->user->id))
                                            {{trans('common.employeename')}}  :  {{$reservation->user->name}}
                                            @else
                                                - <br>
                                            @endif
                                        </td>
                                        <td class="text-center text-nowrap">

                                        @if($reservation->services != '' && count($reservation->services) > 0)

                                                {{ trans('common.services')}} :  <br>
                                                @foreach($reservation->services as $service)
                                                - {{ $service->name }}   <br>
                                                @endforeach

                                        @elseif(isset($reservation->offer->id) && $reservation->offer->id != 0)

                                                {{ trans('common.offer')}} :  <br>
                                                {{$reservation->offer->name}}
                                        @else
                                        -
                                        @endif

                                        </td>
                                        <td class="text-center text-nowrap">
                                            {{ trans('common.totalPulses')}} :  {{  $reservation->totals()['net_pulses'] }} <br>
                                            {{ trans('common.usedPulses')}} :  {{  $reservation->totals()['usedPulses'] }}
                                        </td>
                                        <td class="text-center text-nowrap">

                                            <div class="col-12 mb-1"></div>
                                            <a href="{{route('admin.appointments',$reservation->id)}}" class="btn btn-icon btn-dark" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.showAppointments')}}">
                                                <i data-feather='eye'></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="p-3 text-center ">
                                            <h2>{{trans('common.nothingToView')}}</h2>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                        {{ $reservations->links('vendor.pagination.default') }}

                    </div>
                </div>
                <!-- /Activity Timeline -->

                <!-- Activity Timeline -->
                <div class="card">
                    <h4 class="card-header">{{trans('common.payment')}}</h4>
                    <div class="card-body pt-1">


                        <div class="table-responsive">
                            <table class="table table-bordered mb-2">
                                <thead>
                                    <tr>
                                        <th class="text-center">{{trans('common.date')}}  </th>
                                        <th class="text-center">{{trans('common.amount')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($payments as $payment)
                                    <tr id="row_{{$payment->id}}">
                                        <td class="text-center text-nowrap">
                                            {{trans('common.day')}} :{{$payment['Date']  }}
                                        </td>
                                        <td class="text-center text-nowrap">
                                            {{  $payment->amount }}
                                        </td>

                                    </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="p-3 text-center ">
                                                <h2>{{trans('common.nothingToView')}}</h2>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
                <!-- /Activity Timeline -->


                <!-- Activity Timeline -->
                <div class="card">
                    <h4 class="card-header">الاسترجاع</h4>
                    <div class="card-body pt-1">


                        <div class="table-responsive">
                            <table class="table table-bordered mb-2">
                                <thead>
                                    <tr>
                                        <th class="text-center">{{trans('common.date')}}  </th>
                                        <th class="text-center">{{trans('common.amount')}}</th>
                                        <th class="text-center">{{trans('common.puls')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($cashPack as $payment)
                                    <tr id="row_{{$payment->id}}">
                                        <td class="text-center text-nowrap">
                                            {{trans('common.day')}} :{{$payment['ExpenseDate']  }}
                                        </td>
                                        <td class="text-center text-nowrap">
                                            {{  $payment->Expense }}
                                        </td>
                                        <td class="text-center text-nowrap">
                                            {{  $payment->puls }}
                                        </td>

                                    </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="p-3 text-center ">
                                                <h2>{{trans('common.nothingToView')}}</h2>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
                <!-- /Activity Timeline -->

                    <!-- Activity Timeline -->
                <div class="card">
                    <h4 class="card-header">{{trans('common.complaints')}}</h4>
                    <div class="card-body pt-1">
                        <div class="table-responsive">
                            <table class="table table-bordered mb-2">
                                <thead>
                                    <tr>
                                        <th class="text-center"> # </th>
                                        <th class="text-center">{{trans('common.date')}}  </th>
                                        <th class="text-center">{{trans('common.phone')}}</th>
                                        <th class="text-center">{{trans('common.status')}}</th>
                                        <th class="text-center">{{trans('common.details')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($complaints as $complaint)
                                    <tr id="row_{{$complaint->id}}">
                                        <td>
                                            {{$complaint['id']  }}
                                        </td>
                                        <td class="text-center text-nowrap">
                                            {{$complaint['date']  }}
                                        </td>
                                        <td class="text-center text-nowrap">
                                        {{$complaint->client->phone  }}
                                        </td>
                                        <td class="text-center text-nowrap">
                                        {{$complaint->status }}
                                        </td>
                                        <td class="text-center text-nowrap">
                                            {{$complaint['details']  }}
                                        </td>
                                    </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="p-3 text-center ">
                                                <h2>{{trans('common.nothingToView')}}</h2>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{ $complaints->links('vendor.pagination.default') }}
                    </div>
                </div>
                <!-- /Activity Timeline -->


            </div>
            <!--/ User Content -->
        </div>

    </section>

<!-- Edit User Modal -->
    <div class="modal fade" id="editUser" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-5 px-sm-5 pt-50">
                    <div class="text-center mb-2">
                        <h1 class="mb-1">{{trans('common.edit')}}: {{$client['Name']}}</h1>
                    </div>
                    {{Form::open(['url'=>route('admin.clients.update',$client->id), 'id'=>'editclientForm'.$client->id, 'class'=>'row gy-1 pt-75'])}}
                        <div class="col-12 col-md-3">
                            <label class="form-label" for="Name">{{trans('common.name')}}</label>
                            {{Form::text('Name',$client->Name,['id'=>'Name', 'class'=>'form-control','required'])}}
                            @if($errors->has('Name'))
                                <span class="text-danger" role="alert">
                                    <b>{{ $errors->first('Name') }}</b>
                                </span>
                            @endif
                        </div>
                        <div class="col-12 col-md-3">
                            <label class="form-label" for="phone">{{trans('common.phone')}}</label>
                            {{Form::text('phone',$client->phone,['id'=>'phone', 'class'=>'form-control'])}}

                        </div>

                        <div class="col-12 col-md-3">
                            <label class="form-label" for="code">{{trans('common.code')}}</label>
                            {{Form::text('code',$client->code,['id'=>'code', 'class'=>'form-control'])}}
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
<!--/ Edit User Modal -->



<!-- Edit User Modal -->
<div class="modal fade" id="cashBack" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-5 px-sm-5 pt-50">
                <div class="text-center mb-2">
                    <h1 class="mb-1">استرجاع أموال للعميل: {{$client['Name']}}</h1>
                </div>
                {{Form::open(['url'=>route('admin.clients.cashBack',$client->id), 'id'=>'cashBackForm'.$client->id, 'class'=>'row gy-1 pt-75'])}}
                    <div class="col-12 col-md-4">
                        <label class="form-label" for="money">الأموال المسترجعه</label>
                        {{Form::number('money','',['id'=>'money', 'step'=>'.01', 'class'=>'form-control','required'])}}
                        @if($errors->has('money'))
                            <span class="text-danger" role="alert">
                                <b>{{ $errors->first('money') }}</b>
                            </span>
                        @endif
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label" for="puls">النبضات الملغية</label>
                        {{Form::number('puls','',['id'=>'puls', 'step'=>'.01', 'class'=>'form-control'])}}

                    </div>

                    <div class="col-12 col-md-4">
                        <label class="form-label" for="safe_id">{{trans('common.safe')}}</label>
                        {{Form::select('safe_id',safesList(),'',['id'=>'safe_id', 'class'=>'form-select','required'])}}
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
<!--/ Edit User Modal -->
@stop
