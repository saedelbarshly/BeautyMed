<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $guarded = [];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class,'reservation_id');
    }

    public function client()
    {
        return $this->belongsTo(Clients::class,'client_id');
    }

    public function area()
    {
        return $this->belongsTo(Area::class,'area_id');
    }

    public function doctor()
    {
        return $this->belongsTo(User::class,'doctor_id');
    }

    public function services()
    {
        return $this->belongsToMany(Service::class)->withPivot(['id','date','hour']);
    }

    public function checkForServApp($service_id)
    {
        return $this->services()->where('services.id',$service_id)->first();
    }

    public function areaPulses()
    {
        return $this->hasMany(AppointmentPulses::class,'appointment_id');
    }

    public function appointmentMore()
    {
        return $this->hasMany(AppointmentMore::class,'appointment_id');
    }

    public function areaList()
    {
        return $this->hasManyThrough(
            Area::class,
            AppointmentPulses::class,
            'area_id', // Foreign key on the AppointmentPulses table...
            'id', // Foreign key on the Area table...
        );
    }

    public function pulsesTotals()
    {
        $list = [
            'pulses' => $this->areaPulses()->sum('pulses'),
            'power' => $this->areaPulses()->sum('power')
        ];
        $list['areaList'] = [];
        foreach ($this->areaList as $key => $value) {
            $list['areaList'][] = [
                'area_id' => $value['area.id'],
                'area_name' => $value['area.name'],
                'pulses' => $this->areaPulses()->where('area_id',$value['area.id'])->sum('pulses'),
                'power' => $this->areaPulses()->where('area_id',$value['area.id'])->sum('power')
            ];
        }
        return $list;
    }
}
