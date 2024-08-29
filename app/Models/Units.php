<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Units extends Model
{
    //
    protected $guarded = [];
    public function apiDetails()
    {
        $unitImages = [];
        if ($this->files != '') {
            $files = unserialize(base64_decode($this->files));
            if (is_array($files)) {
                foreach ($files as $image) {
                    $unitImages[] = url('storage/app/public/Units/'.$this->id.'/'.$image);
                }
            }
        }
        return [
            'id' => $this->id,
            'governorate' => $this->governorate(),
            'city' => $this->city(),
            'project' => $this->project(),
            'name' => $this->name,
            'type' => $this->type(),
            'address' => $this->address,
            'Price' => $this->Price.' ج.م',
            'space' => $this->space,
            'floor' => $this->floor,
            'rooms' => $this->rooms,
            'bathroom' => $this->bathroom,
            'Kitchen' => $this->Kitchen,
            'notes' => $this->notes,
            'OwnerUser' => $this->ownerUser(),
            'images' => $unitImages
        ];
    }
    public function type()
    {
        $arr = [
            'Land' => 'أرض',
            'Floor' => 'شقة',
            'House' => 'منزل',
            'Villa' => 'فيلا',
            'Shop' => 'محل',
            'Studio' => 'ستديو',
            'Shalie' => 'شاليه'
        ];
        if (!isset($arr[$this->type])) {
            return $this->type;
        }
        return $arr[$this->type];
    }
    public function governorate()
    {
        return $this->belongsTo(Governorates::class,'GovernorateID');
    }
    public function city()
    {
        return $this->belongsTo(Cities::class,'CityID');
    }
    public function project()
    {
        return $this->belongsTo(Projects::class,'ProjectID');
    }
    public function client()
    {
        return $this->belongsTo(Clients::class,'ClientID');
    }
    public function agent()
    {
        return $this->belongsTo(User::class,'AgentID');
    }



    public function filesArray()
    {
        $arr = [];
        if ($this->files != '') {
            $arr = unserialize(base64_decode($this->files));
        }
        return $arr;
    }

    public function getAttachmentImageLink($image)
    {
        $link = '';
        if (in_array($image,$this->filesArray())) {
            $link = asset('uploads/units/'.$this->id.'/'.$image);
        }
        return $link;
    }

    public function filesHtml($type = null)
    {
        $arr = $this->filesArray();
        $html = '';
        if (is_array($arr)) {
            if (count($arr) > 0) {
                foreach ($arr as $key => $value) {
                    $html .= '<div class="col-4" id="row_photo_'.$key.'">';
                    $html .= '<img class="img-fluid rounded my-1" src="'.$this->getAttachmentImageLink($value).'" alt="avatar">';
                    if ($type != 'view') {
                        $html .= '<div class="col-12">';
                        $delete = route('admin.units.deletePhoto',['id'=>$this->id,'photo'=>$value,'X'=>$key]);
                        $html .= '<button type="button" class="btn btn-icon btn-danger" onclick="';
                        $html .= "confirmDelete('".$delete."','photo_".$key."')";
                        $html .= '">';
                        $html .= '<i data-feather="trash-2"></i>';
                        $html .= '</button>';
                        $html .= '</div>';
                    }
                    $html .= '</div>';
                }
            }
        }
        return $html;
    }


}
