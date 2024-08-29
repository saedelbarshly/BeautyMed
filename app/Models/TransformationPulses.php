<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransformationPulses extends Model
{
    protected $guarded = [];

    public function transformPulsesUserSender()
    {
        return $this->belongsTo(Clients::class,'clientSender_id');
    }

    public function transformPulsesUserReceiver()
    {
        return $this->belongsTo(Clients::class,'clientReceiver_id');
    }


    public function pulsesReservationSender()
    {
        return $this->belongsTo(Reservation::class,'reservationSender_id');
    }


    public function pulsesReservationReceiver()
    {
        return $this->belongsTo(Reservation::class,'reservationReceiver_id');
    }



}
