<?php

namespace App\Http\Controllers\doctor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DoctorLoginController extends Controller
{
    //
    public function login()
    {
        return view('DoctorPanel.auth.login',[
            'active' => '',
            'title' => trans('common.Sign in')
        ]);
    }
}
  