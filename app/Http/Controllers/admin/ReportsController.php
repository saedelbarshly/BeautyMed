<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Expenses;
use App\Models\Revenues;
use App\Models\User;

class ReportsController extends Controller
{
    //
    public function accountsReport()
    {
        //check if authenticated
        if (!userCan('reports_accounts_view') && !userCan('reports_accounts_view_branch')) {
            return redirect()->route('admin.index')
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }
        return view('AdminPanel.reports.accounts',[
            'active' => 'accountsReport',
            'title' => trans('common.accountsReport'),
            'breadcrumbs' => [
                [
                    'url' => '',
                    'text' => trans('common.accountsReport')
                ]
            ]
        ]);
    }
    public function userFollowUpsReport()
    {
        //check if authenticated
        if (!userCan('followups_view') && !userCan('followups_view_branch') && !userCan('followups_view_team') && !userCan('followups_view_mine_only')) {
            return redirect()->route('admin.index')
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }
        $user = auth()->user();
        if (isset($_GET['agent_id'])) {
            if ($_GET['agent_id'] != '') {
                $user = User::find($_GET['agent_id']);
                if ($user == '') {
                    return redirect()->route('admin.index')
                                        ->with('faild',trans('common.userNotFound'));
                }
            }
        }

        return view('AdminPanel.reports.followups.user',[
            'active' => 'userFollowUpsReport',
            'title' => trans('common.userFollowUpsReport'),
            'user' => $user,
            'breadcrumbs' => [
                [
                    'url' => '',
                    'text' => trans('common.userFollowUpsReport')
                ]
            ]
        ]);
    }
    public function teamFollowUpsReport()
    {
        //check if authenticated
        if (!userCan('followups_view') && !userCan('followups_view_branch') && !userCan('followups_view_team')) {
            return redirect()->route('admin.index')
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }

        return view('AdminPanel.reports.followups.team',[
            'active' => 'teamFollowUpsReport',
            'title' => trans('common.teamFollowUpsReport'),
            'breadcrumbs' => [
                [
                    'url' => '',
                    'text' => trans('common.teamFollowUpsReport')
                ]
            ]
        ]);
    }
    public function branchFollowUpsReport()
    {
        //check if authenticated
        if (!userCan('followups_view') && !userCan('followups_view_branch')) {
            return redirect()->route('admin.index')
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }

        return view('AdminPanel.reports.followups.branch',[
            'active' => 'branchFollowUpsReport',
            'title' => trans('common.branchFollowUpsReport'),
            'breadcrumbs' => [
                [
                    'url' => '',
                    'text' => trans('common.branchFollowUpsReport')
                ]
            ]
        ]);
    }
}
