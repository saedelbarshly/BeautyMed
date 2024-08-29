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
                                <th class="text-center">{{trans('common.name')}}</th>
                                <th class="text-center">{{trans('common.code')}}</th>
                                <th class="text-center">{{trans('common.date')}}  </th>
                                <th class="text-center">{{trans('common.maxClients')}}  </th>
                                <th class="text-center">{{trans('common.discountRate')}}  </th>
                                <th class="text-center">{{trans('common.discountAmount')}}  </th>
                                <th class="text-center">{{trans('common.pulse_offer')}}  </th>
                                <th class="text-center">{{trans('common.services')}}  </th>
                                <th class="text-center">{{trans('common.actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($offers as $offer)
                            <tr id="row_{{$offer->id}}">
                                <td>
                                    {{$offer['name']}}
                                </td>
                                <td>
                                    {{$offer['code']}}
                                </td>
                                <td class="text-nowrap">
                                    من: {{$offer['startDate']}}<br>
                                    إلى: {{$offer['endDate']}}
                                </td> 
                                <td class="text-center text-nowrap">
                                    {{$offer['maxClients'] != '0' ? $offer['maxClients'] : 'غير محدد' }}
                                </td>
                                <td class="text-center text-nowrap">
                                    {{$offer['discountRate'] != '' ? $offer['discountRate'].' %' : '-'}} 
                                </td>
                                <td class="text-center text-nowrap">
                                    {{$offer['discountAmount'] != '' ? $offer['discountAmount'].' ج.م' : '-'}} 
                                </td>
                                <td class="text-center text-nowrap">
                                    {{$offer['pulse_offer'] != '' ? $offer['pulse_offer'].' ج.م' : '-'}} 
                                </td>
                                <td class="text-center text-nowrap">
                                    @foreach($offer->services as $service)
                                            {{ $service->name }} - {{ $service->pivot->offerPrice }} <br> <br>
                                    @endforeach
                                </td>
                                <td class="text-center text-nowrap">
                                    <a href="javascript:;" data-bs-target="#editoffer{{$offer->id}}" data-bs-toggle="modal" class="btn btn-icon btn-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.edit')}}">
                                        <i data-feather='edit'></i>
                                    </a>
                                    <?php $delete = route('admin.offers.delete',['offerId'=>$offer->id]); ?>
                                    <button type="button" class="btn btn-icon btn-danger" onclick="confirmDelete('{{$delete}}','{{$offer->id}}')">
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
                        </tbody>
                    </table>
                </div>

                {{ $offers->links('vendor.pagination.default') }}


            </div>
        </div>
    </div>
    <!-- Bordered table end -->

@foreach($offers as $offer)

    <div class="modal fade text-md-start" id="editoffer{{$offer->id}}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-5 px-sm-5 pt-50">
                    <div class="text-center mb-2">
                        <h1 class="mb-1">{{trans('common.edit')}}: {{$offer['name']}}</h1>
                    </div>
                    {{Form::open(['url'=>route('admin.offers.update',$offer->id), 'id'=>'editofferForm'.$offer->id, 'class'=>'row gy-1 pt-75 justify-content-center'])}}
                        <div class="col-12 col-md-3">
                            <label class="form-label" for="name">{{trans('common.name')}}</label>
                            {{Form::text('name',$offer->name,['id'=>'name', 'class'=>'form-control'])}}
                        </div>
                                 
                        <div class="col-12 col-md-3">
                            <label class="form-label" for="code">{{trans('common.code')}}</label>
                            {{Form::text('code',$offer->code,['id'=>'code', 'class'=>'form-control'])}}
                        </div>

                        <div class="col-12 col-md-3">
                            <label class="form-label" for="startDate">{{ trans('common.startDate') }}  </label>
                            {{Form::date('startDate',$offer->startDate,['id'=>'startDate', 'class'=>'form-control'])}}
                        </div>

                        <div class="col-12 col-md-3">
                            <label class="form-label" for="endDate">{{trans('common.endDate')}}</label>
                            {{Form::date('endDate',$offer->endDate,['id'=>'endDate', 'class'=>'form-control'])}}
                        </div>
                                 
                        <div class="col-12 col-md-3">
                            <label class="form-label" for="maxClients">{{trans('common.maxClients')}}</label>
                            {{Form::text('maxClients',$offer->maxClients,['id'=>'maxClients', 'class'=>'form-control'])}}
                        </div>

                        <div class="col-12 col-md-3">
                            <label class="form-label" for="discountRate">{{ trans('common.discountRate') }}   </label>
                            {{Form::text('discountRate',$offer->discountRate,['id'=>'discountRate', 'class'=>'form-control'])}}
                        </div>
                        
                        <div class="col-12 col-md-3">
                            <label class="form-label" for="discountAmount">{{trans('common.discountAmount')}}</label>
                            {{Form::text('discountAmount',$offer->discountAmount,['id'=>'discountAmount', 'class'=>'form-control'])}}
                        </div>
                        
                        <div class="col-12 col-md-3">
                            <label class="form-label" for="pulse_offer">{{trans('common.pulse_offer')}}</label>
                            {{Form::text('pulse_offer',$offer->pulse_offer,['id'=>'pulse_offer', 'class'=>'form-control'])}}
                        </div>
                     

                        <div class="repeatableNewServices col-sm-12">
                            <h4> services </h4>
                            @if(count($offer->services) > 0 )
                                @foreach($offer->services as $service)
                                    <div class="More row">
                                        <div class="col-12 col-sm-5">
                                            <label class="form-label" for="servicesId">{{trans('common.service')}}</label>
                                            {{Form::select('servicesId[]', serviceList(),$service->id,['id'=>'servicesId','class'=>'form-select','required'])}}
                                        </div>
                                        <div class="col-12 col-md-5">
                                            <label class="form-label" for="servicesId">{{trans('common.price')}}</label>
                                            {{ Form::text('servicesPrice[]',$service->pivot->offerPrice,array('id'=>'servicesPrice','class'=>'form-control')) }}
                                        </div>
                                        <div class="col-1 col-md-1 mt-2">
                                            <span class="delete btn btn-danger">
                                                حذف
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                                @else
                                    <div class="More row">
                                        <div class="col-12 col-sm-5">
                                                <label class="form-label" for="servicesId">{{trans('common.service')}}</label>
                                                {{Form::select('servicesId[]', serviceList(),'',['id'=>'servicesId','class'=>'form-select','required'])}}
                                            </div>
                                            <div class="col-12 col-md-5">
                                                <label class="form-label" for="servicesId">{{trans('common.price')}}</label>
                                                {{ Form::text('servicesPrice[]','',array('id'=>'servicesPrice','class'=>'form-control')) }}
                                            </div>
                                    </div>
                                @endif
                        </div>
                        <div class="col-12">
                            <span class="add_NewService btn btn-sm btn-info">أضف جديد</span>
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
    <a href="javascript:;" data-bs-target="#createoffer" data-bs-toggle="modal" class="btn btn-primary">
        {{trans('common.CreateNew')}}
    </a>

    <div class="modal fade text-md-start" id="createoffer" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-5 px-sm-5 pt-50">
                    <div class="text-center mb-2">
                        <h1 class="mb-1">{{trans('common.CreateNew')}}</h1>
                    </div>
                    {{Form::open(['url'=>route('admin.offers.store'), 'id'=>'createofferForm', 'class'=>'row gy-1 pt-75 justify-content-center'])}}
                        <div class="col-12 col-md-3">
                            <label class="form-label" for="name">{{trans('common.name')}}</label>
                            {{Form::text('name','',['id'=>'name', 'class'=>'form-control'])}}
                        </div>
                        <div class="col-12 col-md-3">
                            <label class="form-label" for="code">{{trans('common.code')}}</label>
                            {{Form::text('code','',['id'=>'code', 'class'=>'form-control'])}}
                        </div>
                        <div class="col-12 col-md-3">
                            <label class="form-label" for="startDate">{{trans('common.startDate')}} </label>
                            {{Form::date('startDate',date('Y-m-d'),['id'=>'startDate', 'class'=>'form-control'])}}
                        </div>

                        <div class="col-12 col-md-3">
                            <label class="form-label" for="endDate">{{trans('common.endDate')}}</label>
                            {{Form::date('endDate',date('Y-m-d'),['id'=>'endDate', 'class'=>'form-control'])}}
                        </div>
                        <div class="col-12 col-md-3">
                            <label class="form-label" for="maxClients">{{trans('common.maxClients')}}</label>
                            {{Form::text('maxClients',0,['id'=>'maxClients', 'class'=>'form-control'])}}
                        </div>
                     
                        <div class="col-12 col-md-3">
                            <label class="form-label" for="discountRate">{{trans('common.discountRate')}} </label>
                            {{Form::text('discountRate','',['id'=>'discountRate', 'class'=>'form-control'])}}
                        </div>
                        <div class="col-12 col-md-3">
                            <label class="form-label" for="discountAmount">{{trans('common.discountAmount')}}</label>
                            {{Form::text('discountAmount','',['id'=>'discountAmount', 'class'=>'form-control'])}}
                        </div>
                        <div class="col-12 col-md-3">
                            <label class="form-label" for="pulse_offer">{{trans('common.pulse_offer')}}</label>
                            {{Form::text('pulse_offer','',['id'=>'pulse_offer', 'class'=>'form-control'])}}
                        </div>
 
                        <div class="repeatableServices col-sm-12">
                            <h4> services </h4>
                            <div class="row">
                                <div class="col-12 col-sm-5">
                                    <label class="form-label" for="servicesId">{{trans('common.service')}}</label>
                                    {{Form::select('servicesId[]', serviceList(),'',['id'=>'servicesId','class'=>'form-select','required'])}}
                                </div>
                                <div class="col-12 col-md-5">
                                    <label class="form-label">{{trans('common.price')}}</label>
                                    {{ Form::text('servicesPrice[]','',array('id'=>'servicesPrice','class'=>'form-control')) }}
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <span class="add_Service btn btn-sm btn-info">أضف جديد</span>
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

<script type="text/template" id="RepeatServiceTPL">
        <div class="More row">
            <div class="col-12 col-sm-5">
                <label class="form-label" for="serviceId">{{trans('common.service')}}</label>
                {{Form::select('servicesId[]', serviceList(),'',['id'=>'serviceId','class'=>'form-select','required'])}}
            </div>
            <div class="col-12 col-md-5">
                <label class="form-label">{{trans('common.price')}}</label>
                {{ Form::text('servicesPrice[]','',array('id'=>'servicesPrice','class'=>'form-control')) }}
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

       

    </script>


@stop