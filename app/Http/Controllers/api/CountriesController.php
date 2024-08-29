<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Countries;
use App\Models\Governorates;
use App\Models\Cities;
use Response;

class CountriesController extends Controller
{
    //
    public function countries(Request $request)
    {
        $lang = $request->header('lang');
        $value = $request->header('value');
        if ($lang == '') {
            $resArr = [
                'status' => 'faild',
                'message' => trans('api.pleaseSendLangCode'),
                'data' => []
            ];
            return response()->json($resArr);
        }

        $countries = Countries::orderBy('name_'.$lang)->get();
        $list = [];
        foreach ($countries as $key => $country) {
            $list[] = [
                'id' => $country[$value],
                'name' => $country['name_'.$lang] != '' ? $country['name_'.$lang] : $country['name_en']
            ];
        }
        $resArr = [
            'status' => 'success',
            'message' => '',
            'data' => $list
        ];
        return response()->json($resArr);

    }

    public function governorates(Request $request,$countryId)
    {
        $lang = $request->header('lang');
        if ($lang == '') {
            $resArr = [
                'status' => 'faild',
                'message' => trans('api.pleaseSendLangCode'),
                'data' => []
            ];
            return response()->json($resArr);
        }

        $governorates = Governorates::where('country',$countryId)->orderBy('name_'.$lang)->get();
        $list = [];
        foreach ($governorates as $key => $value) {
            $list[] = [
                'id' => $value['id'],
                'name' => $value['name_'.$lang]
            ];
        }
        $resArr = [
            'status' => 'success',
            'message' => '',
            'data' => $list
        ];
        return response()->json($resArr);

    }


    public function cities(Request $request,$countryId,$governorateId)
    {
        $lang = $request->header('lang');
        if ($lang == '') {
            $resArr = [
                'status' => 'faild',
                'message' => trans('api.pleaseSendLangCode'),
                'data' => []
            ];
            return response()->json($resArr);
        }

        $cities = Cities::where('governorate',$governorateId)->orderBy('name_'.$lang)->get();
        $list = [];
        foreach ($cities as $key => $value) {
            $list[] = [
                'id' => $value['id'],
                'name' => $value['name_'.$lang]
            ];
        }
        $resArr = [
            'status' => 'success',
            'message' => '',
            'data' => $list
        ];
        return response()->json($resArr);

    }

}
