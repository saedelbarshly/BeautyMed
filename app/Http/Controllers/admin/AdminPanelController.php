<?php

namespace App\Http\Controllers\admin;

use App\Models\Appointment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\users\UpdateUser;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Validator;

use App\Models\User;
use Auth;

class AdminPanelController extends Controller
{
    //
    public function index()
    {

        if (!userCan('home_view')) {
            return redirect()->back()
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }

        return view('AdminPanel.index',[
            'active' => 'panelHome',
            'title' => trans('common.Admin Panel'),

        ]);
    }

    public function EditProfile()
    {
        return view('AdminPanel.loggedinUser.my-profile',[
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


    public function EditPassword()
    {
        return view('AdminPanel.loggedinUser.my-password',[
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
            return redirect()->route('admin.myProfile')
                            ->with('success',trans('common.successMessageText'));
        } else {
            return redirect()->back()
                            ->with('faild',trans('common.faildMessageText'));
        }

    }

    public function notificationDetails($id)
    {
        $Notification = DatabaseNotification::find($id);
        $Notification->markAsRead();

        if (in_array($Notification['data']['type'], ['newPublisher'])) {
            return redirect()->route('admin.publisherUsers.edit',['id'=>$Notification['data']['linked_id']]);
        }
        if (in_array($Notification['data']['type'], ['newPublisherMessage'])) {
            return redirect()->route('admin.contactmessages.details',['id'=>$Notification['data']['linked_id']]);
        }

        return redirect()->back();
    }

    public function readAllNotifications()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return back();
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
        return view('AdminPanel.hr.salaries.view',[
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

}
