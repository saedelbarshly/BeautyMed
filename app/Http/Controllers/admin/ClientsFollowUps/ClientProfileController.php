<?php

namespace App\Http\Controllers\admin\ClientsFollowUps;

use App\Models\Clients;
use App\Models\Complaint;
use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Revenues;
use App\Models\Expenses;
use Illuminate\Http\Request;

class ClientProfileController extends Controller
{
    public function showProfile($id)
    {
        if (!userCan('profile_view')) {
            return redirect()->route('admin.index')
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }

        $client = Clients::find($id);
        $reservations = Reservation::where(['client_id'=>$id])->orderBy('id','desc')->paginate(25);
        $complaints = Complaint::where(['client_id'=>$id])->orderBy('id','desc')->paginate(25);
        $payments = Revenues::where(['client_id'=>$id])->orderBy('id','desc')->paginate(25);
        $cashPack = Expenses::where(['client_id'=>$id])->orderBy('id','desc')->paginate(25);


        return view('AdminPanel.clients.profile',[
            'active' => 'profile',
            'title' => trans('common.profile'),
            'client' => $client,
            'reservations' => $reservations,
            'complaints' => $complaints,
            'payments' => $payments,
            'cashPack' => $cashPack,
            'breadcrumbs' => [
                [
                    'url' => '',
                    'text' => trans('common.profile')
                ]
            ]
        ]);
    }


}
