<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    //
    protected $table = 'attendance';
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class,'EmployeeID');
    }
    public function earlyOutCalculator()
    {
        $minutes = 0;
        if ($this->CheckOut != '') {
            $thisDate = date('Y-m-d '.$this->user->WorkTo);
            $thisAcualDate = date('Y-m-d '.$this->CheckOut);
            if (strtotime($thisDate) > strtotime($thisAcualDate)) {
                $start_date = new \DateTime($thisDate);
                $since_start = $start_date->diff(new \DateTime($thisAcualDate));

                $minutes = $since_start->days * 24 * 60;
                $minutes += $since_start->h * 60;
                $minutes += $since_start->i;
            }
        }
        return $minutes;
    }
}
