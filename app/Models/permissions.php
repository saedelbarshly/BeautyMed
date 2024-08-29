<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class permissions extends Model
{
    //
    protected $guarded = [];

    public function roles()
    {
        return $this->belongsToMany(roles::class);
    }

    public function apiData($lang)
    {
        return [
            'id' => $this->id,
            'name' => $this['name_'.$lang]
        ];
    }
}
