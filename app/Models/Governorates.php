<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Governorates extends Model
{
    //
    protected $guarded = [];
    public function cities()
    {
        return $this->hasMany(Cities::class,'GovernorateID');
    }
    public function apiData($lang)
    {
        return [
            'id' => $this->id,
            'name' => $this['name']
        ];
    }

}
