<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceVacations extends Model
{
    //
    protected $guarded = [];
    public function typeText()
    {
        return vacationTypesArray(session()->get('Lang'))[$this->type];
    }
}
