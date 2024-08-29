<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractPayments extends Model
{
    //
    public function contract()
    {
        return $this->belongsTo(ClientContracts::class,'ContractID');
    }
    public function safe()
    {
        return $this->belongsTo(SafesBanks::class,'SafeID');
    }
}
