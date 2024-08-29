<div class="modal fade text-md-start" id="addReservation{{isset($clientData) ? $clientData->id : ''}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
        <div class="modal-content"> 
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-5 px-sm-5 pt-50"> 
                <div class="text-center mb-2">
                    <h1 class="mb-1">{{trans('common.addReservation')}}</h1>
                        @if(isset($clientData))
                             <p>{{$clientData->name}}</p>                           
                        @endif
                </div>
                {{Form::open(['url'=>route('admin.reservations.store'), 'id'=>'addReservationForm', 'class'=>'row gy-1 pt-75' ,'method' => 'POST'])}}
                      
                    @if(!isset($clientData))  
                    <div class="col-12 col-md-4">
                        <label class="form-label" for="user_id">{{trans('common.clients')}}</label>
                        {{Form::select('client_id',clientList(),'',['id'=>'client_id','class'=>'form-control selectpicker','data-live-search'=>'true'])}}
                    </div>
                    @else
                        {!! Form::hidden('client_id', $clientData->id) !!}                            
                    @endif

                    <div class="col-12 col-md-4">
                        <label class="form-label" for="user_id">{{trans('common.doctors')}}</label>
                        {{Form::select('doctor_id',[''=>'بدون تحديد'] + doctorsList(),'',['id'=>'doctor_id','class'=>'form-control selectpicker','data-live-search'=>'true'])}}
                    </div>    
                 
                    <div class="col-12 col-md-4">
                        <label class="form-label" for="hours">نوع الحجز</label>
                        <div class="single-input-field">
                            {{Form::select('serviceoffer',[
                                                    '' => 'اختر من القائمة',
                                                    'services' => trans('common.service'),
                                                    'offers' => trans('common.offer')
                                                    ],'',['class'=>'form-control','id'=>'serviceoffer','onchange'=>'serviceOffer()','required'])}}
                            @if ($errors->has('serviceoffer')) 
                                <label id="serviceoffer-error" class="alert-danger" for="serviceoffer">{{ $errors->first('serviceoffer') }}</label>
                            @endif
                        </div>
                    </div> 
                    <div class="col-12"></div>
                    @foreach(servicesList() as $service)
                        <div class="col-md-3 servicesShow">
                            <div class="form-check me-3 me-lg-1">
                                <input class="form-check-input" type="checkbox" id="service{{$service->id}}" name="services[]" value="{{$service->id}}" onchange="getAvailableTimes()" />
                                <label class="form-check-label" for="service{{$service->id}}">
                                    {{$service->name}}
                                </label>
                            </div>
                        </div>
                    @endforeach
 
                    @foreach(offersList() as $offer)
                        <div class="col-md-3 offersShow">
                            <div class="form-check me-3 me-lg-1">
                                {{ Form::radio('offer_id', $offer->id, false,['id'=>'offer'.$offer->id,'class'=>'form-check-input','onchange'=>'getAvailableTimes()' ]) }}
                                <label class="form-check-label offerRadio" for="offer{{$offer->id}}">
                                    {{$offer->name}}
                                </label>
                            </div>
                        </div>
                    @endforeach
                    <div class="col-md-3 offersShow">
                        <input type="button" value="إزالة التحديد" class="btn btn-default btn-sm" id="removeRadio" onclick="removeRadio()">
                    </div>
                    <div class="col-12"></div>

                    <div class="col-12 col-md-4">
                        <label class="form-label" for="day">{{trans('common.date')}}</label>
                        {{Form::date('date','',['id'=>'day', 'class'=>'form-control','onchange'=>'getAvailableTimes()'])}}
                    </div>
                     
                    <div class="col-12"></div>
                    <div class="col-12 col-md-4">
                        <label class="form-label" for="hours">{{trans('common.hours')}}</label>
                        {{Form::select('hour',hoursList(),'',['id'=>'hours', 'class'=>'form-control'])}}
                    </div>
                    
                    {{-- <div class="col-12">
                        <label class="form-label" for="hours">{{trans('common.time')}}</label>
                        <div class="row hoursRadios"></div>
                    </div> --}}
 
                    <div class="col-12 col-md-12">
                        <label class="form-label" for="reason">{{trans('common.note')}}</label>
                        {{Form::textarea('note','',['id'=>'note', 'class'=>'form-control','rows'=>'3'])}}
                    </div>

                    {!! Form::hidden('user_id',Auth::user()->id) !!}    
                    {!! Form::hidden('status',1) !!}  
    

                      
                                
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