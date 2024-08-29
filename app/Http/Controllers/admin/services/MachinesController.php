<?php

namespace App\Http\Controllers\admin\services;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Machine;
use Illuminate\Support\Facades\Response;

class MachinesController extends Controller
{
    public function index()
    {
        if (!userCan('leaserMachines_view')) {
            return redirect()->route('admin.index')
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }

        $leaser_machines = Machine::orderBy('name','asc')->paginate(25);
        return view('AdminPanel.services.leasermachines.index',[
            'active' => 'leaserMachines',
            'title' => trans('common.leaserMachines'),
            'leaser_machines' => $leaser_machines,
            'breadcrumbs' => [
                [
                    'url' => '',
                    'text' => trans('common.leaserMachines')
                ]
            ]
        ]);
    }



    public function store(Request $request)
    {
        if (!userCan('leaserMachines_create')) {
            return redirect()->back()
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }
        $data = $request->except(['_token']);

        $leaserMachine = Machine::create($data);
        if ($leaserMachine) {
            return redirect()->back()
                            ->with('success',trans('common.successMessageText'));
        } else {
            return redirect()->back()
                            ->with('faild',trans('common.faildMessageText'));
        }

    }

    public function update(Request $request, $id)
    {
        if (!userCan('leaserMachines_edit')) {
            return redirect()->back()
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }
        $leaserMachine = Machine::find($id);
        $data = $request->except(['_token']);

        $update = Machine::find($id)->update($data);
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
        if (!userCan('leaserMachines_delete')) {
            return Response::json("false");
        }
        $leaserMachine = Machine::find($id);
        if ($leaserMachine->delete()) {
            return Response::json($id);
        }
        return Response::json("false");
    }
}
