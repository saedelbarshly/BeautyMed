<?php

namespace App\Http\Controllers\doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Clients;
use App\Models\Complaint;
use App\Models\Reservation;
use App\Models\Revenues;

class ClientsController extends Controller
{
    public function details($id)
    {
        $client = Clients::find($id);
        $reservations = Reservation::where(['client_id'=>$id])->orderBy('id','desc')->paginate(25);
        $complaints = Complaint::where(['client_id'=>$id])->orderBy('id','desc')->paginate(25);


        return view('DoctorPanel.clients.profile',[
            'active' => 'profile',
            'title' => trans('common.profile'),
            'client' => $client,
            'reservations' => $reservations,
            'complaints' => $complaints,
            'breadcrumbs' => [
                [
                    'url' => '',
                    'text' => trans('common.profile')
                ]
            ]
        ]);
    }
}
