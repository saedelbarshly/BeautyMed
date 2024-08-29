<?php

namespace App\Http\Controllers\admin\services;

use App\Models\Expenses;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Facades\Response;


class ManagementServicesController extends Controller
{
    public function index()
    {
        if (!userCan('services_view')) {
            return redirect()->route('admin.index')
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }

        $services = Service::orderBy('id','desc')->paginate(25);

        return view('AdminPanel.services.managementServices.index',[
            'active' => 'services',
            'title' => trans('common.services'),
            'services' => $services,
            'breadcrumbs' => [
                [
                    'url' => '',
                    'text' => trans('common.services')
                ]
            ]
        ]);
    }



    public function store(Request $request)
    {
        if (!userCan('services_create')) {
            return redirect()->back()
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }
        $data = $request->except(['_token']);

        $service = Service::create($data);
        if ($service) {
            return redirect()->back()
                            ->with('success',trans('common.successMessageText'));
        } else {
            return redirect()->back()
                            ->with('faild',trans('common.faildMessageText'));
        }

    }

    public function update(Request $request, $id)
    {
        if (!userCan('services_edit')) {
            return redirect()->back()
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }
        $service = Service::find($id);
        $data = $request->except(['_token']);

        $update = Service::find($id)->update($data);
        if ($update) {
            return redirect()->back()
                            ->with('success',trans('common.successMessageText'));
        } else {
            return redirect()->back()
                            ->with('faild',trans('common.faildMessageText'));
        }

    }


    public function reports($id)
    {
        if (!userCan('services_reports_view')) {
            return redirect()->route('admin.index')
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }
        $service = Service::find($id);
        // return $service->totals($_GET['year'],$_GET['month'])['reservationsArr']->whereMonth('');

        return view('AdminPanel.services.managementServices.reports',[
            'active' => 'services',
            'title' => trans('common.services'),
            'service' => $service ,
            'breadcrumbs' => [
                [
                    'url' => route('admin.services'),
                    'text' => trans('common.services')
                ],
                [
                    'url' => '',
                    'text' => $service->name
                ]
            ]
        ]);
    }


    public function delete($id)
    {
        if (!userCan('services_delete')) {
            return Response::json("false");
        }
        $service = Service::find($id);
        if ($service->delete()) {
            return Response::json($id);
        }
        return Response::json("false");
    }
}
