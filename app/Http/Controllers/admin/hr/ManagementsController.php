<?php

namespace App\Http\Controllers\admin\hr;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Managements;
use Response;

class ManagementsController extends Controller
{
    public function index()
    {
        if (!userCan('managements_view')) {
            return redirect()->route('admin.index')
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }

        $managements = Managements::orderBy('id','asc')->paginate(25);
        return view('AdminPanel.hr.managements.index',[
            'active' => 'managements',
            'title' => trans('common.managements'),
            'managements' => $managements,
            'breadcrumbs' => [
                [
                    'url' => '',
                    'text' => trans('common.managements')
                ]
            ]
        ]);
    }



    public function store(Request $request)
    {
        if (!userCan('managements_create')) {
            return redirect()->back()
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }
        $data = $request->except(['_token']);

        $management = Managements::create($data);
        if ($management) {
            return redirect()->back()
                            ->with('success',trans('common.successMessageText'));
        } else {
            return redirect()->back()
                            ->with('faild',trans('common.faildMessageText'));
        }

    }

    public function update(Request $request, $id)
    {
        if (!userCan('managements_edit')) {
            return redirect()->back()
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }
        $management = Managements::find($id);
        $data = $request->except(['_token']);

        $update = Managements::find($id)->update($data);
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
        if (!userCan('managements_delete')) {
            return Response::json("false");
        }
        $management = Managements::find($id);
        if ($management->delete()) {
            return Response::json($id);
        }
        return Response::json("false");
    }
}
