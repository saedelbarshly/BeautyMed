<?php

namespace App\Http\Controllers\admin\Reservations;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\AppointmentMore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Reservation;
use App\Models\Service;

class AppointmentsController extends Controller
{
    public function index($id)
    {
        if (!userCan('appointments_view')) {
            return redirect()->route('admin.index')
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }

        $appointments = Appointment::with('reservation','doctor')->where('reservation_id',$id)->where('status','!=','withDoctor')->where('status','!=','completedSession')->orderBy('id','desc')->paginate(25);
        $reservation = Reservation::find($id);

        return view('AdminPanel.appointments.index',[  
            'active' => 'appointments',
            'title' => trans('common.appointments'),
            'appointments' => $appointments,
            'reservation' => $reservation,
            'breadcrumbs' => [
                [
                    'url' => '',
                    'text' => trans('common.appointments')
                ]
            ]
        ]);
    }


    public function store(Request $request, $id)
    {
        if (!userCan('appointments_create')) {
            return redirect()->back()
                ->with('faild', trans('common.youAreNotAuthorized'));
        }

        $data = $request->except(['_token', 'serviceoffer', 'services','area_id','power','pulses']);
        $appointment = Appointment::create($data);
        $reservation = Reservation::find($id);

        if ($request->services != '') {
            if (count($request->services) > 0) {
                for ($i = 0; $i < count($request->services); $i++) {
                    if ($request['services'][$i] != '') {
                        $service = Service::find($request['services'][$i]);
                        $appointment->services()->attach($service, ['date' => $request['date'], 'hour' => $request['hour'] . ':00']);
                        $reservation->services()->syncWithoutDetaching($service);
                    }
                }
            }
        }

        if ($appointment) {
            for($i = 0; $i < count($request->power); $i++)
            {
                if($request['area_id'][$i] != '' && $request['pulses'][$i] != '' && $request['power'][$i] != '')
                {
                    $more = AppointmentMore::create([
                        'appointment_id' => $appointment['id'],
                        'area_id' => $request['area_id'][$i],
                        'pulses' => $request['pulses'][$i],
                        'power' => $request['power'][$i],
                    ]);
                }
            }
            return redirect()->back()->with('success', trans('common.successMessageText'));
        } else {
            return redirect()->back()
                ->with('faild', trans('common.faildMessageText'));
        }
    }


    public function update(Request $request, $id,$id1)
    {
        if (!userCan('appointments_edit')) {
            return redirect()->back()
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }
        $data = $request->except(['_token','services','area_id','power','pulses']);

        $appointment = Appointment::find($id);
        $update = Appointment::find($id)->update($data);
        $reservation = Reservation::find($id1);

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
            $more = [];
            if(($request->power) != '')
            {
                for($i =0; $i < count($request->power); $i++)
                {
                    if($request['area_id'][$i] != '' && $request['pulses'][$i] != '' && $request['power'][$i] != '')
                    {
                        $more [] = [
                            'appointment_id' => $appointment['id'],
                            'area_id' => $request['area_id'][$i],
                            'pulses' => $request['pulses'][$i],
                            'power' => $request['power'][$i],
                        ];
                    }
                    if(count($more) > 0)
                    {
                        $appointment->appointmentMore()->delete();
                        foreach($more as $value)
                        {
                            $appointmentSet = AppointmentMore::create([
                                'appointment_id' => $appointment['id'],
                                'area_id' => $value['area_id'],
                                'pulses' => $value['pulses'],
                                'power' => $value['power'],
                            ]);
                        }
                    }
                }
            }
            return redirect()->back()
                            ->with('success',trans('common.successMessageText'));
        } else {
            return redirect()->back()
                            ->with('faild',trans('common.faildMessageText'));
        }
    }

    public function updateStatus(Request $request, $id)
    {
        if (!userCan('appointments_status_edit')) {
            return redirect()->back()
                                 ->with('faild',trans('common.youAreNotAuthorized'));
        }
        $data = $request->except(['_token','servicesId','servicesPrice']);

        $appointment = Appointment::find($id);
        if($appointment->status == 'pending')
        {
            $appointment->status = 'inClinic' ;
            $appointment->save();
        }
        elseif($appointment->status == 'inClinic')
        {
            $appointment->status = 'withDoctor' ;
            $appointment->save();
        }
        elseif($appointment->status =='withDoctor')
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

    public function delete($id)
    {
        if (!userCan('appointments_delete')) {
            return Response::json("false");
        }
        $appointment = Appointment::find($id);
        if ($appointment->delete()) {
            return Response::json($id);
        }
        return Response::json("false");
    }

    public function getAvailableTimes(Request $request)
    {
        $data = $request->except(['_token']);
        $date = $data['date'] ?? null;
        $services = $data['services'] ?? null;
        $offer = $data['offer'] ?? null;
        return availableWorkHours($date,$services,$offer);
    }

}
