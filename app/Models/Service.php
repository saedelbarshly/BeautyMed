<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    //
    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot(['commission','id','month','year']);
    }

    public function offers()
    {
        return $this->belongsToMany(Offer::class)->withPivot(['id','offerPrice']);
    }

    public function reservations()
    {
        return $this->belongsToMany(Reservation::class)->withPivot(['id','client_id']);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function appointments()
    {
        return $this->belongsToMany(Appointment::class)->withPivot(['id']);
    }

    public function machine()
    {
        return $this->belongsTo(Machine::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expenses::class,'service_id');
    }

    public function totals($year,$month)
    {
        $expenses = $this->expenses()->where('month',$month)->where('year',$year);
        $list = [
            'expenses' => $expenses->sum('Expense'),
            'reservationsCount' => $this->reservations()->whereMonth('reservations.created_at',$month)->whereYear('reservations.created_at',$year)->count(),
            'reservationsArr' => $this->reservations()->whereMonth('reservations.created_at',$month)->whereYear('reservations.created_at',$year)->get(),
            'revenues' => 0
        ];
        return $list;
    }


}
