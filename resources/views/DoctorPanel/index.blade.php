@extends('DoctorPanel.layouts.master')

@section('content')

<?php
    $month = date('m');
    $day = date("d");
    $hour = date('H:i')
?>


    <!-- Dashboard Analytics Start -->
        <section id="dashboard-analytics">
            <div class="row">

                <!-- Avg Sessions Chart Card starts -->
                <div class="col-lg-12 col-12">
                    <div class="card">
                        <div class="card-header">
                                <h4 class="card-title">{{trans('common.workFrom')}} &nbsp  {{ auth()->user()->WorkFrom }} &nbsp   </span> {{trans('common.to')}} &nbsp {{ auth()->user()->WorkTo }} </h4>
                                <div class="d-flex align-items-center">
                                    <p class="card-text me-25 mb-0">{{ $hour }} &nbsp &nbsp  {{ $month }} - {{ $day }}  </p>
                                </div>
                            </div>
                        <div class="card-body">

                            <!-- Bordered table start -->
                            <div class="row" id="table-bordered">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">{{trans('common.client')}} </h4>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered mb-2">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">#  </th>
                                                        <th class="text-center">{{trans('common.date')}}  </th>
                                                        <th class="text-center">{{trans('common.clientname')}}</th>
                                                        <th class="text-center">{{trans('common.serviceoffer')}}</th>
                                                        <th class="text-center">{{trans('common.pulses')}}</th>
                                                        <th class="text-center">{{trans('common.actions')}}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($appointments as $appointment)
                                                        <tr id="row_{{$appointment->id}}">
                                                            <td class="text-center text-nowrap">
                                                                {{$appointment['id']  }}
                                                            </td>
                                                            <td class="text-center text-nowrap">
                                                                {{trans('common.day')}} :{{$appointment['date']  }} <br>
                                                                {{trans('common.hour')}}: {{$appointment['hour'] }}
                                                            </td>
                                                            <td class="text-center text-nowrap">
                                                                @if(isset($appointment->client->id))
                                                                    {{$appointment->client->Name}} <br>
                                                                    {{$appointment->client->phone}} <br>
                                                                    {{trans('common.code')}}: {{$appointment->client->code}}
                                                                @else
                                                                    -
                                                                @endif
                                                            </td>

                                                            <td class="text-center text-nowrap">
                                                                @foreach($appointment->services as $service)
                                                                    {{ $service->name }}  <br>
                                                                @endforeach
                                                            </td>
                                                            <td class="text-center text-nowrap">
                                                                    {{$appointment['pulses']  }}
                                                            </td>
                                                            <td class="text-center text-nowrap">
                                                                <a href="{{route('doctor.clients.details',$appointment->client_id)}}" class="btn btn-icon btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="بيانات العميل">
                                                                    <i data-feather='user'></i>
                                                                </a>

                                                            @if($appointment->status == 'withDoctor')
                                                                <a href="{{route('doctor.appointments.updateStatus',$appointment->id)}}" class="btn btn-icon btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.completedSession')}}">
                                                                    <i data-feather='bell'></i>
                                                                </a>
                                                            @endif
                                                                <a href="javascript:;" data-bs-target="#editappointment{{$appointment->id}}" data-bs-toggle="modal" class="btn btn-icon btn-info">
                                                                    <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.edit')}}">
                                                                        <i data-feather='edit'></i>
                                                                    </span>
                                                                </a>

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

                                        {{ $appointments->links('vendor.pagination.default') }}


                                    </div>
                                </div>
                            </div>
                            <!-- Bordered table end -->

                        </div>
                    </div>
                </div>
                <!-- Avg Sessions Chart Card ends -->




            </div>
        </section>
    <!-- Dashboard Analytics end -->



    <!-- Avg Sessions Chart Card starts -->
        <div class="col-lg-12 col-12">
            <div class="card">
                <div class="card-body">

                    <!-- Bordered table start -->
                    <div class="row" id="table-bordered">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                            <h4 class="card-title"> {{trans('common.todayAppointments')}} </h4>
                                            <?php $totalPulsesInToday = App\Models\Appointment::where('date',date('Y-m-d'))->where(['status'=>'completedSession','doctor_id'=>auth()->user()->id])->sum('pulses'); ?>
                                            <p class="card-title"> {{trans('common.totalPulsesInToday')}} : {{ $totalPulsesInToday }} </p>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-2">
                                            <thead>
                                                <tr>
                                                <th class="text-center">{{trans('common.date')}}  </th>
                                                    <th class="text-center">{{trans('common.clientname')}}</th>
                                                    <th class="text-center">{{trans('common.services')}}  </th>
                                                    <th class="text-center">{{trans('common.pulses')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $done_appointments = App\Models\Appointment::where('date',date('Y-m-d'))->where(['status'=>'completedSession','doctor_id'=>auth()->user()->id])->get(); ?>
                                                @forelse($done_appointments as $appointment)
                                                <tr id="row_{{$appointment->id}}">
                                                    <td class="text-center text-nowrap">
                                                        {{$appointment['date']  }}  <br> {{$appointment['hour'] }}
                                                    </td>
                                                    <td  class="text-center text-nowrap">
                                                        @if(isset($appointment->client->id))
                                                        {{$appointment->client->Name}}  <br>
                                                            {{$appointment->client->phone}} <br>
                                                             {{trans('common.code')}}: {{$appointment->client->code}}
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td class="text-center text-nowrap">
                                                        @foreach($appointment->services as $service)
                                                            {{ $service->name }}  <br>
                                                        @endforeach
                                                    </td>
                                                    <td class="text-center text-nowrap">
                                                        @if($appointment->reservation != '' )
                                                            {{ trans('common.total')}} :  {{  $appointment->reservation->totals()['totalPulses'] }} <br>
                                                            {{ trans('common.usedInAppointment')}} :  {{  $appointment->pulses }}
                                                        @else -
                                                        @endif
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
                        </div>
                    <!-- Bordered table end -->

                </div>
            </div>
        </div>
    <!-- Avg Sessions Chart Card ends -->



    @foreach($appointments as $appointment)

        <div class="modal fade text-md-start" id="editappointment{{$appointment->id}}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">

                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pb-5 px-sm-5 pt-50">
                        <div class="text-center mb-2">
                            <h1 class="mb-1">{{trans('common.edit')}}: {{trans('common.appointment')}} </h1>
                        </div>

                        {{Form::open(['url'=>route('doctor.appointments.update',$appointment->id), 'id'=>'editappointmentForm'.$appointment->id, 'class'=>'row gy-1 pt-75 justify-content-center'])}}


                            <div class="col-12 col-md-4 servicesShow">
                                <label class="form-label" for="day">{{trans('common.services')}}</label>
                                @foreach(servicesList() as $service)
                                    <div class="form-check me-3 me-lg-1">
                                        <label class="form-check-label" for="service{{$service->id}}{{$appointment->id}}">
                                            {{$service->name}}
                                        </label>
                                        <input class="form-check-input" type="checkbox" id="service{{$service->id}}{{$appointment->id}}" name="services[]" value="{{$service->id}}" @if($appointment->checkForServApp($service->id) != '') disabled @endif />
                                    </div>
                                @endforeach
                            </div>

                            <div class="col-12 col-sm-4">
                                <label class="form-label" for="machine_id">{{trans('common.machine')}}</label>
                                {{Form::select('machine_id',['' => 'بدون تحديد'] + machinesList(),$appointment->machine_id,['id'=>'machine_id','class'=>'form-select'])}}
                            </div>

                            <div class="col-12 col-sm-4">
                                <label class="form-label" for="nextSession">الجلسة القادمة</label>
                                {{Form::select('nextSession',['' => 'لا يوجد'] + nextSession(session()->get('Lang')),$appointment->nextSession,['id'=>'nextSession','class'=>'form-select'])}}
                            </div>


                            <div class="col-12 col-md-12">
                                <label class="form-label" for="reason">{{trans('common.note')}}</label>
                                {{Form::textarea('note',$appointment->note,['id'=>'note', 'class'=>'form-control','rows'=>'3'])}}
                            </div>
                            <div class="row pt-1">
                                <div class="repeatableAreaPulsess col-sm-12">
                                    <h4>النبضات المستخدمة</h4>
                                    @forelse($appointment->areaPulses as $area)
                                        <div class="row">
                                            <div class="col-12 col-sm-4">
                                                <label class="form-label" for="area_id">{{trans('common.area')}}</label>
                                                {{Form::select('area_id[]',['' => 'بدون تحديد'] + areasList(),$area->area_id,['id'=>'area_id','class'=>'form-select'])}}
                                            </div>

                                            <div class="col-12 col-md-3">
                                                <label class="form-label" for="pulses">{{trans('common.pulses')}}</label>
                                                {{Form::text('pulses[]',$area->pulses,['id'=>'pulses', 'class'=>'form-control'])}}
                                            </div>
                                            <div class="col-12 col-md-3">
                                                <label class="form-label" for="power">الباور</label>
                                                {{Form::text('power[]',$area->power,['id'=>'power', 'class'=>'form-control'])}}
                                            </div>
                                            <div class="col-1 col-md-2 mt-2">
                                                <span class="delete btn btn-icon btn-danger btn-block">
                                                    {{trans('common.delete')}}
                                                </span>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="row">
                                            <div class="col-12 col-sm-4">
                                                <label class="form-label" for="area_id">{{trans('common.area')}}</label>
                                                {{Form::select('area_id[]',['' => 'بدون تحديد'] + areasList(),'',['id'=>'area_id','class'=>'form-select'])}}
                                            </div>

                                            <div class="col-12 col-md-4">
                                                <label class="form-label" for="pulses">{{trans('common.pulses')}}</label>
                                                {{Form::text('pulses[]','',['id'=>'pulses', 'class'=>'form-control'])}}
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <label class="form-label" for="power">الباور</label>
                                                {{Form::text('power[]','',['id'=>'power', 'class'=>'form-control'])}}
                                            </div>
                                        </div>
                                    @endforelse
                                </div>
                                <div class="col-12 mt-2">
                                    <span class="add_AreaPulses btn btn-sm btn-info">{{trans('common.addnew')}} </span>
                                </div>
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

@section('scripts')
    <script type="text/template" id="RepeatAreaPulsesTPL">
        <div class="More row">
            <div class="col-12 col-sm-4">
                <label class="form-label" for="area_id">{{trans('common.area')}}</label>
                {{Form::select('area_id[]',['' => 'بدون تحديد'] + areasList(),'',['id'=>'area_id','class'=>'form-select'])}}
            </div>

            <div class="col-12 col-md-3">
                <label class="form-label" for="pulses">{{trans('common.pulses')}}</label>
                {{Form::text('pulses[]','',['id'=>'pulses', 'class'=>'form-control'])}}
            </div>
            <div class="col-12 col-md-3">
                <label class="form-label" for="power">الباور</label>
                {{Form::text('power[]','',['id'=>'power', 'class'=>'form-control'])}}
            </div>
            <div class="col-1 col-md-2 mt-2">
                <span class="delete btn btn-icon btn-danger btn-block">
                    {{trans('common.delete')}}
                </span>
            </div>
        </div>
    </script>
    <script type="text/javascript">
        $(document).ready(function() {

            var max_fields              = 50;
            var AreaPulses_wrapper   = $(".repeatableAreaPulsess");
            var add_AreaPulses       = $(".add_AreaPulses");
            var RepeatAreaPulsesTPL  = $("#RepeatAreaPulsesTPL").html();


            var x = 1;
            $(add_AreaPulses).click(function(e){
                e.preventDefault();
                if(x < max_fields){
                    x++;
                    $(AreaPulses_wrapper).append(RepeatAreaPulsesTPL); //add input box
                }else{
                    alert('You Reached the limits')
                }
            });

            $(AreaPulses_wrapper).on("click",".delete", function(e){
                e.preventDefault(); $(this).closest('.More').remove(); x--;
            });


        });
    </script>
@stop
