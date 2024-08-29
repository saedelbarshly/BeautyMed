<?php

namespace App\Http\Controllers\admin\hr;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jobs;
use Response;

class JobsController extends Controller
{
    public function index()
    {
        if (!userCan('jobs_view')) {
            return redirect()->route('admin.index')
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }

        $jobs = Jobs::orderBy('id','asc')->paginate(25);
        return view('AdminPanel.hr.jobs.index',[
            'active' => 'jobs',
            'title' => trans('common.jobs'),
            'jobs' => $jobs,
            'breadcrumbs' => [
                [
                    'url' => '',
                    'text' => trans('common.jobs')
                ]
            ]
        ]);
    }



    public function store(Request $request)
    {
        if (!userCan('jobs_create')) {
            return redirect()->back()
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }
        $data = $request->except(['_token']);

        $job = Jobs::create($data);
        if ($job) {
            return redirect()->back()
                            ->with('success',trans('common.successMessageText'));
        } else {
            return redirect()->back()
                            ->with('faild',trans('common.faildMessageText'));
        }

    }

    public function update(Request $request, $id)
    {
        if (!userCan('jobs_edit')) {
            return redirect()->back()
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }
        $job = Jobs::find($id);
        $data = $request->except(['_token']);

        $update = Jobs::find($id)->update($data);
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
        if (!userCan('jobs_delete')) {
            return Response::json("false");
        }
        $job = Jobs::find($id);
        if ($job->delete()) {
            return Response::json($id);
        }
        return Response::json("false");
    }
}
