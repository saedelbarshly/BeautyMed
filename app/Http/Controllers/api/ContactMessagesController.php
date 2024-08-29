<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\ContactMessages;
use Response;

class ContactMessagesController extends Controller
{
    public function sendContactMessage(Request $request)
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

        $rules = [
                    'name' => 'required',
                    'email' => 'required|email',
                    'phone' => 'required',
                    'country' => 'required',
                    'content' => 'required'
                ];
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails())
        {
            foreach ((array)$validator->errors() as $error) {
                return response()->json([
                    'status' => 'faild',
                    'message' => trans('api.pleaseRecheckYourDetails'),
                    'data' => $error
                ]);
            }
        }

        $data = $request->except(['_token']);

        $message = ContactMessages::create($data);
        if ($message) {
            $resArr = [
                'status' => 'success',
                'message' => trans('api.yourDataHasBeenSentSuccessfully'),
                'data' => []
            ];
        } else {
            $resArr = [
                'status' => 'faild',
                'message' => trans('api.someThingWentWrong'),
                'data' => []
            ];
        }
        return response()->json($resArr);

    }
}
