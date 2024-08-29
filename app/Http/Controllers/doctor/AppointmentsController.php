<?php

namespace App\Http\Controllers\doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\AppointmentPulses;
use Illuminate\Support\Facades\Response;



class AppointmentsController extends Controller
{


    public function update(Request $request, $id)
    {

        $data = $request->except(['_token','services','area_id','pulses','power']);

        $appointment = Appointment::find($id);
        $update = Appointment::find($id)->update($data);
        $reservation = Reservation::find($appointment->reservation_id);

        $deleteOldPulses = AppointmentPulses::where('appointment_id',$id)->delete();
        if (count($request->pulses) > 0 || count($request->power) > 0) {
            if ($this->containsOnlyNull($request->pulses) != 1 || $this->containsOnlyNull($request->power) != 1) {
                for ($i=0; $i < count($request->pulses); $i++) {
                    $pulse = AppointmentPulses::create([
                        'doctor_id' => auth()->user()->id,
                        'client_id' => $appointment->client_id,
                        'reservation_id' => $appointment->reservation_id,
                        'appointment_id' => $id,
                        'area_id' => $request['area_id'][$i],
                        'pulses' => $request['pulses'][$i],
                        'power' => $request['power'][$i]
                    ]);
                }
            }
        }
        $nowPulses = AppointmentPulses::where('appointment_id',$id)->count();
        if ($nowPulses > 0) {
            $appointment->update([
                'pulses' => $appointment->pulsesTotals()['pulses'],
                'power' => $appointment->pulsesTotals()['power']
            ]);
        }

        if($request->services != '')
        {
            if ( count($request->services) > 0) {
                for ($i=0; $i<count($request->services);$i++) {
                    if ($request['services'][$i] != '') {
                        $service = Service::find($request['services'][$i]);
                        $appointment->services()->syncWithoutDetaching($service);
                        $reservation->services()->syncWithoutDetaching($service);
                    }
                }
            }
        }


        if ($update) {
            return redirect()->back()
                            ->with('success',trans('common.successMessageText'));
        } else {
            return redirect()->back()
                            ->with('faild',trans('common.faildMessageText'));
        }

    }

    public function updateStatus(Request $request, $id)
    {
        $data = $request->except(['_token','servicesId','servicesPrice']);

        $appointment = Appointment::find($id);
        if($appointment->status == 'withDoctor')
        {
            $appointment->status = 'completedSession' ;
            $appointment->save();
        }


        if ($appointment) {
            return redirect()->back()
                            ->with('success',trans('common.successMessageText'));
        } else {
            return redirect()->back()
                            ->with('faild',trans('common.faildMessageText'));
        }

    }

    static function containsOnlyNull($arr)
    {
        return array_reduce($arr, function($carry, $item) {
    		return $carry += (is_null($item) ? 0 : 1);
    	}, 0) > 0 ? false : true;
    }


}
