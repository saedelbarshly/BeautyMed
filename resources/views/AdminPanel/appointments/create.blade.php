<div class="modal fade text-md-start" id="createAppointment{{isset($reservation) ? $reservation->id : ''}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
        <div class="modal-content"> 
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-5 px-sm-5 pt-50">
                <div class="text-center mb-2">
                    <h1 class="mb-1">{{trans('common.createAppointment')}}</h1>
                </div>
                {{Form::open(['url'=>route('admin.appointments.store',$reservation->id), 'id'=>'addAppointmentForm', 'class'=>'row gy-1 pt-75'])}}
 
                    <div class="col-12 col-md-4 servicesShow">
                        <label class="form-label" for="day">{{trans('common.services')}}</label>
                            @foreach(servicesList() as $service)
                                <div class="form-check me-3 me-lg-1">
                                    <label class="form-check-label" for="service{{$service->id}}{{$reservation->id}}">
                                        {{$service->name}}
                                    </label>
                                    <input class="form-check-input" type="checkbox" id="service{{$service->id}}{{$reservation->id}}" name="services[]" value="{{$service->id}}" />
                                </div>
                            @endforeach
                    </div>

                    {{-- <div class="col-12 col-sm-4">
                        <label class="form-label" for="area_id">{{trans('common.area')}}</label>
                        {{Form::select('area_id',['0'=>'بدون تحديد'] + areasList(),'',['id'=>'area_id','class'=>'form-select','required'])}}
                    </div>   --}}
                    
                    
                        <div class="col-md-4">
                            <label class="form-label" for="doctor_id">{{trans('common.doctors')}}</label>
                            {{Form::select('doctor_id',['' => 'بدون تحديد'] + doctorsList(),'',['id'=>'doctor_id','class'=>'form-control selectpicker','data-live-search'=>'true'])}}
                        </div>
                        
                        {{-- <div class="col-12 col-md-4">
                            <label class="form-label" for="pulses">{{trans('common.pulses')}}</label>
                            {{Form::number('pulses','',['id'=>'pulses', 'class'=>'form-control', 'min'=>1])}}
                        </div>
                         <div class="col-12 col-md-4">
                            <label class="form-label" for="power">{{trans('common.power')}}</label>
                            {{Form::number('power','',['id'=>'power', 'class'=>'form-control'])}}
                        </div> --}}
                        
                    <div class="col-12 col-md-4">
                        <label class="form-label" for="day">{{trans('common.date')}}</label>
                        {{Form::date('date','',['id'=>'day', 'class'=>'form-control','onchange'=>'getAvailableTimes(this.value)'])}}
                    </div>

                    <div class="col-12  col-md-4">
                        <label class="form-label" for="time">{{trans('common.time')}}</label>
                        <div class="row hoursRadios"></div>
                    </div>

 
                    <div class="col-12 col-md-12">
                        <label class="form-label" for="body">{{trans('common.body')}}</label>
                        {{Form::text('body','',['id'=>'body', 'class'=>'form-control'])}}
                    </div>
 
                    
                    {!! Form::hidden('reservation_id', $reservation->id ?? '0') !!}  
                    {!! Form::hidden('client_id', $reservation->client->id ?? '0') !!}  
                   

                     {{-- add more section --}}
                    <div class="repeatableTempRest">

                        <div class="col-12 col-sm-4">
                            <label class="form-label" for="area_id">{{trans('common.area')}}</label>
                            {{Form::select('area_id[]',['0'=>'بدون تحديد'] + areasList(),'',['id'=>'area_id','class'=>'form-select','required'])}}
                        </div> 
                        <div class="col-12 col-md-4">
                            <label class="form-label" for="pulses">{{trans('common.pulses')}}</label>
                            {{Form::number('pulses[]','',['id'=>'pulses', 'class'=>'form-control', 'min'=>1])}}
                        </div>

                        <div class="col-12 col-md-4">
                            <label class="form-label" for="power">{{trans('common.power')}}</label>
                            {{Form::number('power[]','',['id'=>'power', 'class'=>'form-control'])}}
                        </div>

                    </div>
                    <div class="col-12 mt-2">
                        <span class="add_tempo_rest btn btn-sm btn-info">
                            {{trans('common.add-more')}}
                        </span>
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

@section('scripts')
    <script type="text/template" id="RepeatTempoRestTPL">
    <div class="More row mb-1">
            <h6>المزيد</h6>
            <div class="col-12 col-sm-4">
                <label class="form-label" for="area_id">{{trans('common.area')}}</label>
                {{Form::select('area_id[]',['0'=>'بدون تحديد'] + areasList(),'',['id'=>'area_id','class'=>'form-select','required'])}}
            </div> 
            <div class="col-12 col-md-4">
                <label class="form-label" for="pulses">{{trans('common.pulses')}}</label>
                {{Form::number('pulses[]','',['id'=>'pulses', 'class'=>'form-control', 'min'=>1])}}
            </div>

            <div class="col-12 col-md-4">
                <label class="form-label" for="power">{{trans('common.power')}}</label>
                {{Form::number('power[]','',['id'=>'power', 'class'=>'form-control'])}}
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
            var max_fields = 50;
            var ContractServices_wrapper = $(".repeatableTempRest");
            var add_tempo_rest = $(".add_tempo_rest");
            var RepeatTempoRestTPL = $("#RepeatTempoRestTPL").html();
            var x = 1;
            $(add_tempo_rest).click(function(e) {
                e.preventDefault();
                if (x < max_fields) {
                    x++;
                    $(ContractServices_wrapper).append(RepeatTempoRestTPL); //add input box
                } else {
                    alert('You Reached the limits')
                }
            });
            $(ContractServices_wrapper).on("click", ".delete", function(e) {
                e.preventDefault();
                $(this).closest('.More').remove();
                x--;
            });
        });
    </script>
@stop


