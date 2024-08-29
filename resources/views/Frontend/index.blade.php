<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" type="text/css" href="{{asset('FrontendAssets/css/all.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('FrontendAssets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('FrontendAssets/css/bootstrap-datepicker.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('FrontendAssets/css/main.css')}}">


    <title>Biondi</title>
  </head>
  <body>
    <header>
      <nav>
        <div class="container h-100">
          <a href="https://biondiclinic.com/" class="nav-brand">
            BIONDI CLINIC
          </a>
        </div>
      </nav>
    </header>
    <section class="page-content">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <div class="info">
              <div class="logo">
              <img src="{{ getSettingImageLink('logoImage') }}" class="img-fluid" alt="bionidi logo"/>
              </div>
              <div class="text">
                <h2 class="title">{!! getSettingValue('logoTitle')  !!}</h2>
                <p class="description">
                     {!!  getSettingValue('logoDescription') !!}
                </p>
              </div>
            </div> 
          </div>  
          <div class="col-md-6">
            <div class="form">
            {{Form::open(['url'=>route('frontend.reservations.store'), 'id'=>'addReservationForm', 'class'=>'row gy-1 pt-75'])}}
    
                <div class="form-floating mb-3">
                  {{Form::text('Name', '',['id'=>'name', 'class'=>'form-control', 'placeholder'=>'name'])}}
                  <label class="form-label" for="name">{{trans('common.name')}}</label>
                </div> 
  

                <div class="form-floating mb-3">
                  {{Form::text('phone','',['id'=>'phone', 'class'=>'form-control', 'placeholder'=>'phone'])}}
                  <label class="form-label" for="phone">{{trans('common.phone')}}</label>
                </div>

                <div class="form-floating mb-3">
                    {{Form::select('doctor_id',[''=>'بدون تحديد'] + doctorsList(),'',['id'=>'doctor_id','class'=>'form-select selectpicker','data-live-search'=>'true'])}}
                    <label class="form-label" for="doctor_id">{{trans('common.doctors')}}</label>
                </div>    
            
                <div class="form-floating mb-3">
                  {{Form::date('date','',['id'=>'day', 'class'=>'form-control', 'placeholder'=>'date'])}}
                    <label class="form-label" for="day">{{trans('common.date')}}</label>
                </div>
                <div class="form-floating mb-3">
                  {{Form::select('time',hoursList(),'',['id'=>'hours', 'class'=>'form-control'])}}
                    <label class="form-label" for="hours">{{trans('common.hours')}}</label>
                </div>

                <div class="form-floating mb-3" style="margin-top:36px">
                          <div class="single-input-field">
                              {{Form::select('serviceoffer',[
                                                      'serviceoffer' => trans('common.serviceoffer'),
                                                      'services' => trans('common.service'),
                                                      'offers' => trans('common.offer')
                                                      ],'',['class'=>'form-control','id'=>'serviceoffer','onchange'=>'serviceOffer(this.value)','required'])}}
                              @if ($errors->has('serviceoffer')) 
                                  <label id="serviceoffer-error" class="alert-danger" for="serviceoffer">{{ $errors->first('serviceoffer') }}</label>
                              @endif
                          </div>
                      </div> 
                     
                      <div class="form-floating mb-3 servicesShow">
                          @foreach(servicesList() as $service)
                              <div class="form-check me-3 me-lg-1">
                                  <input class="form-check-input" type="checkbox" id="service{{$service->id}}" name="services[]" value="{{$service->id}}" />
                                  <label class="form-check-label" for="service{{$service->id}}">
                                      {{$service->name}}
                                  </label>
                              </div>
                          @endforeach
                      </div>
    
                      <div class="form-floating mb-3 offersShow">
                          @foreach(offersList() as $offer)
                              <div class="form-check me-3 me-lg-1">
                                  {{ Form::radio('offer_id', $offer->id, false,['class'=>'form-check-input']) }}
                                  <label class="form-check-label" for="offer{{$offer->id}}">
                                      {{$offer->name}}
                                  </label>
                              </div>
                          @endforeach
                      </div>
   
                      <div class="form-floating mb-3">
                        {{Form::textarea('note','',['id'=>'note', 'class'=>'form-control','rows'=>'3', 'placeholder'=>'note'])}}
                          <label class="form-label" for="reason">{{trans('common.note')}}</label>
                      </div>
                    

                        <button type="submit" class="btn btn-primary mt-3 w-100">
                        Submit
                        </button>
                {{Form::close()}}
          
                
            </div>
          </div>
        </div>
      </div>
    </section>
    <footer>
      <div class="middle-space"></div>
      <div class="container">
        <p class="copyright">
          &copy; Copyright
          <span id="year"></span>
          All Rights Reserved by
          <a href="https://biondiclinic.com/">Biondi Clinic</a>
        </p>
      </div>
    </footer>
    

    <script src="{{asset('FrontendAssets/js/jquery.min.js')}}"></script>
    <script src="{{asset('FrontendAssets/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('FrontendAssets/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('FrontendAssets/js/main.js')}}"></script>

   
<script>
    function serviceOffer(val) {
        var type = val;
        console.log(type);
        if(type == 'serviceoffer')
        {
            $('.offersShow').hide();
            $('.servicesShow').hide();
        }
        if (type == 'offers') {
            $('.offersShow').show();
        } else {
            $('.offersShow').hide();
        }
        if (type == 'services') {
            $('.servicesShow').show();
        } else {
            $('.servicesShow').hide();
        }
    }

</script>

  </body>
</html>
