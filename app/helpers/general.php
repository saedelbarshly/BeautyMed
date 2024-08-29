<?php

use App\Models\Appointment;
use App\Models\Clients;
use App\Models\Reservation;
use Carbon\Carbon;

function DayMonthOnly($your_date)
{
    $months = array("Jan" => "يناير",
                     "Feb" => "فبراير",
                     "Mar" => "مارس",
                     "Apr" => "أبريل",
                     "May" => "مايو",
                     "Jun" => "يونيو",
                     "Jul" => "يوليو",
                     "Aug" => "أغسطس",
                     "Sep" => "سبتمبر",
                     "Oct" => "أكتوبر",
                     "Nov" => "نوفمبر",
                     "Dec" => "ديسمبر");
    //$your_date = date('y-m-d'); // The Current Date
    $en_month = date("M", strtotime($your_date));
    foreach ($months as $en => $ar) {
        if ($en == $en_month) { $ar_month = $ar; }
    }

    $find = array ("Sat", "Sun", "Mon", "Tue", "Wed" , "Thu", "Fri");
    $replace = array ("السبت", "الأحد", "الإثنين", "الثلاثاء", "الأربعاء", "الخميس", "الجمعة");
    $ar_day_format = date("D", strtotime($your_date)); // The Current Day
    $ar_day = str_replace($find, $replace, $ar_day_format);

    header('Content-Type: text/html; charset=utf-8');
    $standard = array("0","1","2","3","4","5","6","7","8","9");
    $eastern_arabic_symbols = array("٠","١","٢","٣","٤","٥","٦","٧","٨","٩");
    $current_date = $ar_day.' '.date('d', strtotime($your_date)).' '.$ar_month.' '.date('Y', strtotime($your_date));
    $arabic_date = str_replace($standard , $eastern_arabic_symbols , $current_date);

    return $arabic_date;
}
function arabicMonth($your_date)
{
    $months = array("Jan" => "يناير",
                     "Feb" => "فبراير",
                     "Mar" => "مارس",
                     "Apr" => "أبريل",
                     "May" => "مايو",
                     "Jun" => "يونيو",
                     "Jul" => "يوليو",
                     "Aug" => "أغسطس",
                     "Sep" => "سبتمبر",
                     "Oct" => "أكتوبر",
                     "Nov" => "نوفمبر",
                     "Dec" => "ديسمبر");
    //$your_date = date('y-m-d'); // The Current Date
    $en_month = date("M", strtotime($your_date));
    foreach ($months as $en => $ar) {
        if ($en == $en_month) { $ar_month = $ar; }
    }
    return $ar_month;
}
function getTime($time)
{
    $time = '';
    $time .= date('H:m',strtotime($time));
    $time .= date('a',strtotime($time)) == 'am' ? ' ص ' : 'م';
    return $time;
}
function reservationsList()
{
    $reservations = Reservation::where('status',0)->where( 'date', '=', date('y-m-d'))->get();
    return $reservations ;
}

function reservationList($clientId)
{
    $reservations = App\Models\Reservation::where('client_id','!=',$clientId)->pluck('id')->all();
    return $reservations ;
}


function appointmentsList($date)
{
    // $days   = [];
    // $period = new \DatePeriod(
    //     new \DateTime(), // Start date of the period
    //     new \DateInterval('P1D'), // Define the intervals as Periods of 1 Day
    //     15 // Apply the interval 6 times on top of the starting date
    // );

    // foreach ($period as $day)
    // {
    //     $days[] = $day->format('Y-m-d');
    // }
    $appointments = App\Models\Appointment::whereIn('date',[$date])->get();
    return $appointments ;
}

function pulsesInMonth()
{
    $daysCount   = cal_days_in_month(CAL_GREGORIAN,date('m'),date('Y'));
    $days =[];
    for ($i=1; $i <= $daysCount; $i++) {
        $days[] = date('Y').'-'.date('m').'-'.$i;
    }
    $appointments = App\Models\Reservation::whereIn('date',$days)->get();
    $arr = [
        'used' => 0,
        'total' => 0,
    ];
    foreach ($appointments as $key => $value) {
        $arr['used'] += $value->totals()['usedPulses'];
        $arr['total'] += $value->totals()['totalPulses'];
    }
    return $arr ;
}


function clientsMonth()
{
    $daysCount   = cal_days_in_month(CAL_GREGORIAN,date('m'),date('Y'));
    $days =[];
    for ($i=1; $i <= $daysCount; $i++) {
        $days[] = date('Y').'-'.date('m').'-'.$i;
    }
    $clients = Clients::whereIn('date',$days)->count();
    return $clients ;
}


function panelLangMenu()
{
    $list = [];
    $locales = Config::get('app.locales');

    if (Session::get('Lang') != 'ar') {
        $list[] = [
            'flag' => 'ae',
            'text' => trans('common.lang1Name'),
            'lang' => 'ar'
        ];
    } else {
        $selected = [
            'flag' => 'ae',
            'text' => trans('common.lang1Name'),
            'lang' => 'ar'
        ];
    }
    if (Session::get('Lang') != 'en') {
        $list[] = [
            'flag' => 'us',
            'text' => trans('common.lang2Name'),
            'lang' => 'en'
        ];
    } else {
        $selected = [
            'flag' => 'us',
            'text' => trans('common.lang2Name'),
            'lang' => 'en'
        ];
    }
    if (Session::get('Lang') != 'fr') {
        $list[] = [
            'flag' => 'fr',
            'text' => trans('common.lang3Name'),
            'lang' => 'fr'
        ];
    } else {
        $selected = [
            'flag' => 'fr',
            'text' => trans('common.lang3Name'),
            'lang' => 'fr'
        ];
    }

    return [
        'selected' => $selected,
        'list' => $list
    ];
}

function getCssFolder()
{
    return trans('common.cssFile');
}

function getCountriesList($lang,$value)
{
    $list = [];
    $countries = App\Models\Countries::orderBy('name_'.$lang,'asc')->get();
    foreach ($countries as $country) {
        $list[$country[$value]] = $country['name_'.$lang] != '' ? $country['name_'.$lang] : $country['name_en'];
    }
    return $list;
}

function getRolesList($lang,$value,$guard = null)
{
    $list = [];
    if ($guard == null) {
        $roles = App\Models\roles::orderBy('name_'.$lang,'asc')->get();
    } else {
        $roles = App\Models\roles::where('guard',$guard)->orderBy('name_'.$lang,'asc')->get();
    }
    foreach ($roles as $role) {
        $list[$role[$value]] = $role['name_'.$lang] != '' ? $role['name_'.$lang] : $role['name_ar'];
    }
    return $list;
}

function getSectionsList($lang)
{
    $list = [];
    $sections = App\Sections::where('main_section','0')->orderBy('name_'.$lang,'asc')->get();
    foreach ($sections as $section) {
        $list[$section['id']] = $section['name_'.$lang];
        if ($section->subSections != '') {
            foreach ($section->subSections as $key => $value) {
                $list[$value['id']] = ' - '.$value['name_'.$lang];
            }
        }
    }
    return $list;
}

function getSettingValue($key)
{
    $value = '';
    $setting = App\Models\Settings::where('key',$key)->first();
    if ($setting != '') {
        $value = $setting['value'];
    }
    return $value;
}

function getSettingImageLink($key)
{
    $link = '';
    $setting = App\Models\Settings::where('key',$key)->first();
    if ($setting != '') {
        if ($setting['value'] != '') {
            $link = asset('uploads/settings/'.$setting['value']);
        }
    }
    return $link;
}

function getSettingImageValue($key)
{
    $value = '';
    if (getSettingImageLink($key) != '') {
        $value .= '<div class="row"><div class="col-12">';
        $value .= '<span class="avatar mb-2">';
        $value .= '<img class="round" src="'.getSettingImageLink($key).'" alt="avatar" height="90" width="90">';
        $value .= '</span>';
        $value .= '</div>';
        $value .= '<div class="col-12">';
        $value .= '<a href="'.route('admin.settings.deletePhoto',['key'=>$key]).'"';
        $value .= ' class="btn btn-danger btn-sm">'.trans("common.delete").'</a>';
        $value .= '</div></div>';
    }
    return $value;
}

function checkUserForApi($lang, $user_id)
{
    if ($lang == '') {
        $resArr = [
            'status' => 'faild',
            'message' => trans('api.pleaseSendLangCode'),
            'data' => []
        ];
        return response()->json($resArr);
    }
    $user = App\Models\User::find($user_id);
    if ($user == '') {
        return response()->json([
            'status' => 'faild',
            'message' => trans('api.thisUserDoesNotExist'),
            'data' => []
        ]);
    }

    return true;
}

function salesStatistics7Days()
{
    $date = \Carbon\Carbon::today()->subDays(7);
    $date7before = new \Carbon\Carbon($date);
    $date7before = $date7before->subDays(7);
    $ClientsCount = App\Models\User::where('role', '3')->where('created_at', '>=', $date)->count();

    return [
        'ClientsCount' => number_format($ClientsCount),
    ];
}

function branchesList()
{
    $branches = App\Models\Branches::orderBy('name','asc')->pluck('name','id')->all();
    return $branches;
}

function areasList()
{
    $areas = App\Models\Area::orderBy('name','asc')->pluck('name','id')->all();
    return $areas;
}

function areasListName($id)
{
    $area = App\Models\Area::orderBy('name','asc')->find($id);
    return $area->name;
}

function serviceList()
{
    $services = App\Models\Service::orderBy('name','asc')->pluck('name','id')->all();
    return $services;
}

function servicesList()
{
    $services = App\Models\Service::orderBy('name','asc')->get();
    return $services;
}


function offersList()
{
    $offers = App\Models\Offer::orderBy('name','asc')->get();
    return $offers;
}


function machinesList()
{
    $machines = App\Models\Machine::orderBy('name','asc')->pluck('name','id')->all();
    return $machines;
}


function managementsList()
{
    $managements = App\Models\Managements::orderBy('name','asc')->pluck('name','id')->all();
    return $managements;
}
function jobsList()
{
    $jobs = App\Models\Jobs::orderBy('name','asc')->pluck('name','id')->all();
    return $jobs;
}

function safesList()
{
    $safes = [];
    if (userCan('expenses_view') || userCan('employees_account_pay_salary')) {
        $safes = App\Models\SafesBanks::orderBy('Title','asc')->pluck('Title','id')->all();
    } elseif (userCan('expenses_view_branch')) {
        $safes = App\Models\SafesBanks::where('branch_id',auth()->user()->branch_id)->orderBy('Title','asc')->pluck('Title','id')->all();
    }
    return $safes;
}
function citiesList()
{
    $cities = App\Models\Cities::orderBy('name','asc')->pluck('name','id')->all();
    return $cities;
}
function companiesList()
{
    $comapnies = App\ProjectCompanies::orderBy('name','asc')->pluck('name','id')->all();
    return $comapnies;
}
function locationsList()
{
    $locations = App\ProjectLocations::orderBy('name','asc')->pluck('name','id')->all();
    return $locations;
}
function projectsList()
{
    $projects = App\Projects::orderBy('name','asc')->pluck('name','id')->all();
    return ['None' => 'بدون مشروع'] + $projects;
}
function unitsList()
{
    $units = App\Units::orderBy('name','asc')->pluck('name','id')->all();
    return $units;
}
function doctorsList()
{
    $doctors = App\Models\User::where('role',2)->pluck('name','id')->all();
    return $doctors;
}

function clientList()
{
    $clients = App\Models\Clients::pluck('name','id')->all();
    return $clients;
}

function usersList()
{
    $users = App\Models\User::pluck('name','id')->all();
    return $users;
}

function revenuesList($id)
{
    $revenues = App\Models\Revenues::where('reservation_id',$id)->orderBy('id','desc')->get();
    return $revenues;
}

function agentsList()
{
    $agents = App\Models\User::where('status','Active')->orderBy('name','asc')->pluck('name','id')->all();
    return ['None' => 'تابع للشركة'] + $agents;
}
function agentsListForSearch()
{
    $agents = App\Models\User::where('status','Active')->orderBy('name','asc')->pluck('name','id')->all();
    if (userCan('followups_view_team')) {
        $agents = [auth()->user()->id => auth()->user()->name] + App\Models\User::where('status','Active')
                                                                        ->where('leader',auth()->user()->id)
                                                                        ->orderBy('name','asc')
                                                                        ->pluck('name','id')
                                                                        ->all();
    }
    if (userCan('followups_view_branch')) {
        $agents = App\Models\User::where('status','Active')->where('branch_id',auth()->user()->id)
                                                    ->orderBy('name','asc')
                                                    ->pluck('name','id')
                                                    ->all();
    }
    return $agents;
}
function agentsVisitList()
{
    $agents = App\Models\User::where('status','Active')->orderBy('name','asc')->pluck('name','id')->all();
    if (userCan('clients_view_team')) {
        $agents = [auth()->user()->id => auth()->user()->name] + App\Models\User::where('status','Active')
                                                                        ->where('leader',auth()->user()->id)
                                                                        ->orderBy('name','asc')
                                                                        ->pluck('name','id')
                                                                        ->all();
    }
    if (userCan('clients_view_branch')) {
        $agents = App\Models\User::where('status','Active')->where('branch_id',auth()->user()->id)
                                                    ->orderBy('name','asc')
                                                    ->pluck('name','id')
                                                    ->all();
    }
    return $agents;
}
function clientsList()
{
    if (userCan('clients_view')) {
        $agents = App\Models\Clients::orderBy('Name','asc')->pluck('Name','id')->all();
    } elseif (userCan('clients_view_branch')) {
        $agents = App\Models\Clients::where('branch_id',auth()->user()->branch_id)->orderBy('Name','asc')->pluck('Name','id')->all();
    } elseif (userCan('clients_view_team')) {
        $teamMembers = [];
        $teamMembers[] = auth()->user()->id;
        $myTeam = App\Models\User::where('status','Active')->where('leader',auth()->user()->id)->get();
        foreach ($myTeam as $myTeamKey => $myTeamV) {
            $teamMembers[] = $myTeamV['id'];
        }
        $agents = App\Models\Clients::whereIn('AgentID',$teamMembers)->orderBy('Name','asc')->pluck('Name','id')->all();
    } else {
        $agents = App\Models\Clients::where('AgentID',auth()->user()->id)->orderBy('Name','asc')->pluck('Name','id')->all();
    }
    return $agents;
}
function clientStatusArray($lang)
{
    $list = [
        'ar' => [
            'FollowUp' => 'عملاء المتابعات',
            'NotInterested' => 'عملاء غير مهتمين',
            'interested' => 'عملاء مهتمين',
            'Request' => 'عملاء بطلبات جديدة',
            'Meeting' => 'عملاء إجتماعات',
            'FollowUpAfterMeeting' => 'عملاء مابعد الإجتماع'
        ],
        'en' => [
            'FollowUp' => 'عملاء المتابعات',
            'NotInterested' => 'عملاء غير مهتمين',
            'interested' => 'عملاء مهتمين',
            'Request' => 'عملاء بطلبات جديدة',
            'Meeting' => 'عملاء إجتماعات',
            'FollowUpAfterMeeting' => 'عملاء مابعد الإجتماع'
        ]
    ];
    return $list[$lang];
}
function clientClassArray()
{
    $list = [
        'A+' => 'A+',
        'A' => 'A',
        'B' => 'B',
        'C' => 'C'
    ];
    return $list;
}

function projectsTypesList($lang)
{
    $list = [
        'ar' => [
            'housing' => 'سكني',
            'commercial' => 'تجاري',
            'Administrative' => 'إداري',
            'all' => 'شامل'
        ],
        'en' => [
            'housing' => 'سكني',
            'commercial' => 'تجاري',
            'Administrative' => 'إداري',
            'all' => 'شامل'
        ]
    ];
    return $list[$lang];
}
function unitsTypesList($lang)
{
    $list = [
        'ar' => [
            'Land' => 'أرض',
            'Floor' => 'شقة',
            'House' => 'منزل',
            'Villa' => 'فيلا',
            'Shop' => 'محل',
            'Studio' => 'ستديو',
            'Shalie' => 'شاليه'
        ],
        'en' => [
            'Land' => 'أرض',
            'Floor' => 'شقة',
            'House' => 'منزل',
            'Villa' => 'فيلا',
            'Shop' => 'محل',
            'Studio' => 'ستديو',
            'Shalie' => 'شاليه'
        ]
    ];
    return $list[$lang];
}

function nextSession($lang)
{
    $list = [
        'ar' => [
            '1 month' => 'بعد شهر',
            '45 days' => 'بعد 45 يوم',
            '2 months' => 'بعد شهرين',
        ],
        'en' => [
            '1 month' => '1 month',
            '45 days' => '45 days',
            '2 months' => '2 months',
        ]
    ];
    return $list[$lang];
}


function systemMainSections()
{
    $systemMainSections = [
        'home'=>'home',
        'settings' => 'settings',
        'users' => 'users',
        'doctors' => 'doctors' ,
        'roles' => 'roles',
        'userAccounts' => 'userAccounts',
        'attendance' => 'attendance',
        'safes' => 'safes',
        'expensesTypes' => 'expensesTypes',
        'expenses' => 'expenses',
        'revenues' => 'revenues',
        'clients' => 'clients',
        'refferalClients' => 'refferalClients',
        'reports' => 'reports',
        'reservations' => 'reservations',
        'appointments' => 'appointments',
        'leaserMachines' => 'leaserMachines',
        'areas' => 'areas' ,
        'services' => 'services' ,
        'offers'  => 'offers',
        'payments' => 'payments',
        'complaints' => 'complaints ',
    ];
    return $systemMainSections;
}

function hoursList()
{
    $hoursList = [
        '09:00',
        '09:15',
        '09:30',
        '09:45',
        '10:00',
        '10:15',
        '10:30',
        '10:45',
        '11:00',
        '11:15',
        '11:30',
        '11:45',
        '12:00',
        '12:15',
        '12:30',
        '12:45',
        '01:00',
        '01:15',
        '01:30',
        '01:45',
        '02:00',
        '02:15',
        '02:30',
        '02:45',
        '03:00',
        '03:15',
        '03:30',
        '03:45',
        '04:00',
        '04:15',
        '04:30',
        '04:45',
    ];
    return $hoursList;
}



function getPermissions($role = null)
{

    $roleData = '';
    if ($role != null) {
        $roleData = App\Models\roles::find($role);
    }

    $permissionsArr = [];
    foreach (systemMainSections() as $section) {
        $permissionsArr[$section] = [
            'name' => trans('common.'.$section),
            'permissions' => []
        ];
        $settingPermissions = App\Models\permissions::where('group',$section)->get();
        foreach ($settingPermissions as $permission) {
            $hasIt = 0;
            if ($roleData != '') {
                if ($roleData->hasPermission($permission['id']) == 1) {
                    $hasIt = 1;
                }
            }
            $permissionsArr[$section]['permissions'][] = [
                'id' => $permission['id'],
                'can' => $permission['can'],
                'name' => $permission['name_'.session()->get('Lang')],
                'hasIt' => $hasIt
            ];
        }
    }
    return $permissionsArr;
}

function monthArray($lang)
{
    $arr = [
        'ar' => [
            '01' => '01 يناير',
            '02' => '02 فبراير',
            '03' => '03 مارس',
            '04' => '04 أبريل',
            '05' => '05 مايو',
            '06' => '06 يونيو',
            '07' => '07 يوليو',
            '08' => '08 أغسطس',
            '09' => '09 سبتمبر',
            '10' => '10 أكتوبر',
            '11' => '11 نوفمبر',
            '12' => '12 ديسمبر',
        ]
    ];
    return $arr[$lang];
}
function yearArray()
{
    $cunrrentYear = date('Y');
    $firstYear = 2020;
    $arr = [];
    for ($i=$cunrrentYear; $i >= $firstYear; $i--) {
        $arr[$i] = $i;
    }
    return $arr;
}
function employeeStatusArray($lang)
{
    $arr = [
        'ar' => [
            'Active' => 'موظف مفعل',
            'Archive' => 'موظف معطل'
        ]
    ];
    return $arr[$lang];
}
function complaintsStatus($lang)
{
    $arr = [
        'ar' => [
            'pending' => 'في الانتظار',
            'inProgres' => 'يتم العمل عليها',
            'completed' => 'تم حلها',
            'failed' => 'فشلت'
        ],
        'en' => [
            'pending' => 'pending',
            'inProgres' => 'in progres',
            'completed' => 'completed',
            'failed' => 'failed'
        ]
    ];
    return $arr[$lang];
}

function safeTypes($lang)
{
    $list = [
        'ar' => [
            'safe' => 'خزينة نقدية',
            'bank' => 'حساب بنكي',
            'wallet' => 'محفظة إلكترونية'
        ],
        'en' => [
            'safe' => 'Cash Safe',
            'bank' => 'Bank Account',
            'wallet' => 'Electronic Wallet'
        ]
    ];

    return $list[$lang];
}

function commissionTypes($lang)
{
    $list = [
        'ar' => [
            '0' => 'من إجمالي الايرادات',
            '1' => 'بعد حساب المصروفات',
        ],
        'en' => [
            '0' => 'Total Revenues',
            '1' => 'After Expenses',
        ]
    ];

    return $list[$lang];
}

function doubleDate($lang)
{
    $list = [
        'ar' => [
            '0' => 'للخدمة معاد واحد',
            '1' => 'للخدمة اكثر من معاد',
        ],
        'en' => [
            '0' => 'without duplicate date',
            '1' => 'with duplicate date',
        ]
    ];

    return $list[$lang];
}

function reservationStatus($lang)
{
    $list = [
        'ar' => [
            '0' => 'في انتظار التأكيد',
            '1' => 'تم التأكيد',
        ],
        'en' => [
            '0' => 'pending to confirm',
            '1' => 'confirmed',
        ]
    ];

    return $list[$lang];
}

function expensesTypes($lang)
{
    $list = [
        'ar' => [
            'withdrawal' => 'مسحوبات',
            'transfeerToAnother' => 'نقل إلى خزينة',
            'contract' => 'مصروفات تعاقد'
        ],
        'en' => [
            'withdrawal' => 'Withdrawal',
            'transfeerToAnother' => 'نقل إلى خزينة',
            'contract' => 'مصروفات تعاقد'
        ]
    ];
    $types = App\Models\ExpensesTypes::orderBy('name','asc')->pluck('name','id')->all();
    return $list[$lang]+$types;
}
function revenuesTypes($lang)
{
    $list = [
        'ar' => [
            'revenues' => 'إيرادات',
            'deposits' => 'إيداعات',
            'transfeerFromAnother' => 'نقل من خزينة'
        ],
        'en' => [
            'revenues' => 'إيرادات',
            'deposits' => 'إيداعات',
            'transfeerFromAnother' => 'نقل من خزينة'
        ]
    ];
    return $list[$lang];
}

function paymentsTypes($lang)
{
    $list = [
        'ar' => [
            'revenues' => 'إيرادات',
            'deposits' => 'إيداعات',
        ],
        'en' => [
            'revenues' => 'revenues',
            'deposits' => 'deposits',
        ]
    ];
    return $list[$lang];
}

function refferalList()
{
    $refferals = App\Models\RefferalClient::orderBy('name','asc')->pluck('name','id')->all();
    return $refferals;
}

function followUpTypeList($lang)
{
    $list = [
        'ar' => [
            'Mail' => 'بريد إلكتروني',
            'Call' => 'إتصال هاتفي',
            'InVisit' => 'زياره بمقر الشركة',
            'OutVisit' => 'زياره بمقر العميل',
            'UnitVisit' => 'معاينة للوحدة'
        ],
        'en' => [
            'Mail' => 'بريد إلكتروني',
            'Call' => 'إتصال هاتفي',
            'InVisit' => 'زياره بمقر الشركة',
            'OutVisit' => 'زياره بمقر العميل',
            'UnitVisit' => 'معاينة للوحدة'
        ]
    ];
    return $list[$lang];
}
function whoIsContactingList($lang)
{
    $list = [
        'ar' => [
            'Company' => 'ممثل الشركة',
            'Client' => 'العميل'
        ],
        'en' => [
            'Company' => 'ممثل الشركة',
            'Client' => 'العميل'
        ]
    ];
    return $list[$lang];
}

function availableWorkHours($date = null,$services = [], $offer = null)
{
    $fromHour = getSettingValue('startwork');
    $toHour = getSettingValue('endwork');

    $begin = new DateTime($date.' '.$fromHour);
    $end = new DateTime($date.' '.$toHour);

    $timeRanges = [];
    while($begin < $end) {

        $output = $begin->format('H:i');
        $begin->modify('+15 minutes');

        $timeRanges[] = $output;
    }

    $servicesArr = $services;
    if ($offer != null) {
        $offerData = App\Models\Offer::find($offer);
        if ($offerData != '') {
            if ($offerData->services != '') {
                foreach ($offerData->services as $offer_service) {
                    $servicesArr[] = (string)$offer_service->id;
                }
            }
        }
    }

    //get all services in this booking
    $allServices = App\Models\Service::whereIn('id',$servicesArr)->get();

    $filterTimes = [];
    foreach ($timeRanges as $time) {
        foreach ($servicesArr as $singleService) {
            $searchKey = array_search($time, array_column($filterTimes, 'time'));
            if ($searchKey == '') {
                $filterTimes[] = [
                    'status' => getRepeatedTimes($time, $date, $singleService),
                    'time' => $time
                ];
           }
        }
    }

    //get all appointments with these services
    // $oldAppointmentsTimes = App\Models\AppointmentServices::whereIn('service_id',$servicesArr)
    //                                             ->where('date',$date)
    //                                             ->pluck('hour')
    //                                             ->toArray();

    //get appointments in this day
    // $oldAppointments = App\Models\Appointment::whereIn('id',$oldAppointmentsIds)->where('date',$date)->pluck('hour')->toArray();

    if (isset($filterTimes[0])) {
        if ($filterTimes[0]['time'] == $filterTimes[1]['time']) {
            unset($filterTimes[0]);
        }
    }

    return array_values($filterTimes);

}

function getRepeatedTimes($hour, $date, $service)
{
    $status = 0;
    //get service details
    $serviceDetails = App\Models\Service::find($service);

    //get old times
    $oldAppointmentsTimes = App\Models\AppointmentServices::where('service_id',$service)
                                                ->where('date',$date)
                                                ->where('hour',$hour.':00')
                                                ->count();

    if ($serviceDetails != '') {
        if ($serviceDetails->max_clients != 0) {
            if ($serviceDetails->max_clients > $oldAppointmentsTimes) {
                $status = 1;
            }
        }
    }

    return $status;
}
