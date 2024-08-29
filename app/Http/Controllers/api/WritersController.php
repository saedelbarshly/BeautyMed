<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Writers;
use Response;

class WritersController extends Controller
{
    public function writers(Request $request)
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

        $writers = Writers::where('active','1')->orderBy('name_'.$lang)->get();
        $list = [];
        foreach ($writers as $key => $writer) {
            $list[] = $writer->apiData($lang);
        }
        $resArr = [
            'status' => 'success',
            'message' => '',
            'data' => $list
        ];
        return response()->json($resArr);

    }
    public function writerDetails(Request $request,$id)
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

        $writer = Writers::find($id);
        
        $resArr = [
            'status' => 'success',
            'message' => '',
            'data' => $writer->apiData($lang,'1')
        ];
        return response()->json($resArr);

    }

}
