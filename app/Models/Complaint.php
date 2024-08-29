<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $guarded = [];

    public function creatorUser()
    {
        return $this->belongsTo(User::class,'creator_user_id');
    }

    public function assignUser()
    {
        return $this->belongsTo(User::class,'assigned_user_id');
    }

    public function client()
    {
        return $this->belongsTo(Clients::class,'client_id');
    }

}
