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
                                <th class="text-center"> # </th>
                                <th class="text-center">{{trans('common.date')}}  </th>
                                <th class="text-center">{{trans('common.clientname')}}</th>
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
                                    {{$reservation['date']  }}   <br> {{$reservation['time'] }}
                                </td>
                                <td>
                                    @if(isset($reservation->client->id))
                                        {{$reservation->client->Name}}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="text-center text-nowrap">
                                    @if(isset($reservation->doctor->id))
                                      {{trans('common.doctor')}}  : <br>  {{$reservation->doctor->name}} <br> <br>
                                    @else
                                        - <br>
                                    @endif

                                    @if(isset($reservation->user->id))
                                      {{trans('common.employee')}}  : <br> {{$reservation->user->name}}
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
                                   {{ trans('common.total')}} :  {{  $reservation->totals()['totalPulses'] }} <br>
                                   {{ trans('common.used')}} :  {{  $reservation->totals()['usedPulses'] }}
                                </td>
                                <td class="text-center text-nowrap">

                                    @if($reservation->status == 1)
                                    <a href="{{route('admin.reservations.updateStatus',$reservation->id)}}" class="btn btn-icon btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.cancelStatus')}}">
                                        <i data-feather='thumbs-up'></i>
                                    </a>
                                    @else
                                    <a href="{{route('admin.reservations.updateStatus',$reservation->id)}}" class="btn btn-icon btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.confirmStatus')}}">
                                        <i data-feather='thumbs-down'></i>
                                    </a>
                                    @endif
                                    <a href="javascript:;" data-bs-target="#editreservation{{$reservation->id}}" data-bs-toggle="modal" class="btn btn-icon btn-info">
                                        <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.edit')}}">
                                            <i data-feather='edit'></i>
                                        </span>
                                    </a>
                                    <div class="col-12 mb-1"></div>

                                    <a href="javascript:;" data-bs-target="#createPayment{{$reservation->id}}" data-bs-toggle="modal" class="btn btn-icon btn-success">
                                        <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.createPayment')}}">
                                            <i data-feather='dollar-sign'></i>
                                        </span>
                                    </a>

                                    <?php $delete = route('admin.reservations.delete',['id'=>$reservation->id]); ?>
                                    <button type="button" class="btn btn-icon btn-danger" onclick="confirmDelete('{{$delete}}','{{$reservation->id}}')" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.delete')}}">
                                        <i data-feather='trash-2'></i>
                                    </button>

                                    <div class="col-12 mb-1"></div>
                                    <a href="{{route('admin.appointments',$reservation->id)}}" class="btn btn-icon btn-dark" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.showAppointments')}}">
                                        <i data-feather='eye'></i>
                                    </a>

                                    <button type="button" class="btn btn-icon dropdown-toggle hide-arrow btn-secondary" data-bs-toggle="dropdown">
                                            <i data-feather="more-vertical"></i>
                                    </button>

                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a href="javascript:;" data-bs-target="#movePulses{{$reservation->id}}" data-bs-toggle="modal" class="dropdown-item">
                                            <span>{{trans('common.movePulses')}}</span>
                                        </a>
                                        <a href="javascript:;" data-bs-target="#movePayment{{$reservation->id}}" data-bs-toggle="modal" class="dropdown-item">
                                            <span>{{trans('common.movePayment')}}</span>
                                        </a>
                                    </div>


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

                {{ $reservations->links('vendor.pagination.default') }}


            </div>
        </div>
    </div>
    <!-- Bordered table end -->

    @foreach($reservations as $reservation)

        <div class="modal fade text-md-start" id="editreservation{{$reservation->id}}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">

                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pb-5 px-sm-5 pt-50">
                        <div class="text-center mb-2">
                            <h1 class="mb-1">{{trans('common.edit')}}: {{trans('common.reservation')}} </h1>
                        </div>
                        {{Form::open(['url'=>route('admin.reservations.update',$reservation->id), 'id'=>'editreservationForm'.$reservation->id, 'class'=>'row gy-1 pt-75 justify-content-center'])}}

                        <div class="col-12 col-md-4">
                            <label class="form-label" for="user_id">{{trans('common.clients')}}</label>
                            {{Form::select('client_id',clientList(),$reservation->client_id,['id'=>'client_id','class'=>'form-select selectpicker','data-live-search'=>'true'])}}
                        </div>

                        <div class="col-12 col-md-4">
                            <label class="form-label" for="doctor_id">{{trans('common.doctors')}}</label>
                            {{Form::select('doctor_id',doctorsList(),$reservation->doctor_id,['id'=>'doctor_id','class'=>'form-select selectpicker','data-live-search'=>'true'])}}
                        </div>

                    <div class="col-12 col-md-4">
                            <label class="form-label" for="day">{{trans('common.date')}}</label>
                            {{Form::date('date',$reservation->date,['id'=>'day', 'class'=>'form-control','required'])}}
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label" for="hours">{{trans('common.hours')}}</label>
                            {{Form::select('time',hoursList(),$reservation->time,['id'=>'hours', 'class'=>'form-control'])}}
                        </div>


                        <div class="col-12 col-md-4" style="margin-top:36px">
                            <div class="single-input-field">
                                {{Form::select('serviceoffer',[
                                                        'serviceoffer' => trans('common.serviceoffer'),
                                                        'services' => trans('common.service'),
                                                        'offers' => trans('common.offer')
                                                        ],$reservation->offer_id != null ? 'offers' : 'services',['class'=>'form-control','id'=>'serviceoffer','onchange'=>'serviceOffer()','required'])}}
                                @if ($errors->has('serviceoffer'))
                                    <label id="serviceoffer-error" class="alert-danger" for="serviceoffer">{{ $errors->first('serviceoffer') }}</label>
                                @endif
                            </div>
                        </div>


                        <div class="col-12 col-md-4 servicesShow">
                            @foreach(servicesList() as $service)
                                <div class="form-check me-3 me-lg-1">
                                    <label class="form-check-label" for="service{{$service->id}}{{$reservation->id}}">
                                        {{$service->name}}
                                    </label>
                                    <input class="form-check-input" type="checkbox" id="service{{$service->id}}{{$reservation->id}}" name="services[]" value="{{$service->id}}" @if($reservation->checkForService($service->id) != '') checked @endif />
                                </div>
                            @endforeach
                        </div>


                        <div class="col-12 col-md-4 offersShow">
                            @foreach(offersList() as $offer)
                                <div class="form-check me-3 me-lg-1">
                                    <label class="form-check-label" for="offer{{$offer->id}}{{$reservation->id}}">
                                        {{$offer->name}}
                                    </label>
                                    {{ Form::radio('offer_id', $offer->id,$offer->id == $reservation->offer_id ? true : false,['id'=>'offer'.$offer->id.$reservation->id,'class'=>'form-check-input']) }}
                                </div>
                            @endforeach
                            <div class="form-check me-3 me-lg-1">
                                <label class="form-check-label" for="offer0">
                                    بدون عرض
                                </label>
                                {{ Form::radio('offer_id', 0 ,false,['id'=>'offer0'.$reservation->id,'class'=>'form-check-input']) }}
                            </div>
                        </div>

                        <div class="col-12 col-md-12">
                            <label class="form-label" for="reason">{{trans('common.note')}}</label>
                            {{Form::textarea('note','',['id'=>'note', 'class'=>'form-control','rows'=>'3'])}}
                        </div>

                        {!! Form::hidden('user_id',Auth::user()->id) !!}


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

        @include('AdminPanel.appointments.create',['reservation'=>$reservation])
        @include('AdminPanel.payments.create',['reservation'=>$reservation])
        @include('AdminPanel.reservations.movePulses',['reservation'=>$reservation])
        @include('AdminPanel.reservations.movePayment',['reservation'=>$reservation])



    @endforeach

@stop

@section('page_buttons')


    <!-- create reservation  -->
    <a href="javascript:;" data-bs-target="#addReservation" data-bs-toggle="modal" class="btn btn-primary">
        {{trans('common.addReservation')}}
    </a>

    @include('AdminPanel.clients.createReservation')  


    <!-- search in reservation -->
    <a href="javascript:;" data-bs-target="#searchReservations" data-bs-toggle="modal" class="btn btn-primary">
        {{trans('common.search')}}
    </a>

    <div class="modal fade text-md-start" id="searchReservations" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-5 px-sm-5 pt-50">
                    <div class="text-center mb-2">
                        <h1 class="mb-1">{{trans('common.search')}}</h1>
                    </div>
                    {{Form::open(['url'=>route('admin.filterReservations'), 'id'=>'searchReservationsForm', 'class'=>'row gy-1 pt-75','method'=>'GET'])}}

                        <div class="col-12 col-md-3">
                            <label class="form-label" for="client_id">{{trans('common.clients')}}</label>
                            {{Form::select('client_id',['all' => 'الجميع'] + clientList(),isset($_GET['client_id']) ? $_GET['client_id'] : '',['id'=>'client_id', 'class'=>'selectpicker','data-live-search'=>'true'])}}
                        </div>

                        <div class="col-12 col-md-3">
                            <label class="form-label" for="doctor_id">{{trans('common.doctors')}}</label>
                            {{Form::select('doctor_id',['all' => 'الجميع'] + doctorsList(),isset($_GET['doctor_id']) ? $_GET['doctor_id'] : '',['id'=>'doctor_id', 'class'=>'selectpicker','data-live-search'=>'true'])}}
                        </div>

                        <div class="col-12 col-md-3">
                            <label class="form-label" for="service_id">{{trans('common.services')}}</label>
                            <?php $servicesList = App\Models\Service::orderBy('name','asc')->pluck('name','id')->all(); ?>
                            {{Form::select('service_id',['all'=>'الجميع'] + $servicesList,isset($_GET['service_id']) ? $_GET['service_id'] : '',['id'=>'service_id', 'class'=>'form-select'])}}
                        </div>

                        <div class="col-12 col-md-3">
                            <label class="form-label" for="offer_id">{{trans('common.offers')}}</label>
                            <?php $offersList = App\Models\Offer::orderBy('name','asc')->pluck('name','id')->all(); ?>
                            {{Form::select('offer_id',['all'=>'الجميع'] + $offersList,isset($_GET['offer_id']) ? $_GET['offer_id'] : '',['id'=>'offer_id', 'class'=>'form-select'])}}
                        </div>

                        <div class="col-12 col-md-3">
                            <label class="form-label" for="status">{{trans('common.status')}}</label>
                            {{Form::select('status',
                                                    [''=>trans('common.status')]
                                                    + reservationStatus(session()->get('Lang')),
                                                    isset($_GET['status']) ? $_GET['status'] : '',['id'=>'status', 'class'=>'form-control selectpicker','data-live-search'=>'true'])}}
                        </div>

                        <div class="col-12 col-md-3">
                            <label class="form-label" for="from_date">{{trans('common.from_date')}}</label>
                            {{Form::date('from_date',isset($_GET['from_date']) ? $_GET['from_date'] : '',['id'=>'from_date', 'class'=>'form-control'])}}
                        </div>
                        <div class="col-12 col-md-3">
                            <label class="form-label" for="to_date">{{trans('common.to_date')}}</label>
                            {{Form::date('to_date',isset($_GET['to_date']) ? $_GET['to_date'] : '',['id'=>'to_date', 'class'=>'form-control'])}}
                        </div>
                        <div class="col-12 text-center mt-2 pt-50">
                            <button type="submit" class="btn btn-primary me-1">{{trans('common.search')}}</button>
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
