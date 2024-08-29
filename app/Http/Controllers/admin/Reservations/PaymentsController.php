<?php

namespace App\Http\Controllers\admin\Reservations;

use App\Models\Expenses;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Reservation;
use App\Models\Payment;
use App\Models\Revenues;

class PaymentsController extends Controller
{


    public function store(Request $request)
    {
        if (!userCan('payments_create')) {
            return redirect()->back()
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }

        $data = $request->except(['_token','serviceoffer','services']);
        $reservation = Reservation::find($request->reservation_id);

        if ($request->amount < $reservation->totals()['net']) { 
            return redirect()->back()
                            ->with('faild',trans('common.faildMessageText'));
        }

        $data['DateStr'] = strtotime($request['Date']);
        $data['month'] = date('m',strtotime($request['Date']));
        $data['year'] = date('Y',strtotime($request['Date']));
       
        $payment = Revenues::create($data);
    
        if ($payment) {

        $commissionPayment = Expenses::create([
            'Expense' => (($payment->safe->commission) / 100 ) * $payment->amount ,
            'safe_id' => $payment->safe->id ,
            'ExpenseDate' =>$request['Date'],
            'UID' => auth()->user()->id,
            'Type' => 'withdrawal',
            'month' => date('m',strtotime($request['Date'])),
            'year' => date('Y',strtotime($request['Date'])),
        ]);
            return redirect()->back()
                            ->with('success',trans('common.successMessageText'));
        } else {
            return redirect()->back()
                            ->with('faild',trans('common.faildMessageText'));
        }


    }

    public function delete($id)
    {
        if (!userCan('payments_delete')) {
            return Response::json("false");
        }
        $payment = Revenues::find($id);
        if ($payment->delete()) {
            return Response::json($id);
        }
        return Response::json("false");
    }


}
