<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class roles extends Model
{
    //
    protected $guarded = [];
    public function users()
    {
        return $this->hasMany(User::class,'role');
    }

    public function permissions()
    {
        return $this->belongsToMany(permissions::class,'role_permissions','roles_id','permissions_id');
    }

    public function hasPermission($permissionId)
    {
        $permissionData = permissions::find($permissionId);
        $permission = $this->permissions()->where('permissions.can',$permissionData->can)->first();
        if ($permission != '') {
            return 1;
        }
        return 0;
    }

    public function canDo($permission_name)
    {
        $permission = $this->permissions()->where('permissions.can',$permission_name)->first();
        if ($permission != '') {
            return 1;
        }
        return 0;
    }
}
