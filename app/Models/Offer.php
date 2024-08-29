<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $guarded = [];

    public function services()
    {
        return $this->belongsToMany(Service::class)->withPivot(['id','offerPrice']);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class,'offer_id');
    }
}
