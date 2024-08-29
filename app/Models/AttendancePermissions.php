<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendancePermissions extends Model
{
    //
    protected $guarded = [];
    public function typeText()
    {
        return attendancePermissions(session()->get('Lang'))[$this->type];
    }
}
