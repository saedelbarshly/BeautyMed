<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    protected $guarded = [];
    //
    public function followups()
    {
        return $this->hasMany(ClientFollowUps::class,'ClientID');
    }
    public function lastFollowUp()
    {
        return $this->followups()->orderBy('id','desc')->first();
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class,'client_id');
    }

    public function complaints()
    {
        return $this->hasMany(Complaint::class,'client_id');
    }

    public function refferal()
    {
        return $this->belongsTo(RefferalClient::class,'refferal_id');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class,'client_id');
    }

    public function payments()
    {
        return $this->hasMany(Revenues::class,'client_id');
    }

    public function transformPulsesUserSender()
    {
        return $this->hasMany(TransformationPulses::class,'clientSender_id');
    }
    public function transformPulsesUserReceiver()
    {
        return $this->hasMany(TransformationPulses::class,'clientReceiver_id');
    }

    public function transformPaymentUserSender()
    {
        return $this->hasMany(TransformationPayment::class,'clientSender_id');
    }
    public function transformPaymentUserReceiver()
    {
        return $this->hasMany(TransformationPayment::class,'clientReceiver_id');
    }


}
