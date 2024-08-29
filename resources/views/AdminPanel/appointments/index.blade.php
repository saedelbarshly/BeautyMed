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
                                <th class="text-center">{{trans('common.date')}}  </th>
                                <th class="text-center">{{trans('common.clientname')}}</th>
                                <th class="text-center">{{trans('common.doctor')}}</th>
                                <th class="text-center">{{trans('common.service')}}  </th>
                                <th class="text-center">{{trans('common.area')}}</th>
                                <th class="text-center">{{trans('common.pulses')}}</th>
                                <th class="text-center">{{trans('common.power')}}</th>
                                <th class="text-center">{{trans('common.actions')}}</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">    
                            @forelse($appointments as $appointment)
                            <tr id="row_{{$appointment->id}}">
                                <td class="text-center text-nowrap">
                                    {{trans('common.day')}} :{{$appointment['date']  }} <br>  
                                    {{trans('common.hour')}}: {{$appointment['hour'] }} 
                                </td>
                                <td>
                                  {{  $appointment->client->Name }}
                                </td>
                                 <td>
                                  {{  $appointment->doctor->name ?? ' - ' }}
                                </td>
                                <td class="text-center text-nowrap">
                                    @foreach($appointment->services as $service)
                                        {{ $service->name }}  <br>
                                    @endforeach
                                </td> 
                                {{-- <td>
                                    @if($appointment->pulses != '')  {{  $appointment->pulses }} @else - @endif
                                </td>
                                <td>
                                    {{ $appointment->power ?? '-' }}
                                </td> --}}
                                <td>
                                    @foreach ($appointment->appointmentMore as $key)
                                    {{ areasListName($key->area_id) }}</p>
                                     @endforeach
                                </td>
                                <td>
                                    @foreach ($appointment->appointmentMore as $key)
                                     {{ $key->pulses }}</p>
                                    @endforeach
                                </td>

                                <td>
                                    @foreach ($appointment->appointmentMore as $key)
                                     {{ $key->power }}</p>
                                    @endforeach
                                </td>


                                <td class="text-center text-nowrap">
 
                                    @if($appointment->status == 'pending')
                                        <a href="{{route('admin.appointments.updateStatus',$appointment->id)}}" class="btn btn-icon btn-dark" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.inClinic')}}">
                                            <i data-feather='bell'></i>
                                        </a>
                                    @elseif($appointment->status == 'inClinic')
                                        <a href="{{route('admin.appointments.updateStatus',$appointment->id)}}" class="btn btn-icon btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.withDoctor')}}">
                                            <i data-feather='bell'></i>
                                        </a>  
                                    @elseif($appointment->status == 'withDoctor')
                                        <a href="{{route('admin.appointments.updateStatus',$appointment->id)}}" class="btn btn-icon btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.completedSession')}}">
                                            <i data-feather='bell'></i>
                                        </a>  
                                    @endif 

                                    <a href="javascript:;" data-bs-target="#editappointment{{$appointment->id}}" data-bs-toggle="modal" class="btn btn-icon btn-info">
                                        <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.edit')}}">
                                            <i data-feather='edit'></i>
                                        </span>    
                                    </a>
                                    <?php $delete = route('admin.appointments.delete',['id'=>$appointment->id]); ?>
                                    <button type="button" class="btn btn-icon btn-danger" onclick="confirmDelete('{{$delete}}','{{$appointment->id}}')" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.delete')}}">
                                        <i data-feather='trash-2'></i>
                                    </button>
                                    <div class="col-12 mb-1"></div>
                                   

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

 
    @foreach($appointments as $appointment)
      @include('AdminPanel.appointments.edit',['appointment'=>$appointment])
    @endforeach

@stop







      
@section('page_buttons')

    <!-- create appointment  -->
    <a href="javascript:;" data-bs-target="#createAppointment{{$reservation->id}}" data-bs-toggle="modal" class="btn btn-icon btn-primary">
             {{trans('common.createAppointment')}}
        </span>    
    </a>
 
    @include('AdminPanel.appointments.create',['reservation'=>$reservation])
 
@stop


@section('scripts')
<style>
    .offersShow,.offersShow {
        display: none;
    }
</style>


<script type="text/template" id="RepeatServiceTPL">
        <div class="More row">
            <div class="col-12 col-sm-5">
                <label class="form-label" for="serviceId">{{trans('common.service')}}</label>
                {{Form::select('servicesId[]', servicesList(),'',['id'=>'serviceId','class'=>'form-select','required'])}}
            </div>
            <div class="col-12 col-md-5">
                <label class="form-label">{{trans('common.price')}}</label>
                {{ Form::text('servicesPrice[]','',array('id'=>'servicesPrice','class'=>'form-control','onkeyup'=>'updateTotals(this)')) }}
            </div>
            <div class="col-1 col-md-1 mt-2">
                <span class="delete btn btn-danger">
                    حذف
                </span>
            </div>
        </div>
</script>



<script type="text/javascript">
    $(document).ready(function() {

        var max_fields          = 50;
        var wrapper             = $(".repeatableServices");
        var add_button          = $(".add_Service");
        var wrapperNew             = $(".repeatableNewServices");
        var add_buttonNew          = $(".add_NewService");
        var RepeatOpponentTPL   = $("#RepeatServiceTPL").html();

        var x = 1;
        $(add_button).click(function(e){
            e.preventDefault();
            if(x < max_fields){
                x++;
                $(wrapper).append(RepeatOpponentTPL); //add input box
            }else{
                alert('You Reached the limits')
            }
        });
        $(add_buttonNew).click(function(e){
            e.preventDefault();
            if(x < max_fields){
                x++;
                $(wrapperNew).append(RepeatOpponentTPL); //add input box
            }else{
                alert('You Reached the limits')
            }
        });

        $(wrapper).on("click",".delete", function(e){
            e.preventDefault(); $(this).closest('.More').remove(); x--;
        });
        
        $(wrapperNew).on("click",".delete", function(e){
            e.preventDefault(); $(this).closest('.More').remove(); x--;
        });

    });


    let discountRate = document.querySelectorAll('.discountRate1')
    let discountAmount = document.querySelectorAll('.discountAmount1')

    console.log(discountRate)

    discountRate.forEach((el)=>{
        el.addEventListener('focus', ()=>{
            discountRate.forEach((e)=>{
                e.parentElement.style.display="none"
            }) 
        })
    })
    

</script>


@stop

