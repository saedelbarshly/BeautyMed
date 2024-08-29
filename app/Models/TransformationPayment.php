<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransformationPayment extends Model
{
    protected $guarded = [];


    public function transformPaymentUserSender()
    {
        return $this->belongsTo(Clients::class,'clientSender_id');
    }

    public function transformPaymentUserReceiver()
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
