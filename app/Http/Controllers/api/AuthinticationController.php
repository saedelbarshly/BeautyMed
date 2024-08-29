<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\users\CreateUser;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Auth;
use Response;

class AuthinticationController extends Controller
{
    //
    public function register(Request $request)
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
                    'email' => 'required|email|unique:users',
                    'phone' => 'required',
                    'password' => 'required',
                    'userName' => 'required'
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

        $data = $request->except(['_token','password','cPassword']);
        $data['password'] = bcrypt($request['password']);
        $data['role'] = '3';
        $data['language'] = $lang;

        $user = User::create($data);
        if ($user) {
            $resArr = [
                'status' => 'success',
                'message' => trans('api.yourDataHasBeenSavedSuccessfully'),
                'data' => $user->apiData($lang)
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
    public function login(Request $request)
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
                    'email' => 'required',
                    'password' => 'required'
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

        $login = $request->email;

        if(is_numeric($login)){
            $field = 'phone';
        } elseif (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            $field = 'email';
        } else {
            $field = 'userName';
        }

        if (Auth::attempt([$field=>$request['email'],'password'=>$request['password']])) {
            if (Auth::user()->role != '3') {
                $resArr = [
                    'status' => 'faild',
                    'message' => trans('api.youCantLogIn'),
                    'data' => []
                ];
                return response()->json($resArr);
            }
            if (Auth::user()->block == '1') {
                $resArr = [
                    'status' => 'faild',
                    'message' => trans('api.youHaveBeenBlockedFromLoggingToOurSystem'),
                    'data' => []
                ];
                return response()->json($resArr);
            }
            if (Auth::user()->active == '0') {
                $resArr = [
                    'status' => 'faild',
                    'message' => trans('api.yourAccountIsNotActive'),
                    'data' => []
                ];
                return response()->json($resArr);
            }
            $resArr = [
                'status' => 'success',
                'message' => '',
                'data' => Auth::user()->apiData($lang)
            ];
            return response()->json($resArr);
        } else {
            $resArr = [
                'status' => 'faild',
                'message' => trans('api.yourDataIsWrong'),
                'data' => []
            ];
        }

        $resArr = [
            'status' => 'faild',
            'message' => trans('api.someThingWentWrong'),
            'data' => []
        ];
        return response()->json($resArr);

    }

}
