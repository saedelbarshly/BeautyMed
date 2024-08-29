<?php

namespace App\Http\Controllers\admin\ClientsFollowUps;

use App\Models\Clients;
use App\Models\Complaint;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;


class ComplaintsController extends Controller
{

    public function index()
    {
        if (!userCan('complaints_view')) {
            return redirect()->route('admin.index')
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }

        $complaints = Complaint::orderBy('id','desc')->paginate(25);

        return view('AdminPanel.complaints.index',[
            'active' => 'complaints',
            'title' => trans('common.complaints'),
            'complaints' => $complaints,
            'breadcrumbs' => [
                [
                    'url' => '',
                    'text' => trans('common.complaints')
                ]
            ]
        ]);
    }


    public function store(Request $request)
    {

        if (!userCan('complaints_create')) {
            return redirect()->back()
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }

        $data = $request->except(['_token']);
        $complaint = Complaint::create($data);


        if ($complaint) {
            return redirect()->back()
                            ->with('success',trans('common.successMessageText'));
        } else {
            return redirect()->back()
                            ->with('faild',trans('common.faildMessageText'));
        }


    }


    public function update(Request $request, $id)
    {
        if (!userCan('complaints_edit')) {
            return redirect()->back()
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }
        $data = $request->except(['_token','serviceoffer','services']);

        $complaint = Complaint::find($id);
        $update = Complaint::find($id)->update($data);


        if ($update) {
            return redirect()->back()
                            ->with('success',trans('common.successMessageText'));
        } else {
            return redirect()->back()
                            ->with('faild',trans('common.faildMessageText'));
        }

    }


    public function delete($id)
    {
        if (!userCan('complaints_delete')) {
            return Response::json("false");
        }
        $complaint = Complaint::find($id);
        if ($complaint->delete()) {
            return Response::json($id);
        }
        return Response::json("false");
    }


}
