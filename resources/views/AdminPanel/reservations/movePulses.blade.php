<div class="modal fade text-md-start" id="movePulses{{isset($reservation) ? $reservation->id : ''}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-5 px-sm-5 pt-50">
                <div class="text-center mb-2">
                    <h1 class="mb-1">{{trans('common.movePulses')}}</h1>
                </div>
                {{Form::open(['url'=>route('admin.reservations.movePulses.store'), 'id'=>'movePulsesForm', 'class'=>'row gy-1 pt-75'])}}


                    {{-- <div class="col-12 col-md-6">
                        <label class="form-label" for="reservationReceiver_id">{{trans('common.movedToReservation')}}</label>
                        {{Form::text('reservationReceiver_id', '',['id'=>'reservationReceiver_id', 'class'=>'form-control'])}}
                    </div> --}}

                    <div class="col-12 col-md-6">
                        <label class="form-label" for="user_id">{{trans('common.clients')}}</label>
                        {{Form::select('clientReceiver_id',clientList(),'',['id'=>'client_id','class'=>'form-control selectpicker','data-live-search'=>'true'])}}
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label" for="pulses">{{trans('common.pulses')}}</label>
                        {{Form::text('pulses','',['id'=>'pulses', 'class'=>'form-control'])}}
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
                                        <span >   {{trans('common.possibleMoved')}} :    {{  $reservation->totals()['net_pulses'] }} </span>
                                    </h4>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-2">
                                        <thead>
                                            <tr>
                                                <th class="text-center">{{trans('common.date')}}  </th>
                                                <th class="text-center">{{trans('common.receivedReservation')}}</th>
                                                <th class="text-center">{{trans('common.movedPulses')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php $transformPulses = App\Models\TransformationPulses::where('reservationSender_id',$reservation->id)->get(); ?>
                                            @forelse($transformPulses as $transformPulse)
                                            <tr id="row_{{$transformPulse->id}}">
                                                <td class="text-center text-nowrap">
                                                     {{ $transformPulse->date }}
                                                </td>
                                                <td class="text-center text-nowrap">
                                                     {{ $transformPulse->reservationReceiver_id }}
                                                </td>
                                                <td class="text-center text-nowrap">
                                                    {{ $transformPulse->pulses }}
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
