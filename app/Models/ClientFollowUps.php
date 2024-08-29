<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientFollowUps extends Model
{
    //
    protected $guarded = [];
    public function ContactingType()
    {
        $arr = [
            'Mail' => 'بريد إلكتروني',
            'Call' => 'إتصال هاتفي',
            'InVisit' => 'زياره بمقر الشركة',
            'OutVisit' => 'زياره بمقر العميل',
            'UnitVisit' => 'معاينة للوحدة'
        ];
        if (!isset($arr[$this->contactingType])) {
            return $this->contactingType;
        }
        return $arr[$this->contactingType];
    }
    public function client()
    {
        return $this->belongsTo(Clients::class,'ClientID');
    }
    public function agent()
    {
        return $this->belongsTo(User::class,'UID');
    }
}
