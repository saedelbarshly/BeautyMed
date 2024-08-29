<div class="modal fade text-md-start" id="createPayment{{isset($reservation) ? $reservation->id : ''}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
        <div class="modal-content"> 
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-5 px-sm-5 pt-50">
                <div class="text-center mb-2">
                    <h1 class="mb-1">{{trans('common.createPayment')}}</h1>
                </div>
                {{Form::open(['url'=>route('admin.payments.store'), 'id'=>'addPaymentForm', 'class'=>'row gy-1 pt-75'])}}

                    <div class="col-12 col-md-4">
                        <label class="form-label" for="Date">{{trans('common.date')}}</label>
                        {{Form::date('Date','',['id'=>'Date', 'class'=>'form-control','required'])}}
                    </div> 
                    <div class="col-12 col-md-4">
                        <label class="form-label" for="amount">{{trans('common.amount')}}</label>
                        {{Form::number('amount','',['step'=>'.01','id'=>'amount', 'class'=>'form-control','required'])}}
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label" for="safe_id">{{trans('common.safe')}}</label>
                        {{Form::select('safe_id',safesList(),'',['id'=>'safe_id', 'class'=>'form-select','required'])}}
                    </div>
                    <div class="col-12 col-md-12">
                        <label class="form-label" for="Notes">{{trans('common.paymentDetails')}}</label>
                        {{Form::textarea('Notes','',['rows'=>'2','id'=>'Notes', 'class'=>'form-control'])}}
                    </div>
                    
                    {!! Form::hidden('reservation_id', $reservation->id ?? '0') !!}  
                    {!! Form::hidden('client_id', $reservation->client->id ?? '0') !!}  
                    {!! Form::hidden('UID', Auth::user()->id) !!}
                    {!! Form::hidden('Type','revenues') !!}  
        
                    

                    <div class="col-12 text-center mt-2 pt-50">
                        <button type="submit" class="btn btn-primary me-1">{{trans('common.Save changes')}}</button>
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                            {{trans('common.Cancel')}}
                        </button>
                    </div>
                {{Form::close()}}   <br>



                <!-- Bordered table start -->
                    <div class="row" id="table-bordered">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header"> 
                                    <h4 class="card-title d-flex justify-content-between w-100"> 
                                          <span >   {{trans('common.total')}} :    {{  $reservation->totals()['total'] }} </span>
                                          <span>  {{trans('common.paid')}}  :    {{  $reservation->totals()['paid']  }}</span>
                                          <span>  {{trans('common.remaining')}}  :  {{  $reservation->totals()['net']  }} </span>
                                    </h4>
                                </div> 
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-2">
                                        <thead> 
                                            <tr>   
                                                <th class="text-center">{{trans('common.date')}}  </th>
                                                <th class="text-center">{{trans('common.amount')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>      
                                            @forelse(revenuesList($reservation->id) as $revenue)
                                            <tr id="row_{{$revenue->id}}">
                                                <td class="text-center text-nowrap">
                                                    {{trans('common.day')}} :{{$revenue['Date']  }}
                                                </td>
                                                <td class="text-center text-nowrap">
                                                  {{  $revenue->amount }}
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
</div>