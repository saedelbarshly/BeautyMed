@extends('DoctorPanel.layouts.master')
@section('content')
<?php
    $month = date('m');
    $year = date('Y');
    if (isset($_GET['month'])) {
        if ($_GET['month'] != '') {
            $month = $_GET['month'];
        }
    }
    if (isset($_GET['year'])) {
        if ($_GET['year'] != '') {
            $year = $_GET['year'];
        }
    }
?>

    <!-- Bordered table start -->
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">

                <div class="table-responsive">
                    <table class="table table-bordered mb-2">
                        <thead class="dark-table">
                            <tr>
                                <th width="30%" style="text-align:center;">مستحقات</th>
                                <th style="text-align:center;">المبلغ</th>
                                <th width="30%" style="text-align:center;">استقطاعات</th>
                                <th style="text-align:center;">المبلغ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>راتب ثابت</td>
                                <td>
                                    {{$user->currentMonthSalary($month,$year)}}
                                </td>
                                <td>
                                    خصومات إدارية
                                    <?php /*
                                    -
                                    <a class="btn btn-xs btn-primary" style="color:white;" data-toggle="modal" data-target="#managerDiscount{{$Employee->id}}">
                                        التفاصيل
                                    </a>

                                    <div class="modal fade" id="managerDiscount{{$Employee->id}}" tabindex="-1" role="dialog">
                                        <div class="modal-dialog " role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="smallModalLabel">سجل الخصومات الإدارية</h4>
                                                    <small><b>الموظف :</b> {{$Employee->name}}</small>
                                                </div>
                                                <div class="modal-body">
                                                    <table class="table table-bordered table-striped table-hover">
                                                        <thead>
                                                        <tr>
                                                            <th style="width:15px;">#</th>
                                                            <th>المبلغ</th>
                                                            <th>البيان</th>
                                                            <th>التاريخ</th>
                                                            <th>مسؤل التنفيذ</th>
                                                        </tr>
                                                        </thead>

                                                        <tbody>
                                                            <?php $Z = 1; ?>
                                                            <?php
                                                                $managerDiscounts = App\Models\SalariesDeductions::where('EmployeeID',$Employee['id'])
                                                                                                    ->where('Status','Done')
                                                                                                    ->whereIn('DeductionDate',$ThisPeriod)
                                                                                                    ->where('Type','managerDiscount')->get();
                                                            ?>
                                                            @foreach($managerDiscounts as $managerDiscount)
                                                                <?php
                                                                    $EmployeeData = App\Models\User::find($managerDiscount->EmployeeID);
                                                                ?>
                                                                <tr id="row_{{ $managerDiscount->id }}">
                                                                    <td><?php echo $Z; $Z++; ?></td>
                                                                    <td class="text-center" style="background:blue; color:#fff;">
                                                                        {{ $managerDiscount->Deduction }}
                                                                        @if(Auth::user()->hasRole('Admin'))
                                                                            <div class="clearfix"></div>
                                                                            <a class="btn btn-xs btn-danger" href="{{url('Dashboard/SalariesControl/'.$Employee['id'].'/Deductions/'.$managerDiscount['id'].'/Delete')}}">
                                                                                حذف
                                                                            </a>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        {{ $managerDiscount->Reason }}
                                                                    </td>
                                                                    <td>
                                                                        {{ date('j/m/Y',strtotime($managerDiscount->DeductionDate)) }}
                                                                        <br>
                                                                        {{date('h:i:sa',strtotime($managerDiscount->created_at))}}
                                                                    </td>
                                                                    <td>{{App\Models\User::find($managerDiscount->UID)->name}}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    */ ?>
                                </td>
                                <td>
                                    {{$user->monthDeductions()['management']}}
                                </td>
                            </tr>
                            <tr>
                                <td>إجمالي مبيعات</td>
                                <td>
                                    {{$user->mySales()}}
                                </td>
                                <td>
                                    سلفيات
                                    <?php /*
                                    -
                                    <a class="btn btn-xs btn-primary" style="color:white;" data-toggle="modal" data-target="#onAccountDiscount{{$Employee->id}}">
                                        التفاصيل
                                    </a>

                                    <div class="modal fade" id="onAccountDiscount{{$Employee->id}}" tabindex="-1" role="dialog">
                                        <div class="modal-dialog " role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="smallModalLabel">سجل السلفيات الإعتيادية</h4>
                                                    <small><b>الموظف :</b> {{$Employee->name}}</small>
                                                </div>
                                                <div class="modal-body">
                                                    <table class="table table-bordered table-striped table-hover">
                                                        <thead>
                                                        <tr>
                                                            <th style="width:15px;">#</th>
                                                            <th>المبلغ</th>
                                                            <th>البيان</th>
                                                            <th>ملاحظات</th>
                                                            <th>اليوم</th>
                                                            <th>التاريخ</th>
                                                            <th>مقدم الطلب</th>
                                                        </tr>
                                                        </thead>

                                                        <tbody>
                                                            <?php $Z = 1; ?>
                                                            <?php
                                                                $onAccountDiscounts = App\Models\SalariesDeductions::where('EmployeeID',$Employee['id'])
                                                                                                            ->where('Status','Done')
                                                                                                            ->whereIn('DeductionDate',$ThisPeriod)
                                                                                                            ->where('Type','onAccount')->get();
                                                            ?>
                                                            @foreach($onAccountDiscounts as $onAccountDiscount)
                                                                <?php
                                                                    $EmployeeData = App\Models\User::find($onAccountDiscount->EmployeeID);
                                                                ?>
                                                                <tr id="row_{{ $onAccountDiscount->id }}">
                                                                    <td><?php echo $Z; $Z++; ?></td>
                                                                    <td class="text-center" style="background:blue; color:#fff;">
                                                                        {{ $onAccountDiscount->Deduction }}
                                                                        @if(Auth::user()->hasRole('Admin'))
                                                                            <div class="clearfix"></div>
                                                                            <a class="btn btn-xs btn-danger" href="{{url('Dashboard/SalariesControl/'.$Employee['id'].'/Deductions/'.$onAccountDiscount['id'].'/Delete')}}">
                                                                                حذف
                                                                            </a>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        {{ $onAccountDiscount->Reason }}
                                                                    </td>
                                                                    <td>
                                                                        @if($onAccountDiscount->Status == 'Pending')
                                                                            <span class="btn btn-warning brn-xs">لم يتم إتخاذ قرار</span>
                                                                        @elseif($onAccountDiscount->Status == 'Rejected')
                                                                            <span class="btn btn-danger brn-xs">مرفوض</span>
                                                                        @elseif($onAccountDiscount->Status == 'Approved')
                                                                            <span class="btn btn-success brn-xs">مقبول</span>
                                                                        @elseif($onAccountDiscount->Status == 'Done')
                                                                            <span class="btn btn-success brn-xs">
                                                                                @if($onAccountDiscount->Type != 'discount')
                                                                                    تم الصرف
                                                                                @else
                                                                                    تم الإضافة إلى سجل الحسابات
                                                                                @endif
                                                                            </span>
                                                                        @else
                                                                            <span class="btn btn-danger brn-xs">تم الإلغاء</span>
                                                                        @endif

                                                                        @if($onAccountDiscount->Notes != '')
                                                                            <br>
                                                                            <b>ملاحظات: </b>
                                                                            {{$onAccountDiscount->Notes}}
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        {{ date('j/m/Y',strtotime($onAccountDiscount->DeductionDate)) }}
                                                                        <br>
                                                                        {{date('h:i:sa',strtotime($onAccountDiscount->updated_at))}}
                                                                    </td>
                                                                    <td>
                                                                        {{ date('j/m/Y',strtotime($onAccountDiscount->DeductionDate)) }}
                                                                        <br>
                                                                        {{date('h:i:sa',strtotime($onAccountDiscount->updated_at))}}
                                                                    </td>
                                                                    <td>{{App\Models\User::find($onAccountDiscount->UID)->name}}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    */ ?>
                                </td>
                                <td>
                                    {{$user->monthDeductions()['onAccount']}}
                                </td>
                            </tr>
                            <tr>
                                <td>عمولة مبيعات</td>
                                <td>
                                    {{$user->monthDeductions()['commission']}}
                                </td>
                                <td>
                                    الغياب
                                    <?php /*
                                    -
                                    <a class="btn btn-xs btn-primary" style="color:white;" data-toggle="modal" data-target="#Attendance{{$Employee->id}}">
                                        التفاصيل
                                    </a>
                                    */ ?>
                                </td>
                                <td>
                                    <?php /*
                                    <?php
                                        $attendDaysTillNow = App\Models\Attendance::where('EmployeeID',$Employee['id'])->whereIn('Date',$currentMonthSalaryData['monthDays'])->count();
                                        echo 'عدد أيام الحضور: '.$attendDaysTillNow;
                                        if (isset($_GET['month']) && isset($_GET['year'])) {
                                            $thatMonthDays = cal_days_in_month(CAL_GREGORIAN, $_GET['month'], $_GET['year']);
                                            $ThisEmployeeTrueAbsence = $thatMonthDays - $attendDaysTillNow - $currentMonthSalaryData['fridays'];
                                        } else {
                                            $ThisEmployeeTrueAbsence = date("d") - $attendDaysTillNow - $currentMonthSalaryData['fridays'];
                                        }

                                        $EmployeeAbsenceDeduction = round(($currentMonthSalaryData['currentSalary'] / $setting['MonthWorkingDays']->value), 2);

                                        echo '<br> أيام غياب: '.$ThisEmployeeTrueAbsence.' | خصم: '.($EmployeeAbsenceDeduction*$ThisEmployeeTrueAbsence);
                                        $ThisAccountTotalDiscount += $EmployeeAbsenceDeduction*$ThisEmployeeTrueAbsence;

                                        $DeductionForLateAbsence = App\Models\SalariesDeductions::where('Type','LateAbsence')
                                                                                        ->where('EmployeeID',$Employee['id'])
                                                                                        ->whereIn('DeductionDate',$currentMonthSalaryData['monthDays'])
                                                                                        ->sum('Deduction');
                                        $countDeductionForLateAbsence = App\Models\SalariesDeductions::where('Type','LateAbsence')
                                                                                        ->where('EmployeeID',$Employee['id'])
                                                                                        ->whereIn('DeductionDate',$currentMonthSalaryData['monthDays'])
                                                                                        ->count();
                                        echo '<br> ايام غياب للتأخير: '.$countDeductionForLateAbsence.' | خصم : '.round($DeductionForLateAbsence, 2);
                                        $ThisAccountTotalDiscount += round($DeductionForLateAbsence, 2);
                                        // echo '<br> الجمعات حتى الآن: '.count($fridays);
                                        // echo date("d");

                                        // echo date("t") - count($fridays);
                                    ?>
                                    */ ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    زيادة في ساعات العمل
                                    <?php /*
                                    -
                                    <a class="btn btn-xs btn-primary" style="color:white;" data-toggle="modal" data-target="#Attendance{{$Employee->id}}">
                                        التفاصيل
                                    </a>

                                    <div class="modal fade" id="Attendance{{$Employee->id}}" tabindex="-1" role="dialog">
                                        <div class="modal-dialog " role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="smallModalLabel">سجل الحضور والإنصراف</h4>
                                                    <small><b>الموظف :</b> {{$Employee->name}}</small>

                                                </div>
                                                <div class="modal-body">
                                                    <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>اليوم</th>
                                                                <th>حضور</th>
                                                                <th>إنصراف</th>
                                                                <th>دقائق التأخير</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $X = 1; $totalDiffs = 0; ?>
                                                            @foreach($currentMonthSalaryData['monthDays'] as $Day)
                                                                <?php $TodayAttendance = App\Models\Attendance::where('zk_id',$Employee->zk_id)
                                                                                                        ->where('Date',date('l d F Y',strtotime($Day)))
                                                                                                        ->first(); ?>
                                                                @if($TodayAttendance != '')
                                                                    <tr id="row_{{$TodayAttendance->id}}">
                                                                        <td>
                                                                            <?php
                                                                                echo $X; $X++;
                                                                            ?>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            {{ \App\Classes\ArabicDate::fooBar($TodayAttendance->Date) }}
                                                                        </td>
                                                                        <td class="text-center">
                                                                            {{ $TodayAttendance->CheckIn }}
                                                                        </td>
                                                                        <td class="text-center">
                                                                            {{ $TodayAttendance->CheckOut }}
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <?php
                                                                                $to_time = strtotime($TodayAttendance->Date." ".$TodayAttendance->CheckIn);
                                                                                $from_time = strtotime($TodayAttendance->Date." ".$Employee->WorkFrom);
                                                                                $timeDiff = round(abs($to_time - $from_time) / 60,2) - 10;
                                                                                if ($timeDiff > 0 && $to_time > $from_time) {
                                                                                    echo round(abs($to_time - $from_time) / 60,2) - 10;
                                                                                    echo " دقائق";
                                                                                    $totalDiffs += round(abs($to_time - $from_time) / 60,2) - 10;
                                                                                } else {
                                                                                    echo "0 دقائق";
                                                                                }

                                                                            ?>
                                                                        </td>
                                                                    </tr>
                                                                @else
                                                                    <tr id="row_0">
                                                                        <td>
                                                                            <?php
                                                                                echo $X; $X++;
                                                                            ?>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            {{ \App\Classes\ArabicDate::fooBar($Day) }}
                                                                        </td>
                                                                        <td colspan="3" class="text-center">
                                                                            غياب
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                            @endforeach
                                                            <tr>
                                                                <td colspan="3" class="text-center">عدد دقائق التأخير الإجمالية</td>
                                                                <td colspan="2" class="text-center">{{$totalDiffs}}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    */ ?>
                                </td>
                                <td>
                                    <?php /*
                                        $DeductionForExtraHours = App\Models\SalariesDeductions::where('Type','ExtraHours')
                                                                                        ->where('EmployeeID',$Employee['id'])
                                                                                        ->whereIn('DeductionDate',$currentMonthSalaryData['monthDays'])
                                                                                        ->sum('Deduction');
                                        $countDeductionForExtraHours = App\Models\SalariesDeductions::where('Type','ExtraHours')
                                                                                        ->where('EmployeeID',$Employee['id'])
                                                                                        ->whereIn('DeductionDate',$currentMonthSalaryData['monthDays'])
                                                                                        ->count();
                                        echo 'عدد ايام: '.$countDeductionForExtraHours.' | إضافي : '.round($DeductionForExtraHours, 2);
                                        $ThisAccountTotalAddons += round($DeductionForExtraHours, 2);
                                        */
                                    ?>
                                </td>
                                <td>
                                    تأخير حضور
                                    <?php /*
                                    -
                                    <a class="btn btn-xs btn-primary" style="color:white;" data-toggle="modal" data-target="#Attendance{{$Employee->id}}">
                                        التفاصيل
                                    </a>
                                    */ ?>
                                </td>
                                <td>
                                    <?php /*
                                        $DeductionForLate = App\Models\SalariesDeductions::where('Type','Late')
                                                                                    ->where('EmployeeID',$Employee['id'])
                                                                                    ->whereIn('DeductionDate',$currentMonthSalaryData['monthDays'])
                                                                                    ->sum('Deduction');
                                        $countDeductionForLate = App\Models\SalariesDeductions::where('Type','Late')
                                                                                    ->where('EmployeeID',$Employee['id'])
                                                                                    ->whereIn('DeductionDate',$currentMonthSalaryData['monthDays'])
                                                                                    ->count();
                                        echo 'عدد الأيام: '.$countDeductionForLate.' | خصم : '.round($DeductionForLate, 2);
                                        $ThisAccountTotalDiscount += round($DeductionForLate, 2);
                                        */ ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    مكافآت
                                    <?php /*
                                    -
                                    <a class="btn btn-xs btn-primary" style="color:white;" data-toggle="modal" data-target="#monthlyReward{{$Employee->id}}">
                                        التفاصيل
                                    </a>

                                    <div class="modal fade" id="monthlyReward{{$Employee->id}}" tabindex="-1" role="dialog">
                                        <div class="modal-dialog " role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="smallModalLabel">سجل المكافآت</h4>
                                                    <small><b>الموظف :</b> {{$Employee->name}}</small>
                                                </div>
                                                <div class="modal-body">
                                                    <table class="table table-bordered table-striped table-hover">
                                                        <thead>
                                                        <tr>
                                                            <th style="width:15px;">#</th>
                                                            <th>المبلغ</th>
                                                            <th>البيان</th>
                                                            <th>التاريخ</th>
                                                            <th>مسؤل التنفيذ</th>
                                                        </tr>
                                                        </thead>

                                                        <tbody>
                                                            <?php $Z = 1; ?>
                                                            <?php
                                                                $monthlyRewards = App\Models\SalariesDeductions::where('EmployeeID',$Employee['id'])
                                                                                                    ->where('Status','Done')
                                                                                                    ->whereIn('DeductionDate',$currentMonthSalaryData['monthDays'])
                                                                                                    ->whereIn('Type',['monthlyReward'])->get();
                                                            ?>
                                                            @foreach($monthlyRewards as $monthlyReward)
                                                                <?php
                                                                    $EmployeeData = App\Models\User::find($monthlyReward->EmployeeID);
                                                                ?>
                                                                <tr id="row_{{ $monthlyReward->id }}">
                                                                    <td><?php echo $Z; $Z++; ?></td>
                                                                    <td class="text-center" style="background:blue; color:#fff;">
                                                                        {{ $monthlyReward->Deduction }}
                                                                        @if(Auth::user()->hasRole('Admin'))
                                                                            <div class="clearfix"></div>
                                                                            <a class="btn btn-xs btn-danger" href="{{url('Dashboard/SalariesControl/'.$Employee['id'].'/Deductions/'.$monthlyReward['id'].'/Delete')}}">
                                                                                حذف
                                                                            </a>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        {{ $monthlyReward->Reason }}
                                                                    </td>
                                                                    <td>
                                                                        {{ date('j/m/Y',strtotime($monthlyReward->DeductionDate)) }}
                                                                        <br>
                                                                        {{date('h:i:sa',strtotime($monthlyReward->updated_at))}}
                                                                    </td>
                                                                    <td>{{App\Models\User::find($monthlyReward->UID)->name}}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    */ ?>
                                </td>
                                <td>
                                    {{$user->monthDeductions()['reward']}}
                                </td>
                                <td style="background-color:#666;color:#fff;text-align:center;">إجمالي مستحقات</td>
                                <td style="background-color:#666;color:#fff;text-align:center;">
                                    {{$user->monthSalary($month,$year)['plus']}}
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td style="background-color:#666;color:#fff;text-align:center;">إجمالي راتب مستلم</td>
                                <td style="background-color:#666;color:#fff;text-align:center;">
                                    {{$user->monthSalary($month,$year)['delivered']}}
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td style="background-color:#666;color:#fff;text-align:center;">إجمالي مستقطعات</td>
                                <td style="background-color:#666;color:#fff;text-align:center;">
                                    {{$user->monthSalary($month,$year)['minus']}}
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td style="background-color:#666;color:#fff;text-align:center;">صافي الراتب</td>
                                <td style="background-color:#666;color:#fff;text-align:center;">
                                    {{$user->monthSalary($month,$year)['net']}}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <!-- Bordered table end -->

@stop

@section('scripts')
    <script src="{{asset('AdminAssets/app-assets/js/scripts/pages/modal-add-role.js')}}"></script>
@stop
