<?php

namespace App\Http\Controllers\admin\hr;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SalaryRequest;
use Carbon\Carbon;

class SalariesController extends Controller
{
    //
    public function index()
    {
        //check if authenticated
        if (!userCan('employees_account_view') ) {
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
            if (strtotime($value['employment_date']) <= strtotime(date($month.'/1/'.$year))) {
                $usersList[] = $value;
            }
        }

        return view('AdminPanel.hr.salaries.index',[
            'active' => 'salaries',
            'title' => trans('common.salaries'),
            'users' => $usersList,
            'breadcrumbs' => [
                [
                    'url' => '',
                    'text' => trans('common.salaries')
                ]
            ]
        ]);
    }

    public function EmployeeSalary($user_id)
    {
        $month = date('m');
        $year = date('Y');
        if (isset($_GET['month']) && isset($_GET['year'])) {
            if ($_GET['month'] != '' && $_GET['year'] != '') {
                $month = $_GET['month'];
                $year = $_GET['year'];
            }
        }

        $user = User::find($user_id);
        return view('AdminPanel.hr.salaries.view',[
            'active' => 'salaries',
            'title' => trans('common.salaryDetails'),
            'user' => $user,
            'breadcrumbs' => [
                [
                    'url' => route('admin.salaries'),
                    'text' => trans('common.salaries')
                ],
                [
                    'url' => '',
                    'text' => trans('common.salaryDetails').': '.$user->name
                ]
            ]
        ]);
    }

    public function payOutSalary(Request $request, $user_id)
    {
        $month = date('m');
        $year = date('Y');
        if (isset($_GET['month']) && isset($_GET['year'])) {
            if ($_GET['month'] != '' && $_GET['year'] != '') {
                $month = $_GET['month'];
                $year = $_GET['year'];
            }
        }

        $data = $request->except(['_token']);
        $thisUser = User::find($user_id);
        $data['forMonth'] = $month;
        $data['forYear'] = $year;
        $data['month'] = date('m',strtotime($request['Date']));
        $data['year'] = date('Y',strtotime($request['Date']));
        $data['UID'] = auth()->user()->id;
        $data['branch_id'] = $thisUser->branch_id;
        $data['EmployeeID'] = $user_id;

        $user = SalaryRequest::create($data);
        if ($user) {
            return redirect()->back()
                            ->with('success',trans('common.successMessageText'));
        } else {
            return redirect()->back()
                            ->with('faild',trans('common.faildMessageText'));
        }
    }

}
