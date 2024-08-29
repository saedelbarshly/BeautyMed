<?php

namespace App\Http\Controllers\frontend;

use App\Models\Clients;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Service;

class RegistrationsController extends Controller
{
    //
    public function index()
    {
        return view('Frontend.index',[
            'active' => '',
            'title' => trans('common.register')
        ]);
    }


    public function store(Request $request)
    {

        $data = $request->except(['_token','serviceoffer','services']);

        $lastclient = Clients::orderBy('code', 'desc')->first();
        $client = Clients::create([
            'Name' => $request->Name,
            'phone' =>  $request->phone,
            'code' => $lastclient->code+1,
            'date' => date('Y-m-d')
        ]);
        $reservation = Reservation::create([
            'doctor_id' => $request->doctor_id,
            'client_id' => $client->id,
            'offer_id' => $request->offer_id,
            'date' =>  $request->date,
            'time' =>  $request->date,
        ]);
        $reservation->dateStr= strtotime($reservation->date);
        $reservation->save();

        if($request->services != '')
        {
            if ( count($request->services) > 0) {
                for ($i=0; $i<count($request->services);$i++) {
                    if ($request['services'][$i] != '') {
                        $service = Service::find($request['services'][$i]);
                        $reservation->services()->attach($service);
                    }
                }
            }
        }

        if ($reservation) {
            return redirect()->back()
                            ->with('success',trans('common.successMessageText'));
        } else {
            return redirect()->back()
                            ->with('faild',trans('common.faildMessageText'));
        }


    }



}
