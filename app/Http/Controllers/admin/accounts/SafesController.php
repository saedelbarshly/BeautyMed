<?php

namespace App\Http\Controllers\admin\accounts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SafesBanks;
use Illuminate\Support\Facades\Response;

class SafesController extends Controller
{
    //
    public function index()
    {
        if (!userCan('safes_view')) {
            return redirect()->route('admin.index')
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }

        $month = date('m');
        if (isset($_GET['month']) ) {
            if ($_GET['month'] != '' ) {
                $month = $_GET['month'];
            }
        }

        $safes = SafesBanks::orderBy('Title','asc')->paginate(25);
        return view('AdminPanel.accounts.safes.index',[
            'active' => 'safes',
            'title' => trans('common.safes'),
            'safes' => $safes,
            'breadcrumbs' => [
                [
                    'url' => '',
                    'text' => trans('common.safes')
                ]
            ]
        ]);
    }


    public function store(Request $request)
    {
        if (!userCan('safes_create')) {
            return redirect()->back()
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }
        $data = $request->except(['_token']);

        $branch = SafesBanks::create($data);
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
        if (!userCan('safes_edit')) {
            return redirect()->back()
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }
        $branch = SafesBanks::find($id);
        $data = $request->except(['_token']);

        $update = SafesBanks::find($id)->update($data);
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
        if (!userCan('safes_delete')) {
            return Response::json("false");
        }
        $branch = SafesBanks::find($id);
        if ($branch->delete()) {
            return Response::json($id);
        }
        return Response::json("false");
    }
}
