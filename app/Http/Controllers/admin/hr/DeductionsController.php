<?php

namespace App\Http\Controllers\admin\hr;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SalariesDeductions;

class DeductionsController extends Controller
{
    //

    public function store(Request $request)
    {
        if (!userCan('deductions_store')) {
            return redirect()->back()
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }

        $data = $request->except(['_token']);
        $data['Status'] = 'Done';
        $data['month'] = date('m',strtotime($request['DeductionDate']));
        $data['year'] = date('Y',strtotime($request['DeductionDate']));
        $data['UID'] = auth()->user()->id;

        $deduction = SalariesDeductions::create($data);
        if ($deduction) {
            return redirect()->back()
                            ->with('success',trans('common.successMessageText'));
        } else {
            return redirect()->back()
                            ->with('faild',trans('common.faildMessageText'));
        }

    }

    public function delete($id)
    {
        if (!userCan('deductions_delete')) {
            return redirect()->back()
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }

        $deduction = SalariesDeductions::find($id);
        if ($deduction->delete()) {
            return redirect()->back()
                            ->with('success',trans('common.successMessageText'));
        } else {
            return redirect()->back()
                            ->with('faild',trans('common.faildMessageText'));
        }
    }
}
