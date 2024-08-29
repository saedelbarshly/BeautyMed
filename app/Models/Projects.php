<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    //
    protected $guarded = [];
    public function governorate()
    {
        return $this->belongsTo(Governorates::class,'GovernorateID');
    }
    public function city()
    {
        return $this->belongsTo(Cities::class,'CityID');
    }
    public function companyData()
    {
        return $this->belongsTo(ProjectCompanies::class,'company');
    }
    public function locationData()
    {
        return $this->belongsTo(ProjectLocations::class,'location');
    }
    public function type()
    {
        $arr = [
            'housing' => 'سكني',
            'commercial' => 'تجاري',
            'Administrative' => 'إداري',
            'all' => 'شامل'
        ];
        if (!isset($arr[$this->type])) {
            return $this->type;
        }
        return $arr[$this->type];
    }
    public function units()
    {
        return $this->hasMany(Units::class,'ProjectID');
    }



    public function imagesArray()
    {
        $arr = [];
        if ($this->images != '') {
            $arr = unserialize(base64_decode($this->images));
        }
        return $arr;
    }

    public function getAttachmentImageLink($image)
    {
        $link = '';
        if (in_array($image,$this->imagesArray())) {
            $link = asset('uploads/projects/'.$this->id.'/'.$image);
        }
        return $link;
    }

    public function imagesHtml($type = null)
    {
        $arr = $this->imagesArray();
        $html = '';
        if (is_array($arr)) {
            if (count($arr) > 0) {
                foreach ($arr as $key => $value) {
                    $html .= '<div class="col-4" id="row_photo_'.$key.'">';
                    $html .= '<img class="img-fluid rounded my-1" src="'.$this->getAttachmentImageLink($value).'" alt="avatar">';
                    if ($type != 'view') {
                        $html .= '<div class="col-12">';
                        $delete = route('admin.projects.deletePhoto',['id'=>$this->id,'photo'=>$value,'X'=>$key]);
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
