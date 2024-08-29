<?php
function daysForChart($month = null, $year = null)
{
    $thisMonthDaysChart = '';
    $thisMonthDaysCount = cal_days_in_month(CAL_GREGORIAN,$month,$year);
    for ($i=1; $i <= $thisMonthDaysCount; $i++) {
        $thisMonthDaysChart .= $i;
        if ($i<$thisMonthDaysCount) {
            $thisMonthDaysChart .= ',';
        }
    }
    return $thisMonthDaysChart;
}

function monthsForThisYear($year = null)
{
    $monthsArray = [];
    for ($i=1; $i <= 12; $i++) {
        $thisMonth = str_pad($i, 2, '0', STR_PAD_LEFT);
        if ($year == date('Y')) {
            if ($thisMonth <= date('m')) {
                $monthsArray[] = $thisMonth;
            }
        } else {
            $monthsArray[] = $thisMonth;
        }

    }
    return $monthsArray;
}
function allMonthsArray($year = null)
{
    $StartDate = strtotime("Dec 2020");
    $StopDate = strtotime(date('M Y'));
    $current = $StartDate;
    $ret = array();

    while( $current<$StopDate ){

        $next = date('Y-M-01', $current) . "+1 month";
        $current = strtotime($next);
        $ret[] = date('Y-M-01', $current);
    }

    return array_reverse($ret);
}


function expensesForChart($branch = 'all', $month = null, $year = null)
{
    $ExpensesChart = '';
    $thisMonthDaysCount = cal_days_in_month(CAL_GREGORIAN,$month,$year);
    for ($i=1; $i <= $thisMonthDaysCount; $i++) {
        $day = $year.'-'.$month.'-'.str_pad($i, 2, '0', STR_PAD_LEFT);
        if ($branch == 'all') {
            $dayExpenses = App\Models\Expenses::whereNotIn('Type',['transfeerToAnother'])->where('ExpenseDate',$day)->sum('Expense');
        } else {
            $dayExpenses = App\Models\Expenses::whereNotIn('Type',['transfeerToAnother'])->where('branch_id',$branch)->where('ExpenseDate',$day)->sum('Expense');
        }
        $ExpensesChart .= $dayExpenses;
        if ($i<$thisMonthDaysCount) {
            $ExpensesChart .= ',';
        }
    }
    return $ExpensesChart;
}

function revenueForChart($branch = 'all',$month = null, $year = null)
{
    $RevenueChart = '';
    $thisMonthDaysCount = cal_days_in_month(CAL_GREGORIAN,$month,$year);
    for ($i=1; $i <= $thisMonthDaysCount; $i++) {
        $day = $year.'-'.$month.'-'.str_pad($i, 2, '0', STR_PAD_LEFT);
        if ($branch == 'all') {
            $dayRevenue = App\Models\Revenues::whereNotIn('Type',['transfeerFromAnother'])->where('Date',$day)->sum('amount');
        } else {
            $dayRevenue = App\Models\Revenues::whereNotIn('Type',['transfeerFromAnother'])->where('branch_id',$branch)->where('Date',$day)->sum('amount');
        }
        $RevenueChart .= $dayRevenue;
        if ($i<$thisMonthDaysCount) {
            $RevenueChart .= ',';
        }
    }
    return $RevenueChart;
}
function expensesTotals($branch = 'all',$month = null, $year = null)
{
    $totalManagmentExpenses = App\Models\Expenses::whereNotIn('Type',['withdrawal','transfeerToAnother'])
                                            ->where('month',$month)
                                            ->where('year',$year);
    $totalSalariesExpenses = App\Models\SalaryRequest::where('month',$month)
                                                ->where('year',$year);
    $totalWithdrawalExpenses = App\Models\Expenses::where('Type','withdrawal')
                                            ->where('month',$month)
                                            ->where('year',$year);

    $yearManagmentExpenses = App\Models\Expenses::whereNotIn('Type',['withdrawal','transfeerToAnother'])
                                            ->where('year',$year);
    $yearSalariesExpenses = App\Models\SalaryRequest::where('year',$year);
    $yearWithdrawalExpenses = App\Models\Expenses::where('Type','withdrawal')
                                            ->where('year',$year);

    if ($branch != 'all') {
        $totalManagmentExpenses = $totalManagmentExpenses->where('branch_id',$branch);
        $totalSalariesExpenses = $totalSalariesExpenses->where('branch_id',$branch);
        $totalWithdrawalExpenses = $totalWithdrawalExpenses->where('branch_id',$branch);

        $yearManagmentExpenses = $yearManagmentExpenses->where('branch_id',$branch);
        $yearSalariesExpenses = $yearSalariesExpenses->where('branch_id',$branch);
        $yearWithdrawalExpenses = $yearWithdrawalExpenses->where('branch_id',$branch);
    }

    $totalManagmentExpenses = $totalManagmentExpenses->sum('Expense');
    $totalSalariesExpenses = $totalSalariesExpenses->sum('DeliveredSalary');
    $totalWithdrawalExpenses = $totalWithdrawalExpenses->sum('Expense');

    $yearManagmentExpenses = $yearManagmentExpenses->sum('Expense');
    $yearSalariesExpenses = $yearSalariesExpenses->sum('DeliveredSalary');
    $yearWithdrawalExpenses = $yearWithdrawalExpenses->sum('Expense');

    return [
        'management' => $totalManagmentExpenses,
        'salaries' => $totalSalariesExpenses,
        'withdrawal' => $totalWithdrawalExpenses,
        'total' => $totalManagmentExpenses + $totalSalariesExpenses + $totalWithdrawalExpenses,
        'yearTotal' => $yearManagmentExpenses + $yearSalariesExpenses + $yearWithdrawalExpenses
    ];
}
function revenuesTotals($branch = 'all',$month = null, $year = null)  
{

    $monthRevenues = App\Models\Revenues::where('month',$month)->whereNotIn('Type', ['deposits','transfeerFromAnother'])->sum('amount');

    $dayRevenues = App\Models\Revenues::whereDate('created_at',Carbon\Carbon::today())->whereNotIn('Type', ['deposits','transfeerFromAnother'])->sum('amount');

    $totalRevenues = App\Models\Revenues::whereNotIn('Type',['transfeerFromAnother'])
                                            ->where('month',$month)
                                            ->where('year',$year);

    $totalTD = App\Models\Revenues::whereNotIn('Type',['transfeerFromAnother','deposits'])
                                            ->where('month',$month)
                                            ->where('year',$year);

    $totalDeposits = App\Models\Revenues::where('Type','deposits')
                                            ->where('month',$month)
                                            ->where('year',$year);

    $yearRevenues = App\Models\Revenues::whereNotIn('Type',['transfeerFromAnother'])->where('year',$year);
    $yearDeposits = App\Models\Revenues::where('Type','deposits')->where('year',$year);

    if ($branch != 'all') {
        $totalRevenues = $totalRevenues->where('branch_id',$branch);
        $totalDeposits = $totalDeposits->where('branch_id',$branch);

        $yearRevenues = $yearRevenues->where('branch_id',$branch);
        $yearDeposits = $yearDeposits->where('branch_id',$branch);
    }

    $totalRevenues = $totalRevenues->sum('amount');
    $totalDeposits = $totalDeposits->sum('amount');
    $totalTD = $totalTD->sum('amount');

    $yearRevenues = $yearRevenues->sum('amount');
    $yearDeposits = $yearDeposits->sum('amount');

    return [
        'revenues' => $totalRevenues,
        'deposits' => $totalDeposits,
        'revenuesTD' => $totalTD,
        'totalTD' => $totalTD + $totalDeposits ,
        'total' => $totalRevenues + $totalDeposits,
        'yearTotal' => $yearRevenues + $yearDeposits,
        'monthTotal' => $monthRevenues ,
        'dayRevenues' => $dayRevenues ,
    ];
}
function teamFollowupsStats($leader,$month = null, $year = null)
{
    $thisMonth = date('m');
    $thisYear = date('Y');
    if ($month != null) {
        $thisMonth = $month;
    }
    if ($year != null) {
        $thisYear = $year;
    }
    $teamMembers[] = $leader;
    $myTeam = App\Models\User::where('status','Active')->where('leader',$leader)->get();
    foreach ($myTeam as $myTeamKey => $myTeamV) {
        $teamMembers[] = $myTeamV['id'];
    }
    $followUps = App\Models\ClientFollowUps::where('status','Done')
                                ->where('month',$month)
                                ->where('year',$year)
                                ->whereIn('UID',$teamMembers)->get();
    $list = [
        'Mail' => $followUps->where('contactingType','Mail')->count(),
        'Call' => $followUps->where('contactingType','Call')->count(),
        'InVisit' => $followUps->where('contactingType','InVisit')->count(),
        'OutVisit' => $followUps->where('contactingType','OutVisit')->count(),
        'UnitVisit' => $followUps->where('contactingType','UnitVisit')->count()
    ];

    return $list;
}
function teamMonthFollowupsStats($leader,$month = null, $year = null)
{
    $numbers = [
        'Mail' => '',
        'Call' => '',
        'InVisit' => '',
        'OutVisit' => '',
        'UnitVisit' => ''
    ];
    $thisMonthDaysCount = cal_days_in_month(CAL_GREGORIAN,$month,$year);
    $teamMembers[] = $leader;
    $myTeam = App\Models\User::where('status','Active')->where('leader',$leader)->get();
    foreach ($myTeam as $myTeamKey => $myTeamV) {
        $teamMembers[] = $myTeamV['id'];
    }
    for ($i=1; $i <= $thisMonthDaysCount; $i++) {
        $day = $year.'-'.$month.'-'.$i;
        $followUps = App\Models\ClientFollowUps::where('status','Done')
                                    ->where('contactingDateTime',$day)
                                    ->where('year',$year)
                                    ->whereIn('UID',$teamMembers)->get();
        $emails = $followUps->where('contactingType','Mail')->count();
        $numbers['Mail'] .= $emails;
        if ($i<$thisMonthDaysCount) {
            $numbers['Mail'] .= ',';
        }

        $Calls = $followUps->where('contactingType','Call')->count();
        $numbers['Call'] .= $Calls;
        if ($i<$thisMonthDaysCount) {
            $numbers['Call'] .= ',';
        }

        $InVisits = $followUps->where('contactingType','InVisit')->count();
        $numbers['InVisit'] .= $InVisits;
        if ($i<$thisMonthDaysCount) {
            $numbers['InVisit'] .= ',';
        }

        $OutVisits = $followUps->where('contactingType','OutVisit')->count();
        $numbers['OutVisit'] .= $OutVisits;
        if ($i<$thisMonthDaysCount) {
            $numbers['OutVisit'] .= ',';
        }

        $UnitVisits = $followUps->where('contactingType','UnitVisit')->count();
        $numbers['UnitVisit'] .= $UnitVisits;
        if ($i<$thisMonthDaysCount) {
            $numbers['UnitVisit'] .= ',';
        }
    }
    return $numbers;
}
function branchFollowupsStats($branch,$month = null, $year = null)
{
    $thisMonth = date('m');
    $thisYear = date('Y');
    if ($month != null) {
        $thisMonth = $month;
    }
    if ($year != null) {
        $thisYear = $year;
    }
    if ($branch == 'all') {
        $followUps = App\Models\ClientFollowUps::where('status','Done')
                                    ->where('month',$month)
                                    ->where('year',$year)->get();
    } else {
        $branchMembers[] = $branch;
        $mybranch = App\Models\User::where('status','Active')->where('branch_id',$branch)->get();
        foreach ($mybranch as $mybranchKey => $mybranchV) {
            $branchMembers[] = $mybranchV['id'];
        }
        $followUps = App\Models\ClientFollowUps::where('status','Done')
                                    ->where('month',$month)
                                    ->where('year',$year)
                                    ->whereIn('UID',$branchMembers)->get();
    }

    $list = [
        'Mail' => $followUps->where('contactingType','Mail')->count(),
        'Call' => $followUps->where('contactingType','Call')->count(),
        'InVisit' => $followUps->where('contactingType','InVisit')->count(),
        'OutVisit' => $followUps->where('contactingType','OutVisit')->count(),
        'UnitVisit' => $followUps->where('contactingType','UnitVisit')->count()
    ];

    return $list;
}
function branchMonthFollowupsStats($branch,$month = null, $year = null)
{
    $numbers = [
        'Mail' => '',
        'Call' => '',
        'InVisit' => '',
        'OutVisit' => '',
        'UnitVisit' => ''
    ];
    $thisMonthDaysCount = cal_days_in_month(CAL_GREGORIAN,$month,$year);
    if ($branch == 'all') {
        $mybranch = App\Models\User::where('status','Active')->get();
        foreach ($mybranch as $mybranchKey => $mybranchV) {
            $branchMembers[] = $mybranchV['id'];
        }
    }else {
        $branchMembers[] = $branch;
        $mybranch = App\Models\User::where('status','Active')->where('branch_id',$branch)->get();
        foreach ($mybranch as $mybranchKey => $mybranchV) {
            $branchMembers[] = $mybranchV['id'];
        }
    }
    for ($i=1; $i <= $thisMonthDaysCount; $i++) {
        $day = $year.'-'.$month.'-'.$i;
        $followUps = App\Models\ClientFollowUps::where('status','Done')
                                    ->where('contactingDateTime',$day)
                                    ->where('year',$year)
                                    ->whereIn('UID',$branchMembers)->get();
        $emails = $followUps->where('contactingType','Mail')->count();
        $numbers['Mail'] .= $emails;
        if ($i<$thisMonthDaysCount) {
            $numbers['Mail'] .= ',';
        }

        $Calls = $followUps->where('contactingType','Call')->count();
        $numbers['Call'] .= $Calls;
        if ($i<$thisMonthDaysCount) {
            $numbers['Call'] .= ',';
        }

        $InVisits = $followUps->where('contactingType','InVisit')->count();
        $numbers['InVisit'] .= $InVisits;
        if ($i<$thisMonthDaysCount) {
            $numbers['InVisit'] .= ',';
        }

        $OutVisits = $followUps->where('contactingType','OutVisit')->count();
        $numbers['OutVisit'] .= $OutVisits;
        if ($i<$thisMonthDaysCount) {
            $numbers['OutVisit'] .= ',';
        }

        $UnitVisits = $followUps->where('contactingType','UnitVisit')->count();
        $numbers['UnitVisit'] .= $UnitVisits;
        if ($i<$thisMonthDaysCount) {
            $numbers['UnitVisit'] .= ',';
        }
    }
    return $numbers;
}
