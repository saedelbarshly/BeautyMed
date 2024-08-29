<div class="modal fade text-md-start" id="movePayment{{isset($reservation) ? $reservation->id : ''}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-5 px-sm-5 pt-50">
                <div class="text-center mb-2">
                    <h1 class="mb-1">{{trans('common.movePayment')}}</h1>
                </div>
                {{Form::open(['url'=>route('admin.reservations.movePayment.store'), 'id'=>'movePaymentForm', 'class'=>'row gy-1 pt-75'])}}


                    <div class="col-12 col-md-6">
                        <label class="form-label" for="reservationReceiver_id">{{trans('common.movedToReservation')}}</label>
                        {{Form::text('reservationReceiver_id', '',['id'=>'reservationReceiver_id', 'class'=>'form-control'])}}
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label" for="payment">{{trans('common.payment')}}</label>
                        {{Form::text('payment','',['id'=>'payment', 'class'=>'form-control'])}}
                    </div>

                    {!! Form::hidden('user_id',Auth::user()->id) !!}

                    {!! Form::hidden('reservationSender_id',$reservation->id ?? '0') !!}
                    {!! Form::hidden('clientSender_id',$reservation->client->id ?? '0') !!}

                    <div class="col-12 text-center mt-2 pt-50">
                        <button type="submit" class="btn btn-primary me-1">{{trans('common.Save changes')}}</button>
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                            {{trans('common.Cancel')}}
                        </button>
                    </div>
                {{Form::close()}}  <br>



                    <!-- Bordered table start -->
                    <div class="row" id="table-bordered">
                        <div class="col-12">
                            <div class="card">
                            <div class="card-header">
                                    <h4 class="card-title d-flex justify-content-between w-100">
                                          <span >   {{trans('common.total')}} :    {{  $reservation->totals()['net_Payment'] }} </span>
                                    </h4>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-2">
                                        <thead>
                                            <tr>
                                                <th class="text-center">{{trans('common.date')}}  </th>
                                                <th class="text-center">{{trans('common.receivedReservation')}}</th>
                                                <th class="text-center">{{trans('common.movedPayment')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php $transformPayments = App\Models\TransformationPayment::where('reservationSender_id',$reservation->id)->get(); ?>
                                            @forelse($transformPayments as $transformPayment)
                                            <tr id="row_{{$transformPayment->id}}">
                                                <td class="text-center text-nowrap">
                                                     {{ $transformPayment->date }}
                                                </td>
                                                <td class="text-center text-nowrap">
                                                     {{ $transformPayment->reservationReceiver_id }}
                                                </td>
                                                <td class="text-center text-nowrap">
                                                    {{ $transformPayment->payment }}
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
