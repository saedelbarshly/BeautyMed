<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Branches;
use Response;

class BranchesController extends Controller
{
    //
    public function index()
    {
        if (!userCan('branches_view')) {
            return redirect()->route('admin.index')
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }

        $branches = Branches::orderBy('id','asc')->paginate(25);
        return view('AdminPanel.branches.index',[
            'active' => 'branches',
            'title' => trans('common.branches'),
            'branches' => $branches,
            'breadcrumbs' => [
                [
                    'url' => '',
                    'text' => trans('common.branches')
                ]
            ]
        ]);
    }



    public function store(Request $request)
    {
        if (!userCan('branches_create')) {
            return redirect()->back()
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }
        $data = $request->except(['_token']);

        $branch = Branches::create($data);
        if ($branch) {
            return redirect()->back()
                            ->with('success',trans('common.successMessageText'));
        } else {
            return redirect()->back()
                            ->with('faild',trans('common.faildMessageText'));
        }

    }

    public function update(Request $request, $id)
    {
        if (!userCan('branches_edit')) {
            return redirect()->back()
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }
        $branch = Branches::find($id);
        $data = $request->except(['_token']);

        $update = Branches::find($id)->update($data);
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
        if (!userCan('branches_delete')) {
            return Response::json("false");
        }
        $branch = Branches::find($id);
        if ($branch->delete()) {
            return Response::json($id);
        }
        return Response::json("false");
    }
}
