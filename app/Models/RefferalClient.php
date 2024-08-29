<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RefferalClient extends Model
{
    protected $guarded = [];

    public function clients()
    {
        return $this->hasMany(Clients::class,'refferal_id');
    }
}
