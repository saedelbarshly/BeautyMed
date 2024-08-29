<?php

namespace App\Http\Controllers\admin\Reservations;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use App\Models\Reservation;
use App\Models\Service;
use App\Models\Clients;
use App\Models\ReservationServices;
use App\Models\Appointment;
use App\Models\TransformationPayment;
use App\Models\TransformationPulses;

class ReservationsController extends Controller
{

    public function index()
    {
        if (!userCan('reservations_view')) {  
            return redirect()->route('admin.index')
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }

        $reservations = Reservation::with('doctor','client')->orderBy('id','desc')->paginate(25);
        $clients = Clients::orderBy('id','desc');

        return view('AdminPanel.reservations.index',[
            'active' => 'reservations',
            'title' => trans('common.reservations'),
            'reservations' => $reservations,
            'clients' => $clients ,
            'breadcrumbs' => [
                [
                    'url' => '',
                    'text' => trans('common.reservations')
                ]
            ]
        ]);
    }


    public function store(Request $request)
    {

        if (!userCan('reservations_create')) {
            return redirect()->back()
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }

        $data = $request->except(['_token','serviceoffer','services','hour']);
        // dd($data);
        $reservation = Reservation::create($data);
        $reservation->dateStr= strtotime($reservation->date);
        $reservation->save();

        $data['hour'] = $request['hour'].':00';
        $data['reservation_id'] = $reservation['id'];
        $data['status'] = 'pending';
        $appointment = Appointment::create($data);

        if($request->services != '')
        {
            if ( count($request->services) > 0) {
                for ($i=0; $i<count($request->services);$i++) {
                    if ($request['services'][$i] != '') {
                        $service = Service::find($request['services'][$i]);
                        $appointment->services()->attach($service,['date'=>$request['date'],'hour'=>$request['hour'].':00']);
                        $reservation->services()->attach($service, ['client_id'=> $request['client_id']]);
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


    public function update(Request $request, $id)
    {
        if (!userCan('reservations_edit')) {
            return redirect()->back()
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }
        $data = $request->except(['_token','serviceoffer','services']);

        $reservation = Reservation::find($id);
        $update = Reservation::find($id)->update($data);
        $services = Service::get();

        foreach($reservation->services as $service)
        {
            $reservation->services()->detach($service);
        }

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
        if (!userCan('reservations_status_edit')) {
            return redirect()->back()
                                 ->with('faild',trans('common.youAreNotAuthorized'));
        }
        $data = $request->except(['_token','servicesId','servicesPrice']);

        $reservation = Reservation::find($id);
        if($reservation->status == 0)
        {
            $reservation->status = 1 ;
            $reservation->save();
        }
        else
        {
            $reservation->status = 0 ;
            $reservation->save();
        }

        if ($reservation) {
            return redirect()->back()
                            ->with('success',trans('common.successMessageText'));
        } else {
            return redirect()->back()
                            ->with('faild',trans('common.faildMessageText'));
        }

    }


    public function movePulses(Request $request)   
    {
       
        if (!userCan('reservations_pulses_move')) {
            return redirect()->back()
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }

        $data = $request->except(['_token']);
        $reservationReceiverId = Reservation::where('client_id',$request->clientReceiver_id)->latest()->first()->id; 
        $reservationSenderId = Reservation::find($request->reservationSender_id);
        if($reservationReceiverId && $request->pulses <= $reservationSenderId->totals()['net_pulses'])
        {
            $data['reservationReceiver_id'] = $reservationReceiverId;
            $data['date'] = date('Y-m-d') ;
            $transformationpulses = TransformationPulses::create($data);
            if ($transformationpulses) {
                return redirect()->back()
                                ->with('success',trans('common.successMessageText'));
            } else {
                return redirect()->back()
                                ->with('faild',trans('common.faildMessageText'));
            }
        }
        else
        {
            return redirect()->back()
            ->with('faild',trans('common.faildMessageText'));
        }


    }


    public function movePayment(Request $request)
    {
        if (!userCan('reservations_payment_move')) {
            return redirect()->back()
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }

        $data = $request->except(['_token']);

        $reservationReceiverId = Reservation::find($request->reservationReceiver_id);
        if(!$reservationReceiverId)
        {
            return redirect()->back()
                            ->with('faild',trans('common.faildMessageText'));

        }

        $data['clientReceiver_id'] = $reservationReceiverId->client->id ;
        $data['date'] = date('Y-m-d') ;
        $transformationpayment = TransformationPayment::create($data);

        if ($transformationpayment) {
            return redirect()->back()
                            ->with('success',trans('common.successMessageText'));
        } else {
            return redirect()->back()
                            ->with('faild',trans('common.faildMessageText'));
        }
    }



    public function filterReservations()
    {
        if (!userCan('reservations_filter')) {
            return redirect()->route('admin.index')
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }

        $reservations = Reservation::orderBy('id','desc');

        if (isset($_GET['doctor_id'])) {
            if ($_GET['doctor_id'] != 'all') {
                $reservations = $reservations->where('doctor_id',$_GET['doctor_id']);
            }
        }

        if (isset($_GET['offer_id'])) {
            if ($_GET['offer_id'] != 'all') {
                $reservations = $reservations->where('offer_id',$_GET['offer_id']);
            }
        }

        if (isset($_GET['service_id'])) {
            if ($_GET['service_id'] != 'all') {
                $services = ReservationServices::where('service_id',$_GET['service_id'])->get();
                $reservationsIds = [];
                foreach ($services as $service) {
                    $reservationsIds[] = $service->reservation_id;
                }
                $reservations = $reservations->whereIn('id',$reservationsIds);
            }
        }


        if (isset($_GET['status'])) {
            if ($_GET['status'] != '') {
                $reservations = $reservations->where('status',$_GET['status']);
            }
        }
        if (isset($_GET['from_date'])) {
            if ($_GET['from_date'] != '') {
                $reservations = $reservations->where('dateStr','>=',strtotime($_GET['from_date']));
            }
        }
        if (isset($_GET['to_date'])) {
            if ($_GET['to_date'] != '') {
                $reservations = $reservations->where('dateStr','<=',strtotime($_GET['to_date']));
            }
        }
        $reservations = $reservations->paginate(20);
        return view('AdminPanel.reservations.index', [
            'title' => trans('common.reservations'),
            'active' => 'reservations',
            'reservations' => $reservations,
            'breadcrumbs' => [
                [
                    'url' => '',
                    'text' => trans('common.clients')
                ]
            ]
        ]);
    }


    public function delete($id)
    {
        if (!userCan('reservations_delete')) {
            return Response::json("false");
        }

        $reservation = Reservation::find($id);
        foreach($reservation->services as $service)
        {
            $reservation->services()->detach($service);
        }


        if ($reservation->delete()) {
            return Response::json($id);
        }
        return Response::json("false");
    }



}
