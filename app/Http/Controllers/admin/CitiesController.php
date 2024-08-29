<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Countries;
use App\Models\Governorates;
use App\Models\Cities;
use Response;

class CitiesController extends Controller
{
    public function index($governorateId)
    {
        $governorate = Governorates::find($governorateId);
        $cities = Cities::where('GovernorateID',$governorateId)->orderBy('name','desc')->paginate(25);
        return view('AdminPanel.cities.index',[
            'active' => 'countries',
            'title' => trans('common.cities'),
            'cities' => $cities,
            'governorate' => $governorate,
            'breadcrumbs' => [
                [
                    'url' => route('admin.governorates'),
                    'text' => $governorate['name']
                ],
                [
                    'url' => '',
                    'text' => trans('common.cities')
                ]
            ]
        ]);
    }

    public function store(Request $request,$governorateId)
    {
        $data = $request->except(['_token']);
        $data['GovernorateID'] = $governorateId;
        $city = Cities::create($data);
        if ($city) {
            return redirect()->back()
                            ->with('success',trans('common.successMessageText'));
        } else {
            return redirect()->back()
                            ->with('faild',trans('common.faildMessageText'));
        }

    }

    public function update(Request $request, $governorateId, $cityId)
    {
        $data = $request->except(['_token']);

        $update = Cities::find($cityId)->update($data);
        if ($update) {
            return redirect()->back()
                            ->with('success',trans('common.successMessageText'));
        } else {
            return redirect()->back()
                            ->with('faild',trans('common.faildMessageText'));
        }

    }

    public function delete($governorateId, $cityId)
    {
        $city = Cities::find($cityId);
        if ($city->delete()) {
            return Response::json($cityId);
        }
        return Response::json("false");
    }
}
