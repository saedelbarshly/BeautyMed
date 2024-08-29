<?php

namespace App\Http\Controllers\doctor;

use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Reservation;
use App\Models\Service;
use Auth;
use Carbon\Carbon;


class DoctorPanelController extends Controller
{
    public function index()
    {
        $appointments = Appointment::where('date',date('Y-m-d'))
                                    ->where([
                                        'status'=>'withDoctor',
                                        'doctor_id'=>auth()->user()->id
                                    ])->paginate(25);

        return view('DoctorPanel.index',[
            'active' => 'panelHome',
            'appointments' => $appointments,
            'title' => trans('common.appointmentClient'),

        ]);
    }


    public function EditProfile()
    {

        return view('DoctorPanel.loggedinUser.my-profile',[
            'active' => 'my-profile',
            'title' => trans('common.Profile'),
            'breadcrumbs' => [
                                [
                                    'url' => '',
                                    'text' => trans('common.Account')
                                ]
                            ]
        ]);
    }


    public function UpdateProfile(Request $request)
    {

        $data = $request->except(['_token','photo']);
        // return $data;
        if ($request->photo != '') {
            if (auth()->user()->photo != '') {
                delete_image('users/'.auth()->user()->id , auth()->user()->photo);
            }
            $data['photo'] = upload_image_without_resize('users/'.auth()->user()->id , $request->photo );
        }

        $update = User::find(auth()->user()->id)->update($data);
        if ($update) {
            return redirect()->route('doctor.myProfile')
                            ->with('success',trans('common.successMessageText'));
        } else {
            return redirect()->back()
                            ->with('faild',trans('common.faildMessageText'));
        }

    }


    public function EditPassword()
    {

        return view('DoctorPanel.loggedinUser.my-password',[
            'active' => 'my-password',
            'title' => trans('common.password'),
            'breadcrumbs' => [
                                [
                                    'url' => '',
                                    'text' => trans('common.Security')
                                ]
                            ]
        ]);
    }

    public function updatePassword(Request $request)
    {
        $data = $request->except(['_token','password_confirmation']);

        $rules = [
                    'password' => 'required|confirmed',
                ];
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails())
        {
            return redirect()->back()
                            ->withErrors($validator)
                            ->with('faild',trans('common.faildMessageText'));
        }
        $data['password'] = bcrypt($request['password']);

        $update = User::find(auth()->user()->id)->update($data);

        if ($update) {
            return redirect()->back()
                            ->with('success',trans('common.successMessageText'));
        } else {
            return redirect()->back()
                            ->with('faild',trans('common.faildMessageText'));
        }

    }



    public function mySalary()
    {
        $month = date('m');
        $year = date('Y');
        if (isset($_GET['month']) && isset($_GET['year'])) {
            if ($_GET['month'] != '' && $_GET['year'] != '') {
                $month = $_GET['month'];
                $year = $_GET['year'];
            }
        }

        $user = User::find(auth()->user()->id);
        return view('DoctorPanel.hr.salaries.view',[
            'active' => 'mySalary',
            'title' => trans('common.mySalary'),
            'user' => $user,
            'breadcrumbs' => [
                [
                    'url' => '',
                    'text' => trans('common.mySalary')
                ]
            ]
        ]);
    }


    public function notificationDetails($id)
    {
        $Notification = DatabaseNotification::find($id);
        $Notification->markAsRead();

        if (in_array($Notification['data']['type'], ['newPublisher'])) {
            return redirect()->route('doctor.publisherUsers.edit',['id'=>$Notification['data']['linked_id']]);
        }
        if (in_array($Notification['data']['type'], ['newPublisherMessage'])) {
            return redirect()->route('doctor.contactmessages.details',['id'=>$Notification['data']['linked_id']]);
        }

        return redirect()->back();
    }

    public function readAllNotifications()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return back();
    }


}
