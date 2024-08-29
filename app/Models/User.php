<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;


class User extends Authenticatable
{
    use Notifiable;
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function hisRole()
    {
        return $this->belongsTo(roles::class,'role');
    }
    public function photoLink()
    {
        $image = asset('AdminAssets/app-assets/images/portrait/small/avatar-s-11.jpg');

        if ($this->profile_photo != '') {
            $image = asset('uploads/users/'.$this->id.'/'.$this->profile_photo);
        }

        return $image;
    }
    public function identityLink()
    {
        $image = asset('AdminAssets/app-assets/images/portrait/small/avatar-s-11.jpg');

        if ($this->identity != '') {
            $image = asset('uploads/users/'.$this->id.'/'.$this->identity);
        }

        return $image;
    }

    public function creatorComplaints()
    {
        return $this->hasMany(Complaint::class,'creator_user_id');
    }

    public function assignedComplaints()
    {
        return $this->hasMany(Complaint::class,'assigned_user_id');
    }

    public function job()
    {
        return $this->belongsTo(Jobs::class,'title');
    }

    public function doctorReservations()
    {
        return $this->hasMany(Reservation::class,'doctor_id');
    }
    public function userReservations()
    {
        return $this->hasMany(Reservation::class,'user_id');
    }
    public function appointments()
    {
        return $this->hasMany(Appointment::class,'doctor_id');
    }
    public function countryData()
    {
        return $this->belongsTo(Countries::class,'country');
    }
    public function governorateData()
    {
        return $this->belongsTo(Governorates::class,'governorate');
    }
    public function cityData()
    {
        return $this->belongsTo(Cities::class,'city');
    }
    public function addressList()
    {
        return $this->hasMany(UserAddress::class,'user_id');
    }
    public function paymentMethods()
    {
        return $this->hasMany(UserPaymentMethods::class,'user_id');
    }
    public function bookReviews()
    {
        return $this->hasMany(BookReviews::class,'user_id');
    }
    public function apiData($lang,$details = null)
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'userName' => $this->userName,
            'email' => $this->email,
            'language' => $this->language,
            'phone' => $this->phone,
            'address' => $this->address,
            'about' => $this->about,
            'photo' => $this->photoLink(),
            'country' => $this->countryData != '' ? $this->countryData->apiData($lang) : ['id'=>'','name'=>''],
            'governorate' => $this->governorateData != '' ? $this->governorateData->apiData($lang) : ['id'=>'','name'=>''],
            'city' => $this->cityData != '' ? $this->cityData->apiData($lang) : ['id'=>'','name'=>'']
        ];
        if ($details != '') {
            if ($this->publisherBooks()->count() > 0) {
                $books = $this->publisherBooks;
                $data['publisherBooks'] = [];
                foreach ($books as $key => $value) {
                    $data['publisherBooks'][] = $value->apiData($lang);
                }
            }
        }

        return $data;
    }

    public function publisherBooks()
    {
        return $this->hasMany(Books::class,'publisher_id');
    }

    public function checkActive()
    {
        $active = '1';
        if ($this->active == '0') {
            $active = trans('auth.yourAcountStillNotActive');
        }
        if ($this->block == '1') {
            $active = trans('auth.yourAcountIsBlocked');
        }
        return $active;
    }

    public function publisherClients()
    {
        return $this->hasManyThrough(
            'App\Models\User',
            'App\Orders',
            'publisher_id', // Local key on users table...
            'id', // Local key on users table...
        );
    }

    function mySales()
    {
        return 0;
    }

    public function paymentsHistory()
    {
        return $this->hasMany(PublisherPaymentsHistory::class,'user_id');
    }

    public function currentBalance()
    {
        $sales = $this->mySales()->sum('total');
        $payments = $this->paymentsHistory()->sum('amount');
        return [
            'balance' => $sales-$payments,
            'balanceRate' => (($sales-$payments)/getSettingValue('MinimumForTransfeerMoney'))*100
        ];
    }

    public function deductions()
    {
        return $this->hasMany(SalariesDeductions::class,'EmployeeID');
    }

    public function salaryRequests()
    {
        return $this->hasMany(SalaryRequest::class,'EmployeeID');
    }

    public function monthDeductions($month = null, $year = null)
    {
        if ($month == null) {
            $month = date('m');
        }
        if ($year == null) {
            $year = date('Y');
        }
        $deductionsList = [];
        $deductionsList['totalMinus'] = 0;
        $deductionsList['totalPlus'] = 0;
        foreach (deductionTypesArray('ar')['details'] as $key => $value) {
            $thisDeductionTotal = $this->deductions()->where('Type',$key)
                                                    ->where('month',$month)
                                                    ->where('year',$year)
                                                    ->sum('Deduction');
            $deductionsList[$key] = $thisDeductionTotal;
            if ($value['type'] == 'plus') {
                $deductionsList['totalPlus'] += $thisDeductionTotal;
            } else {
                $deductionsList['totalMinus'] += $thisDeductionTotal;
            }
        }
        return $deductionsList;
    }

    public function currentMonthSalary($month = null, $year = null)
    {
        return $this->sallary;
    }

    public function monthSalary($month = null, $year = null)
    {

        $list = [
            'basic' => $this->currentMonthSalary($month,$year),
            'plus' => $this->monthDeductions($month,$year)['totalPlus'],
            'minus' => $this->monthDeductions($month,$year)['totalMinus'],
            'delivered' => $this->salaryRequests()->where('month',$month)
                                                    ->where('year',$year)
                                                    ->sum('DeliveredSalary')
        ];
        $list['net'] = $list['basic']+$list['plus']-$list['minus']-$list['delivered'];
        return $list;
    }

    public function lateCalculator($time)
    {
        $minutes = 0;
        $thisDate = date('Y-m-d '.$this->WorkFrom);
        $thisAcualDate = date('Y-m-d '.$time);
        if (strtotime($thisDate) < strtotime($thisAcualDate)) {
            $start_date = new \DateTime($thisDate);
            $since_start = $start_date->diff(new \DateTime($thisAcualDate));

            $minutes = $since_start->days * 24 * 60;
            $minutes += $since_start->h * 60;
            $minutes += $since_start->i;
        }
        return $minutes;
    }

    public function overtimeCalculator($time)
    {
        $minutes = 0;
        $thisDate = date('Y-m-d '.$this->WorkTo);
        $thisAcualDate = date('Y-m-d '.$time);
        if (strtotime($thisDate) < strtotime($thisAcualDate)) {
            $start_date = new \DateTime($thisDate);
            $since_start = $start_date->diff(new \DateTime($thisAcualDate));

            $minutes = $since_start->days * 24 * 60;
            $minutes += $since_start->h * 60;
            $minutes += $since_start->i;
        }
        return $minutes;
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class,'EmployeeID');
    }
    public function todayAttendance($date)
    {
        return $this->attendance()->where('Date',$date)->first();
    }

    public function monthAbsence($month = null, $year = null)
    {
        $monthDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $startDate = Carbon::create($year, $month, 1);
        $endDate = Carbon::create($year, $month, $monthDays);
        $no_of_days = $startDate->diffInDaysFiltered(function(Carbon $date) {
                    return !$date->isWeekend();
                }, $endDate);

        $thisAttendance = $this->attendance()->where('month',$month)->where('year',$year)->count();

        return $no_of_days-$thisAttendance;
    }

    public function monthAttendanceStats($month = null, $year = null)
    {
        $list = [
            'late' => $this->attendance()->where('month',$month)->where('year',$year)->sum('late'),
            'earlyCheckOut' => 0,
            'overTime' => $this->attendance()->where('month',$month)->where('year',$year)->sum('OverTime')
        ];
        return $list;
    }

    public function services()
    {
        return $this->belongsToMany(Service::class)->withPivot(['commission','id','month','year']);
    }

    public function servicesComissios()
    {
        return $this->belongsToMany(Service::class)->withPivot('commission');
    }

    public function payments()
    {
        return $this->hasMany(Revenues::class,'UID');
    }

    public function branch()
    {
        return $this->belongsTo(Branches::class,'branch_id');
    }
    public function followups()
    {
        return $this->hasMany(ClientFollowUps::class,'UID');
    }
    public function followupsStats($month = null, $year = null)
    {
        $thisMonth = date('m');
        $thisYear = date('Y');
        if ($month != null) {
            $thisMonth = $month;
        }
        if ($year != null) {
            $thisYear = $year;
        }
        $list = [
            'Mail' => $this->followups()
                        ->where('month',$thisMonth)
                        ->where('year',$thisYear)->where('status','Done')->where('contactingType','Mail')->count(),
            'Call' => $this->followups()
                        ->where('month',$thisMonth)
                        ->where('year',$thisYear)->where('status','Done')->where('contactingType','Call')->count(),
            'InVisit' => $this->followups()
                        ->where('month',$thisMonth)
                        ->where('year',$thisYear)->where('status','Done')->where('contactingType','InVisit')->count(),
            'OutVisit' => $this->followups()
                        ->where('month',$thisMonth)
                        ->where('year',$thisYear)->where('status','Done')->where('contactingType','OutVisit')->count(),
            'UnitVisit' => $this->followups()
                        ->where('month',$thisMonth)
                        ->where('year',$thisYear)->where('status','Done')->where('contactingType','UnitVisit')->count()
        ];

        return $list;
    }
    public function monthFollowupsStats($month = null, $year = null)
    {
        $numbers = [
            'Mail' => '',
            'Call' => '',
            'InVisit' => '',
            'OutVisit' => '',
            'UnitVisit' => ''
        ];
        $thisMonthDaysCount = cal_days_in_month(CAL_GREGORIAN,$month,$year);
        for ($i=1; $i <= $thisMonthDaysCount; $i++) {
            $day = $year.'-'.$month.'-'.$i;
            $emails = $this->followups()->where('status','Done')->where('contactingDateTime',$day)->where('contactingType','Mail')->count();
            $numbers['Mail'] .= $emails;
            if ($i<$thisMonthDaysCount) {
                $numbers['Mail'] .= ',';
            }

            $Calls = $this->followups()->where('status','Done')->where('contactingDateTime',$day)->where('contactingType','Call')->count();
            $numbers['Call'] .= $Calls;
            if ($i<$thisMonthDaysCount) {
                $numbers['Call'] .= ',';
            }

            $InVisits = $this->followups()->where('status','Done')->where('contactingDateTime',$day)->where('contactingType','InVisit')->count();
            $numbers['InVisit'] .= $InVisits;
            if ($i<$thisMonthDaysCount) {
                $numbers['InVisit'] .= ',';
            }

            $OutVisits = $this->followups()->where('status','Done')->where('contactingDateTime',$day)->where('contactingType','OutVisit')->count();
            $numbers['OutVisit'] .= $OutVisits;
            if ($i<$thisMonthDaysCount) {
                $numbers['OutVisit'] .= ',';
            }

            $UnitVisits = $this->followups()->where('status','Done')->where('contactingDateTime',$day)->where('contactingType','UnitVisit')->count();
            $numbers['UnitVisit'] .= $UnitVisits;
            if ($i<$thisMonthDaysCount) {
                $numbers['UnitVisit'] .= ',';
            }
        }
        return $numbers;
    }

    public function vacations()
    {
        return $this->hasMany(AttendanceVacations::class,'EmployeeID');
    }

    public function attendancePermissions()
    {
        return $this->hasMany(AttendancePermissions::class,'EmployeeID');
    }
    public function employmentProfile()
    {
        return $this->hasOne(EmploymentProfile::class,'EmployeeID');
    }


    public function filesArray()
    {
        $arr = [];
        if ($this->files != '') {
            $arr = unserialize(base64_decode($this->files));
        }
        return $arr;
    }

    public function getAttachmentImageLink($image)
    {
        $link = '';
        if (in_array($image,$this->filesArray())) {
            $link = asset('uploads/users/'.$this->id.'/'.$image);
        }
        return $link;
    }

    public function filesHtml($type = null)
    {
        $arr = $this->filesArray();
        $html = '';
        if (is_array($arr)) {
            if (count($arr) > 0) {
                foreach ($arr as $key => $value) {
                    $html .= '<div class="col-4" id="row_photo_'.$key.'">';
                    $html .= '<img class="img-fluid rounded my-1" src="'.$this->getAttachmentImageLink($value).'" alt="avatar">';
                    if ($type != 'view') {
                        $html .= '<div class="col-12">';
                        $delete = route('admin.users.deletePhoto',['id'=>$this->id,'photo'=>$value,'X'=>$key]);
                        $html .= '<button type="button" class="btn btn-icon btn-danger" onclick="';
                        $html .= "confirmDelete('".$delete."','photo_".$key."')";
                        $html .= '">';
                        $html .= '<i data-feather="trash-2"></i>';
                        $html .= '</button>';
                        $html .= '</div>';
                    }
                    $html .= '</div>';
                }
            }
        }
        return $html;
    }

}
