<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SafesBanks extends Model
{
    //
    protected $guarded = [];
    public function revenues()
    {
        return $this->hasMany(Revenues::class,'safe_id');
    }
    public function revenuesWithOutTransfeers()
    {
        $amount = 0;
        if ($this->revenues()->where('Type','transfeerFromAnother')->count() > 0) {
            $amount = $this->revenues()->where('Type','transfeerFromAnother')->sum('amount');
        }
        return $amount;
    }
    public function expenses()
    {
        return $this->hasMany(Expenses::class,'safe_id');
    }


    public function expensesWithOutTransfeers()
    {
        $amount = 0;
        if ($this->expenses()->where('Type','transfeerToAnother')->count() > 0) {
            $amount = $this->expenses()->where('Type','transfeerToAnother')->sum('Expense');
        }
        return $amount;
    }
    public function salaryRequests()
    {
        return $this->hasMany(SalaryRequest::class,'safe_id');
    }
    public function totals()
    {
        $totals = [
            'income' => $this->revenues()->sum('amount'),
            'outcome' => $this->expenses()->sum('Expense') + $this->salaryRequests()->sum('DeliveredSalary'),
            'salaries' => 0
        ];
        $totals['balance'] = $totals['income'] - $totals['outcome'] - $totals['salaries'];
        return $totals;
    }
    public function TypeText()
    {
        return safeTypes(session()->get('Lang'))[$this->Type];
    }
    public function branch()
    {
        return $this->belongsTo(Branches::class,'branch_id');
    }
}
