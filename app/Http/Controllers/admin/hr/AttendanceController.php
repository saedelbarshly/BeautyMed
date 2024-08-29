<?php

namespace App\Http\Controllers\admin\hr;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attendance;
use App\Imports\AttendanceImport;
use App\Models\AttendanceVacations;
use App\Models\AttendancePermissions;
use Maatwebsite\Excel\Facades\Excel;
use Response;

class AttendanceController extends Controller
{
    public function index()
    {
        //check if authenticated
        if (!userCan('attendance_view')) {
            return redirect()->route('admin.index')
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }

        //filter by employment date
        $month = date('m');
        $year = date('Y');
        if (isset($_GET['month']) && isset($_GET['year'])) {
            if ($_GET['month'] != '' && $_GET['year'] != '') {
                $month = $_GET['month'];
                $year = $_GET['year'];
            }
        }

        //filter by day date
        $date = date('Y-m-d');
        if (isset($_GET['date'])) {
            if ($_GET['date'] != '') {
                $date = $_GET['date'];
            }
        }

        //select from DB
        $users = User::orderBy('name','asc');

        //if not allowed to view all just return his branch employees
        if (!userCan('employees_account_view')) {
            $users = $users->where('branch_id',auth()->user()->branch_id);
        } else {
            //filter by branch
            if (isset($_GET['branch_id'])) {
                if ($_GET['branch_id'] != 'all') {
                    $users = $users->where('branch_id',$_GET['branch_id']);
                }
            }
        }
        //filter by status
        if (isset($_GET['status'])) {
            if ($_GET['status'] != 'all') {
                $users = $users->where('status',$_GET['status']);
            }
        } else {
            $users = $users->where('status','Active');
        }

        if (isset($_GET['role'])) {
            if ($_GET['role'] != 'all') {
                $users = $users->where('role',$_GET['role']);
            }
        }


        $users = $users->get();

        $usersList = [];
        foreach ($users as $key => $value) {
            if (strtotime($value['employment_date']) <= strtotime(date($year.'-'.$month.'-28'))) {
                $usersList[] = $value;
            }
        }

        return view('AdminPanel.hr.attendance.index',[
            'active' => 'attendance',
            'title' => trans('common.attendanceList'),
            'users' => $usersList,
            'breadcrumbs' => [
                [
                    'url' => '',
                    'text' => trans('common.attendanceList').': '.$date
                ]
            ]
        ]);
    }

    public function SubmitNewAttendance(Request $request)
    {
        $branch_id = request()->branch_id;
        $this->validate($request, array(
            'file'      => 'required|file|max:50000|mimes:xlsx'
        ));

        Excel::import(new AttendanceImport($branch_id), request()->file('file'));
        return redirect()->back()
                        ->with('success',trans('common.successMessageText'));

    }

    public function AddVacation(Request $request, $user_id)
    {
        $data = $request->except(['_token']);
        $thisUser = User::find($user_id);
        $data['daysList'] = base64_encode(serialize(getDatesFromRange($request['from'], $request['to'])));
        $data['month'] = date('m',strtotime($request['from']));
        $data['year'] = date('Y',strtotime($request['from']));
        $data['UID'] = auth()->user()->id;
        $data['EmployeeID'] = $user_id;
        $data['status'] = 'done';

        $create = AttendanceVacations::create($data);
        if ($create) {
            return redirect()->back()
                            ->with('success',trans('common.successMessageText'));
        } else {
            return redirect()->back()
                            ->with('faild',trans('common.faildMessageText'));
        }
    }

    public function DeleteVacation($id)
    {
        if (!userCan('attendance_vacation_delete')) {
            return Response::json("false");
        }
        $service = AttendanceVacations::find($id);
        if ($service->delete()) {
            return Response::json($id);
        }
        return Response::json("false");
    }


    public function AddPermission(Request $request, $user_id)
    {
        $data = $request->except(['_token']);
        $thisUser = User::find($user_id);
        $data['month'] = date('m',strtotime($request['day']));
        $data['year'] = date('Y',strtotime($request['day']));
        $data['UID'] = auth()->user()->id;
        $data['EmployeeID'] = $user_id;
        $data['status'] = 'done';

        $create = AttendancePermissions::create($data);
        if ($create) {
            return redirect()->back()
                            ->with('success',trans('common.successMessageText'));
        } else {
            return redirect()->back()
                            ->with('faild',trans('common.faildMessageText'));
        }
    }
    public function DeletePermission($id)
    {
        if (!userCan('attendance_permission_delete')) {
            return Response::json("false");
        }
        $service = AttendancePermissions::find($id);
        if ($service->delete()) {
            return Response::json($id);
        }
        return Response::json("false");
    }


    public function employeeAttend($user_id,$date)
    {
        $thisUser = User::find($user_id);
        $DA = Attendance::where('EmployeeID',$user_id)->where('Date',$date)->first();
        if ($DA == '') {
            $DA = Attendance::create([
                //
                'UID' => auth()->user()->id,
                'EmployeeID' => $thisUser['id'],
                'EmployeeType' => 'Managment',
                'branch_id' => $thisUser->branch_id,
                'zk_id' => $thisUser['zk_id'],
                'Date' => $date,
                'month' => date('m',strtotime($date)),
                'year' => date('Y',strtotime($date)),
                'CheckIn' => date('H:i:s'),
                'late' => $thisUser->lateCalculator(date('H:i:s')),
                'CheckOut' => NULL,
                'OverTime' => NULL
            ]);
        }

        if ($DA) {
            return redirect()->back()
                            ->with('success',trans('common.successMessageText'));
        } else {
            return redirect()->back()
                            ->with('faild',trans('common.faildMessageText'));
        }
    }

    public function employeeGo($user_id,$date)
    {
        $thisUser = User::find($user_id);
        $DA = Attendance::where('EmployeeID',$user_id)->where('Date',$date)->first();
        if ($DA != '') {
            $DA->update([
                //
                'CheckOut' => date('H:i:s'),
                'OverTime' => $thisUser->overtimeCalculator(date('H:i:s'))
            ]);
        }

        if ($DA) {
            return redirect()->back()
                            ->with('success',trans('common.successMessageText'));
        } else {
            return redirect()->back()
                            ->with('faild',trans('common.faildMessageText'));
        }
    }
}
