<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expenses extends Model
{
    //
    protected $guarded = [];

    public function typeText()
    {
        $text = $this->Type;
        if (isset(expensesTypes(session()->get('Lang'))[$this->Type])) {
            $text = expensesTypes(session()->get('Lang'))[$this->Type];
        }

        return $text;
    }

    public function responsible()
    {
        return $this->belongsTo(User::class,'UID');
    }


    public function attachmentsArray()
    {
        $arr = [];
        if ($this->Attachments != '') {
            $arr = unserialize(base64_decode($this->Attachments));
        }
        return $arr;
    }

    public function getAttachmentImageLink($image)
    {
        $link = '';
        if (in_array($image,$this->attachmentsArray())) {
            $link = asset('uploads/expenses/'.$this->id.'/'.$image);
        }
        return $link;
    }

    public function attachmentsHtml()
    {
        $arr = $this->attachmentsArray();
        $html = '';
        if (is_array($arr)) {
            if (count($arr) > 0) {
                foreach ($arr as $key => $value) {
                    $html .= '<div class="col-3" id="row_photo_'.$key.'">';
                    $html .= '<img class="img-fluid rounded my-1" src="'.$this->getAttachmentImageLink($value).'" alt="avatar" height="90" width="90">';
                    $html .= '<div class="col-12">';
                    $delete = route('admin.expenses.deletePhoto',['id'=>$this->id,'photo'=>$value,'X'=>$key]);
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

    public function expenseType()
    {
        return $this->belongsTo(ExpensesTypes::class,'type');
    }
}
