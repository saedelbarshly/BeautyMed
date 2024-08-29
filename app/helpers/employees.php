<?php
function userCan($ability)
{
    if (auth()->user()->role == 1 || auth()->user()->hisRole->canDo($ability) == 1) {
        return true;
    }
    return false;
}
function jobTitles()
{
    $titles = [
        'مدير نظام', 'مدير الموارد البشرية',
        'محاسب', 'مدير مبيعات', 'ممثل مبيعات', 'قائد فريق عمل',
        'خبير مبيعات', 'موظف', 'عامل'
    ];
    return $titles;
}
function leadersList()
{
    $list = [];
    $list[] = 'قائد فريق عمل';

    $users = App\Models\User::where('leader','1')->get();
    foreach ($users as $key => $value) {
        $list[$value['id']] = $value['name'];
    }

    return $list;
}
function deductionTypesArray($lang)
{
    $arr = [
        'management' => [
            'name_en' => '',
            'name_ar' => 'خصم إداري',
            'type' => 'minus'
        ],
        'absence' => [
            'name_en' => '',
            'name_ar' => 'خصم للغياب',
            'type' => 'minus'
        ],
        'late' => [
            'name_en' => '',
            'name_ar' => 'خصم للتأخير',
            'type' => 'minus'
        ],
        'early' => [
            'name_en' => '',
            'name_ar' => 'خصم للإنصراف المبكر',
            'type' => 'minus'
        ],
        'onAccount' => [
            'name_en' => '',
            'name_ar' => 'سلفة',
            'type' => 'minus'
        ],
        'overtime' => [
            'name_en' => '',
            'name_ar' => 'اوفر تايم',
            'type' => 'plus'
        ],
        'commission' => [
            'name_en' => '',
            'name_ar' => 'عمولة',
            'type' => 'plus'
        ],
        'incentive' => [
            'name_en' => '',
            'name_ar' => 'حافز',
            'type' => 'plus'
        ],
        'reward' => [
            'name_en' => '',
            'name_ar' => 'مكافأة',
            'type' => 'plus'
        ]
    ];
    $list = [];
    foreach ($arr as $key => $value) {
        $list[$key] = $value['name_'.$lang];
    }
    return [
            'details' => $arr,
            'list'=>$list
        ];
}
function getActiveUsersList()
{
    $users = App\Models\User::where('status','Active');
    if (!userCan('employees_account_view')) {
        $users = $users->where('branch_id',auth()->user()->branch_id);
    }
    $users = $users->orderBy('name','asc')->pluck('name','id')->all();
    return $users;
}
function salariesStats($branch = 'all', $month = null, $year = null)
{
    if ($branch == 'all') {
        $users = App\Models\User::where('status','Active')->get();
    } else {
        $users = App\Models\User::where('branch_id',$branch)->where('status','Active')->get();
    }
    $list = [
        'basic' => 0,
        'plus' => 0,
        'minus' => 0,
        'delivered' => 0,
        'net' => 0
    ];
    foreach ($users as $user) {
        $list['basic'] += $user->monthSalary($month, $year)['basic'];
        $list['plus'] += $user->monthSalary($month, $year)['plus'];
        $list['minus'] += $user->monthSalary($month, $year)['minus'];
        $list['delivered'] += $user->monthSalary($month, $year)['delivered'];
        $list['net'] += $user->monthSalary($month, $year)['net'];
    }
    return $list;
}
function vacationTypesArray($lang)
{
    $list = [
        'ar' => [
            'normal' => 'إعتيادية',
            'emergency' => 'عارضه',
            'sick' => 'مرضي'
        ],
        'en' => [
            'normal' => 'إعتيادية',
            'emergency' => 'عارضه',
            'sick' => 'مرضي'
        ]
    ];
    return $list[$lang];
}
function attendancePermissions($lang)
{
    $list = [
        'ar' => [
            'late' => 'تأخير حضور',
            'early' => 'انصراف مبكر'
        ],
        'en' => [
            'late' => 'تأخير حضور',
            'early' => 'انصراف مبكر'
        ]
    ];
    return $list[$lang];
}
function getDatesFromRange($start, $end, $format = 'Y-m-d') {
    $array = array();
    $interval = new \DateInterval('P1D');

    $realEnd = new \DateTime($end);
    $realEnd->add($interval);

    $period = new \DatePeriod(new \DateTime($start), $interval, $realEnd);

    foreach($period as $date) {
        $array[] = $date->format($format);
    }

    return $array;
}
