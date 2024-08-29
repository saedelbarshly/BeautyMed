<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalariesDeductions extends Model
{
    //
    protected $guarded = [];
    protected $table = 'salaries_deductions';
    public function responsible()
    {
        return $this->belongsTo(User::class,'UID');
    }
}
