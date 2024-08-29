<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmploymentProfile extends Model
{
    //
    protected $guarded = [];
    public function qualificationsArr()
    {
        $arr = [];
        if ($this->qualifications != '') {
            $arr = unserialize(base64_decode($this->qualifications));
        }
        return $arr;
    }
    public function experienceArr()
    {
        $arr = [];
        if ($this->experience != '') {
            $arr = unserialize(base64_decode($this->experience));
        }
        return $arr;
    }

    public function toGetChoiceData($input,$choice = null)
    {
        $list = [
            'checked' => false,
            'status' => isset($db_data['status']) ? $db_data['status'] : '',
            'text' => isset($db_data['text']) ? $db_data['text'] : ''
        ];
        if ($this->$input != '') {
            if (strlen($this->$input > 1)) {
                $db_data = unserialize(base64_decode($this->$input));
                if ($choice != null) {
                    if (isset($db_data['status'])) {
                        if ($choice == $db_data['status']) {
                            $list['checked'] = true;
                        }
                    } else {
                        if (in_array($choice , $db_data)) {
                            $list['checked'] = true;
                        }
                    }
                }
            } elseif ($choice == $this->$input) {
                $list['checked'] = true;
            }
        }
        return $list;
    }

    public function salaryType($choice = null)
    {
        $db_data = unserialize(base64_decode($this->salary_type));
        $list = [
            'checked' => false
        ];
        if ($this->salary_type != '') {
            if (strlen($this->salary_type > 1)) {
                $db_data = unserialize(base64_decode($this->salary_type));
                if ($choice != null) {
                    if (in_array($choice , $db_data)) {
                        $list['checked'] = true;
                    }
                }
            }
        }
        return $list;
    }


    public function attachmentsArray()
    {
        $arr = [];
        if ($this->attachments != '') {
            $arr = unserialize(base64_decode($this->attachments));
        }
        return $arr;
    }

    public function getAttachmentImageLink($image)
    {
        $link = '';
        if (in_array($image,$this->attachmentsArray())) {
            $link = asset('uploads/users/'.$this->EmployeeID.'/'.$image);
        }
        return $link;
    }

    public function attachmentsHtml($type = null)
    {
        $arr = $this->attachmentsArray();
        $html = '';
        if (is_array($arr)) {
            if (count($arr) > 0) {
                foreach ($arr as $key => $value) {
                    $html .= '<div class="col-4" id="row_photo_'.$key.'">';
                    $html .= '<img class="img-fluid rounded my-1" src="'.$this->getAttachmentImageLink($value).'" alt="avatar">';
                    if ($type != 'view') {
                        $html .= '<div class="col-12">';
                        $delete = route('admin.users.deletePhoto',['id'=>$this->EmployeeID,'photo'=>$value,'X'=>$key]);
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
