@extends('DoctorPanel.layouts.master')
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
                            <div class="d-flex align-items-start me-2">
                                <span class="badge bg-light-primary p-75 rounded">
                                    <i data-feather="check" class="font-medium-2"></i>
                                </span>
                                <div class="ms-75">
                                    <h4 class="mb-0"> {{ $client->reservations->count() }}</h4>
                                    <small> حجز </small>
                                </div>
                            </div>
                        </div> <br>
                        <h4 class="fw-bolder border-bottom pb-50 mb-1">البيانات</h4>
                        <div class="info-container">
                            
                            <ul class="list-unstyled">
                                <li class="mb-75">
                                    <span class="fw-bolder me-25"> الكود:</span>
                                    <span>{{ $client->code }}</span>
                                </li>
                                
                                <li class="mb-75">
                                    <span class="fw-bolder me-25">الهاتف:</span>
                                    <span>{{ $client->phone }}</span>
                                </li>

                            </ul>
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
                                    <th class="text-center">{{trans('common.date')}}  </th>
                                    <th class="text-center">{{trans('common.Officials')}}</th>
                                    <th class="text-center">{{trans('common.serviceoffer')}}</th>
                                    <th class="text-center">{{trans('common.pulses')}}</th>
                                    <th class="text-center">الباور</th>
                                </tr>
                            </thead>
                            <tbody>   

                                @forelse($reservations as $reservation)
                                <tr id="row_{{$reservation->id}}">
                                    <td class="text-center text-nowrap">
                                        {{$reservation['date']  }} <br>  
                                        {{$reservation['time'] }} 
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
                                        إجمالي :  {{  $reservation->totals()['net_pulses'] }} <br> 
                                        المستهلك :  {{  $reservation->totals()['usedPulses'] }}
                                    </td>
                                    <td class="text-center text-nowrap">
                                        {{  $reservation->totals()['usedPower'] }}
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
                                        <th class="text-center">{{trans('common.clientname')}}</th>
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
                                        <td>
                                            <a href="{{route('admin.clients.profile',$complaint->client_id)}}" class="btn btn-icon btn-light" data-bs-toggle="tooltip" data-bs-placement="top"">
                                            {{$complaint->client->Name  }} 
                                            </a>  
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
                                            <td colspan="6" class="p-3 text-center ">
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

@stop
