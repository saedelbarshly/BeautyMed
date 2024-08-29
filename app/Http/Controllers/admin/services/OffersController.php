<?php

namespace App\Http\Controllers\admin\services;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\Service;
use Illuminate\Support\Facades\Response;


class OffersController extends Controller
{

    public function index()
    {
        if (!userCan('offers_view')) {
            return redirect()->route('admin.index')
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }

        $offers = Offer::orderBy('name','asc')->paginate(25);
        $services = Service::orderBy('name','asc')->get();

        return view('AdminPanel.services.offers.index',[
            'active' => 'offers',
            'title' => trans('common.offers'),
            'offers' => $offers,
            'services' => $services ,
            'breadcrumbs' => [
                [
                    'url' => '',
                    'text' => trans('common.offers')
                ]
            ]
        ]);
    }



    public function store(Request $request)
    {
        if (!userCan('offers_create')) {
            return redirect()->back()
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }
        $data = $request->except(['_token','servicesId','servicesPrice']);

        $offer = Offer::create($data);

        if (count($request->servicesId) > 0) {
            for ($i=0; $i<count($request->servicesId);$i++) {
                if ($request['servicesId'][$i] != '' && $request['servicesPrice'][$i] != '') {
                    $service = Service::find($request['servicesId'][$i]);
                    $offer->services()->attach($service, ['offerPrice'=> $request['servicesPrice'][$i]]);
                }
            }
        }

        if ($offer) {
            return redirect()->back()
                            ->with('success',trans('common.successMessageText'));
        } else {
            return redirect()->back()
                            ->with('faild',trans('common.faildMessageText'));
        }

    }

    public function update(Request $request, $id)
    {
        if (!userCan('offers_edit')) {
            return redirect()->back()
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }
        $data = $request->except(['_token','servicesId','servicesPrice']);

        $offer = Offer::find($id);
        $update = Offer::find($id)->update($data);
        $services = Service::get();

        foreach($services as $service)
        {
            $offer->services()->detach($service);
        }

        if (count($request->servicesId) > 0) {
            for ($i=0; $i<count($request->servicesId);$i++) {
                if ($request['servicesId'][$i] != '' && $request['servicesPrice'][$i] != '') {
                    $service = Service::find($request['servicesId'][$i]);
                    $offer->services()->attach($service, ['offerPrice'=> $request['servicesPrice'][$i]]);
                }
            }
        }

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
        if (!userCan('offers_delete')) {
            return Response::json("false");
        }
        $offer = Offer::find($id);
        if ($offer->delete()) {
            return Response::json($id);
        }
        return Response::json("false");
    }

}
