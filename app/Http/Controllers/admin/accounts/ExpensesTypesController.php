<?php

namespace App\Http\Controllers\admin\accounts;

use App\Models\Expenses;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExpensesTypes;
use Response;

class ExpensesTypesController extends Controller
{
    public function index()
    {
        if (!userCan('ExpensesTypes_view')) {
            return redirect()->route('admin.index')
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }

        $ExpensesTypes = ExpensesTypes::with('expenses')->orderBy('name','asc')->paginate(25);

        return view('AdminPanel.accounts.expensesTypes.index',[
            'active' => 'expenses',
            'title' => trans('common.expensesTypes'),
            'ExpensesTypes' => $ExpensesTypes,
            'breadcrumbs' => [
                [
                    'url' => route('admin.expenses'),
                    'text' => trans('common.expenses')
                ],
                [
                    'url' => '',
                    'text' => trans('common.expensesTypes')
                ]
            ]
        ]);
    }

    public function store(Request $request)
    {
        if (!userCan('ExpensesTypes_create')) {
            return redirect()->back()
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }
        $data = $request->except(['_token']);

        $branch = ExpensesTypes::create($data);
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
        if (!userCan('ExpensesTypes_edit')) {
            return redirect()->back()
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }
        $branch = ExpensesTypes::find($id);
        $data = $request->except(['_token']);

        $update = ExpensesTypes::find($id)->update($data);
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
        if (!userCan('ExpensesTypes_delete')) {
            return Response::json("false");
        }
        $branch = ExpensesTypes::find($id);
        if ($branch->delete()) {
            return Response::json($id);
        }
        return Response::json("false");
    }
}
