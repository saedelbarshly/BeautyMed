<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cities extends Model
{
    //
    protected $guarded = [];
    public function govenorate()
    {
        return $this->belongsTo(Governorates::class,'GovernorateID');
    }
}
