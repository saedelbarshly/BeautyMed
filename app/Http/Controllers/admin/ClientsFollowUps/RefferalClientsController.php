<?php

namespace App\Http\Controllers\admin\ClientsFollowUps;

use App\Models\RefferalClient;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;


class RefferalClientsController extends Controller
{

    public function index()
    {
        if (!userCan('refferal_clients_view')) {
            return redirect()->route('admin.index')
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }

        $refferalClients = RefferalClient::orderBy('id','desc')->paginate(25);

        return view('AdminPanel.clients.refferal',[
            'active' => 'refferalClients',
            'title' => trans('common.refferalClients'),
            'refferalClients' => $refferalClients,
            'breadcrumbs' => [
                [
                    'url' => '',
                    'text' => trans('common.refferalClients')
                ]
            ]
        ]);
    }


    public function store(Request $request)
    {

        if (!userCan('refferal_clients_create')) {
            return redirect()->back()
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }

        $data = $request->except(['_token']);
        $refferalClient = RefferalClient::create($data);


        if ($refferalClient) {
            return redirect()->back()
                            ->with('success',trans('common.successMessageText'));
        } else {
            return redirect()->back()
                            ->with('faild',trans('common.faildMessageText'));
        }


    }


    public function update(Request $request, $id)
    {
        if (!userCan('refferal_clients_edit')) {
            return redirect()->back()
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }
        $data = $request->except(['_token','serviceoffer','services']);

        $refferalClient = RefferalClient::find($id);
        $update = RefferalClient::find($id)->update($data);


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
        if (!userCan('refferal_clients_delete')) {
            return Response::json("false");
        }
        $refferalClient = RefferalClient::find($id);
        if ($refferalClient->delete()) {
            return Response::json($id);
        }
        return Response::json("false");
    }


}
