<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branches extends Model
{
    //
    protected $guarded = [];

    public function users()
    {
        return $this->belongsTo(User::class,'branch_id');
    }
    public function clients()
    {
        return $this->belongsTo(Clients::class,'branch_id');
    }
    public function safes()
    {
        return $this->belongsTo(SafesBanks::class,'branch_id');
    }
    public function revenues()
    {
        return $this->hasMany(Revenues::class,'branch_id');
    }
    public function expenses()
    {
        return $this->hasMany(Expenses::class,'branch_id');
    }
    public function totals()
    {
        $totals = [
            'income' => $this->revenues()->sum('amount'),
            'outcome' => $this->expenses()->sum('Expense'),
            'salaries' => 0
        ];
        $totals['balance'] = $totals['income'] - $totals['outcome'] - $totals['salaries'];
        return $totals;
    }
}
