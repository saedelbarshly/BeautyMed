<?php
    $monthDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
?>
<div class="modal fade text-md-start" id="attendance" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-50">
                <div class="table-responsive">
                    <table class="table table-bordered mb-2">
                        <thead class="table-dark">
                            <tr>
                                <th width="150px">{{trans('common.date')}}</th>
                                <th class="text-center">{{trans('common.attendIn')}}</th>
                                <th class="text-center">{{trans('common.attendInLate')}}</th>
                                <th class="text-center">{{trans('common.attendOut')}}</th>
                                <th class="text-center">{{trans('common.attendOutEarly')}}</th>
                                <th class="text-center">{{trans('common.attendOutLate')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for($i=1; $i<=$monthDays; $i++)
                                <tr>
                                    <td>
                                        {{$i.'-'.$month.'-'.$year}}
                                    </td>
                                    <td class="text-center">
                                        {{$user->todayAttendance($year.'-'.$month.'-'.$i)->CheckIn ?? '-'}}
                                    </td>
                                    <td class="text-center">
                                        {{$user->todayAttendance($year.'-'.$month.'-'.$i)->late ?? '-'}}
                                    </td>
                                    <td class="text-center">
                                        {{$user->todayAttendance($year.'-'.$month.'-'.$i)->CheckOut ?? '-'}}
                                    </td>
                                    <td class="text-center">
                                        {{$user->todayAttendance($year.'-'.$month.'-'.$i) != '' ? $user->todayAttendance($year.'-'.$month.'-'.$i)->earlyOutCalculator() : '-'}}
                                    </td>
                                    <td class="text-center">
                                        {{$user->todayAttendance($year.'-'.$month.'-'.$i)->OverTime ?? '-'}}
                                    </td>
                                </tr>
                            @endfor
                            <tr>
                                <td>
                                    {{trans('common.totals')}}
                                </td>
                                <td class="text-center">
                                    -
                                </td>
                                <td class="text-center">
                                    {{$user->monthAttendanceStats($month,$year)['late']}}
                                </td>
                                <td class="text-center">
                                    -
                                </td>
                                <td class="text-center">
                                    {{$user->monthAttendanceStats($month,$year)['earlyCheckOut']}}
                                </td>
                                <td class="text-center">
                                    {{$user->monthAttendanceStats($month,$year)['overTime']}}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
