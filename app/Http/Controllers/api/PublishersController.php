<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Response;

class PublishersController extends Controller
{
    public function publishers(Request $request)
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

        $publishers = User::where('role','2')->orderBy('name')->get();
        $list = [];
        foreach ($publishers as $key => $value) {
            $list[] = $value->apiData($lang);
        }
        $resArr = [
            'status' => 'success',
            'message' => '',
            'data' => $list
        ];
        return response()->json($resArr);

    }
    public function publisherDetails(Request $request,$id)
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

        $publisher = User::find($id)->apiData($lang,'1');

        $resArr = [
            'status' => 'success',
            'message' => '',
            'data' => $publisher
        ];
        return response()->json($resArr);

    }

}
