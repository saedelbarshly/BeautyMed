<?php

namespace App\Http\Controllers\admin\ClientsFollowUps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Clients;
use App\Models\ClientFollowUps;
use Response;

class FollowUpsController extends Controller
{
    public function index()
    {
        if (!userCan('followups_view') && !userCan('followups_view_branch') && !userCan('followups_view_team') && !userCan('followups_view_mine_only')) {
            return redirect()->route('admin.index')
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }
        $followups = ClientFollowUps::orderBy('id','desc');
        //if not allowed to view all just return his client employees
        if (!userCan('followups_view')) {
            if (!userCan('followups_view_branch')) {
                if (!userCan('followups_view_team')) {
                    $teamMembers = [];
                    $teamMembers[] = auth()->user()->id;
                    $myTeam = User::where('status','Active')->where('leader',auth()->user()->id)->get();
                    foreach ($myTeam as $myTeamKey => $myTeamV) {
                        $teamMembers[] = $myTeamV['id'];
                    }
                    $followups = $followups->whereIn('AgentID',$teamMembers);
                } else {
                    $followups = $followups->where('AgentID',auth()->user()->id);
                }
            } else {
                $followups = $followups->where('branch_id',auth()->user()->branch_id);
            }
        } else {
            //filter by client
            if (isset($_GET['client_id'])) {
                if ($_GET['client_id'] != 'all') {
                    $followups = $followups->where('ClientID',$_GET['client_id']);
                }
            }
            //filter by agent
            if (isset($_GET['AgentID'])) {
                if ($_GET['AgentID'] != 'all') {
                    $followups = $followups->where('AgentID',$_GET['AgentID']);
                }
            }
            //filter by branch
            if (isset($_GET['branch_id'])) {
                if ($_GET['branch_id'] != 'all') {
                    $followups = $followups->where('branch_id',$_GET['branch_id']);
                }
            }
        }
        //filter by agent
        if (isset($_GET['class'])) {
            if ($_GET['class'] != 'all') {
                $followups = $followups->where('clientClass',$_GET['class']);
            }
        }
        if (isset($_GET['contactingType'])) {
            if ($_GET['contactingType'] != 'all') {
                $followups = $followups->where('contactingType',$_GET['contactingType']);
            }
        } else {
            $followups = $followups->where('status','Done');
        }
        $followups = $followups->paginate(25);
        return view('AdminPanel.followups.index',[
            'active' => 'followups',
            'title' => trans('common.followups'),
            'followups' => $followups,
            'breadcrumbs' => [
                [
                    'url' => '',
                    'text' => trans('common.followups')
                ]
            ]
        ]);
    }

    public function nextFollowups()
    {
        $followups = ClientFollowUps::orderBy('contactingDateTimeStr','asc');
        //if not allowed to view all just return his client employees
        if (!userCan('followups_view')) {
            if (!userCan('followups_view_branch')) {
                if (!userCan('followups_view_team')) {
                    $teamMembers = [];
                    $teamMembers[] = auth()->user()->id;
                    $myTeam = User::where('status','Active')->where('leader',auth()->user()->id)->get();
                    foreach ($myTeam as $myTeamKey => $myTeamV) {
                        $teamMembers[] = $myTeamV['id'];
                    }
                    $followups = $followups->whereIn('AgentID',$teamMembers);
                } else {
                    $followups = $followups->where('AgentID',auth()->user()->id);
                }
            } else {
                $followups = $followups->where('branch_id',auth()->user()->branch_id);
            }
        } else {
            //filter by client
            if (isset($_GET['client_id'])) {
                if ($_GET['client_id'] != 'all') {
                    $followups = $followups->where('ClientID',$_GET['client_id']);
                }
            }
            //filter by agent
            if (isset($_GET['AgentID'])) {
                if ($_GET['AgentID'] != 'all') {
                    $followups = $followups->where('AgentID',$_GET['AgentID']);
                }
            }
            //filter by branch
            if (isset($_GET['branch_id'])) {
                if ($_GET['branch_id'] != 'all') {
                    $followups = $followups->where('branch_id',$_GET['branch_id']);
                }
            }
        }
        //filter by agent
        if (isset($_GET['class'])) {
            if ($_GET['class'] != 'all') {
                $followups = $followups->where('clientClass',$_GET['class']);
            }
        }
        if (isset($_GET['contactingType'])) {
            if ($_GET['contactingType'] != 'all') {
                $followups = $followups->where('contactingType',$_GET['contactingType']);
            }
        } else {
            $followups = $followups->where('status','pinding');
        }
        $followups = $followups->paginate(25);
        return view('AdminPanel.followups.index',[
            'active' => 'nextFollowups',
            'title' => trans('common.nextFollowups'),
            'followups' => $followups,
            'breadcrumbs' => [
                [
                    'url' => '',
                    'text' => trans('common.nextFollowups')
                ]
            ]
        ]);
    }

    public function store(Request $request)
    {
        if (!userCan('followups_create')) {
            return redirect()->back()
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }
        if (auth()->user()->branch == '') {
            return redirect()->back()
                                ->with('faild',trans('common.youAreNotAssgnedToAnyBranchPleaseContactAdmin'));
        }
        $data = $request->except(['_token','nextFollowUpType']);
        $data['UID'] = auth()->user()->id;
        $data['branch_id'] = auth()->user()->branch_id;
        $data['contactingDateTime'] = date('Y-m-d');
        $data['contactingDateTimeStr'] = strtotime(date('Y-m-d'));
        $data['month'] = date('m',strtotime(date('Y-m-d')));
        $data['year'] = date('Y',strtotime(date('Y-m-d')));
        if ($request['nextContactingDateTime'] != '') {
            $data['nextContactingDateTime'] = date('Y',strtotime($request['nextContactingDateTime']));
            $data['nextContactingDateTimeStr'] = date('Y',strtotime($request['nextContactingDateTime']));
        }
        $data['clientStatus'] = $request['status'];
        $data['status'] = 'Done';

        $followup = ClientFollowUps::create($data);
        $followup->client->update(['status'=>$request['status']]);
        if ($followup) {
            if ($request['nextContactingDateTime'] != '') {
                $next_followup = ClientFollowUps::create([
                    'UID' => auth()->user()->id,
                    'branch_id' => auth()->user()->branch_id,
                    'contactingDateTime' => $request['nextContactingDateTime'],
                    'contactingDateTimeStr' => strtotime($request['nextContactingDateTime']),
                    'month' => date('m',strtotime($request['nextContactingDateTime'])),
                    'year' => date('Y',strtotime($request['nextContactingDateTime'])),
                    'ClientID' => $request['ClientID'],
                    'status' => 'pinding',
                    'contactingType' => $request['nextFollowUpType']
                ]);
            }
            return redirect()->back()
                            ->with('success',trans('common.successMessageText'));
        } else {
            return redirect()->back()
                            ->with('faild',trans('common.faildMessageText'));
        }
    }

    public function update(Request $request,$id)
    {
        if (!userCan('followups_edit')) {
            return redirect()->back()
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }
        if (auth()->user()->branch == '') {
            return redirect()->back()
                                ->with('faild',trans('common.youAreNotAssgnedToAnyBranchPleaseContactAdmin'));
        }
        $data = $request->except(['_token','nextFollowUpType']);
        if ($request['nextContactingDateTime'] != '') {
            $data['nextContactingDateTime'] = date('Y',strtotime($request['nextContactingDateTime']));
            $data['nextContactingDateTimeStr'] = date('Y',strtotime($request['nextContactingDateTime']));
        }
        $data['clientStatus'] = $request['status'];
        $data['status'] = 'Done';

        $followup = ClientFollowUps::find($id)->update($data);
        $followup = ClientFollowUps::find($id);
        $followup->client->update(['status'=>$request['status']]);
        if ($followup) {
            if ($request['nextContactingDateTime'] != '') {
                $next_followup = ClientFollowUps::create([
                    'UID' => auth()->user()->id,
                    'branch_id' => auth()->user()->branch_id,
                    'contactingDateTime' => $request['nextContactingDateTime'],
                    'contactingDateTimeStr' => strtotime($request['nextContactingDateTime']),
                    'month' => date('m',strtotime($request['nextContactingDateTime'])),
                    'year' => date('Y',strtotime($request['nextContactingDateTime'])),
                    'ClientID' => $request['ClientID'],
                    'status' => 'pinding',
                    'contactingType' => $request['nextFollowUpType']
                ]);
            }
            return redirect()->back()
                            ->with('success',trans('common.successMessageText'));
        } else {
            return redirect()->back()
                            ->with('faild',trans('common.faildMessageText'));
        }
    }

    public function delete($id)
    {
        if (!userCan('followups_delete')) {
            return Response::json("false");
        }
        $followup = ClientFollowUps::find($id);
        if ($followup->delete()) {
            return Response::json($id);
        }
        return Response::json("false");
    }
}
