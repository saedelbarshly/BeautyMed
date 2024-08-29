<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Revenues extends Model
{
    protected $guarded = [];
    public function typeText()
    {
        return revenuesTypes(session()->get('Lang'))[$this->Type];
    }

    public function responsible()
    {
        return $this->belongsTo(User::class,'UID');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'UID');
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class,'reservation_id');
    }

    public function client()
    {
        return $this->belongsTo(Clients::class,'client_id');
    }

    public function safe()
    {
        return $this->belongsTo(SafesBanks::class,'safe_id');
    }

    public function FilesArray()
    {
        $arr = [];
        if ($this->Files != '') {
            $arr = unserialize(base64_decode($this->Files));
        }
        return $arr;
    }

    public function getAttachmentImageLink($image)
    {
        $link = '';
        if (in_array($image,$this->FilesArray())) {
            $link = asset('uploads/revenues/'.$this->id.'/'.$image);
        }
        return $link;
    }

    public function attachmentsHtml()
    {
        $arr = $this->FilesArray();
        $html = '';
        if (is_array($arr)) {
            if (count($arr) > 0) {
                foreach ($arr as $key => $value) {
                    $html .= '<div class="col-3" id="row_photo_'.$key.'">';
                    $html .= '<img class="img-fluid rounded my-1" src="'.$this->getAttachmentImageLink($value).'" alt="avatar" height="90" width="90">';
                    $html .= '<div class="col-12">';
                    $delete = route('admin.revenues.deletePhoto',['id'=>$this->id,'photo'=>$value,'X'=>$key]);
                    $html .= '<button type="button" class="btn btn-icon btn-danger" onclick="';
                    $html .= "confirmDelete('".$delete."','photo_".$key."')";
                    $html .= '">';
                    $html .= '<i data-feather="trash-2"></i>';
                    $html .= '</button>';
                    $html .= '</div>';
                    $html .= '</div>';
                }
            }
        }
        return $html;
    }
}
