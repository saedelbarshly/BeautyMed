<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\UserPaymentMethods;
use App\Models\UserAddress;
use App\Models\User;
use Auth;
use Response;

class UserController extends Controller
{
    //
    public function myProfile(Request $request)
    {
        $lang = $request->header('lang');
        $user_id = $request->header('user');
        if ($lang == '') {
            $resArr = [
                'status' => 'faild',
                'message' => trans('api.pleaseSendLangCode'),
                'data' => []
            ];
            return response()->json($resArr);
        }

        $user = User::find($user_id);
        if ($user == '') {
            return response()->json([
                'status' => 'faild',
                'message' => trans('api.thisUserDoesNotExist'),
                'data' => []
            ]);
        }
        $resArr = [
            'status' => 'success',
            'message' => '',
            'data' => $user->apiData($lang)
        ];
        return response()->json($resArr);
    }
    public function UpdateMyProfile(Request $request)
    {
        $lang = $request->header('lang');
        $user_id = $request->header('user');

        if (checkUserForApi($lang, $user_id) !== true) {
            return checkUserForApi($lang, $user_id);
        }

        $rules = [
                    'name' => 'required',
                    'email' => 'required|email|unique:users,email,'.$user_id,
                    'phone' => 'required',
                    'country' => 'required',
                    'governorate' => 'required',
                    'city' => 'required',
                    'password' => 'nullable',
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

        $data = $request->except(['_token','password']);
        if ($request['password'] != '') {
            $data['password'] = bcrypt($request['password']);
        }
        $user = User::find($user_id);

        if ($user->update($data)) {
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
    public function createAddress(Request $request)
    {
        $lang = $request->header('lang');
        $user_id = $request->header('user');

        if (checkUserForApi($lang, $user_id) !== true) {
            return checkUserForApi($lang, $user_id);
        }

        $rules = [
                    'postal_code' => 'nullable',
                    'country' => 'required',
                    'governorate' => 'required',
                    'city' => 'required',
                    'address' => 'required',
                    'phone' => 'required'
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
        $data['user_id'] = $user_id;
        $address = UserAddress::create($data);
        if ($address->update($data)) {
            $resArr = [
                'status' => 'success',
                'message' => trans('api.yourDataHasBeenSavedSuccessfully'),
                'data' => $address->apiData($lang)
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
    public function myAddressList(Request $request)
    {
        $lang = $request->header('lang');
        $user_id = $request->header('user');

        if (checkUserForApi($lang, $user_id) !== true) {
            return checkUserForApi($lang, $user_id);
        }

        $addressList = UserAddress::where('user_id',$user_id)->orderBy('id','desc')->get();
        $list = [];
        foreach ($addressList as $key => $value) {
            $list[] = [
                'id' => $value['id'],
                'country' => [
                    'id' => $value->countryData->id,
                    'name' => $value->countryData['name_'.$lang]
                ],
                'governorate' => [
                    'id' => $value->governorateData->id,
                    'name' => $value->governorateData['name_'.$lang]
                ],
                'city' => [
                    'id' => $value->cityData->id,
                    'name' => $value->cityData['name_'.$lang]
                ],
                'address' => $value['address'],
                'phone' => $value['phone'],
                'postal_code' => $value['postal_code']
            ];
        }
        $resArr = [
            'status' => 'success',
            'message' => '',
            'data' => $list
        ];
        return response()->json($resArr);

    }
    public function AddressDetails(Request $request, $id)
    {
        $lang = $request->header('lang');
        $user_id = $request->header('user');

        if (checkUserForApi($lang, $user_id) !== true) {
            return checkUserForApi($lang, $user_id);
        }

        $address = UserAddress::find($id);
        if ($address != '') {
            $resArr = [
                'status' => 'success',
                'message' => '',
                'data' => $address
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

    public function UpdateAddress(Request $request, $id)
    {
        $lang = $request->header('lang');
        $user_id = $request->header('user');

        if (checkUserForApi($lang, $user_id) !== true) {
            return checkUserForApi($lang, $user_id);
        }

        $rules = [
            'postal_code' => 'nullable',
            'country' => 'required',
            'governorate' => 'required',
            'city' => 'required',
            'address' => 'required',
            'phone' => 'required'
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
        $address = UserAddress::find($id);
        if ($address->update($data)) {
            $resArr = [
                'status' => 'success',
                'message' => trans('api.yourDataHasBeenSavedSuccessfully'),
                'data' => $address
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
    public function DeleteAddress(Request $request, $id)
    {
        $lang = $request->header('lang');
        $user_id = $request->header('user');

        if (checkUserForApi($lang, $user_id) !== true) {
            return checkUserForApi($lang, $user_id);
        }

        $address = UserAddress::find($id);
        if ($address->delete()) {
            $resArr = [
                'status' => 'success',
                'message' => trans('api.yourDataHasBeenSavedSuccessfully'),
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

    public function createPaymentMethod(Request $request)
    {
        $lang = $request->header('lang');
        $user_id = $request->header('user');

        if (checkUserForApi($lang, $user_id) !== true) {
            return checkUserForApi($lang, $user_id);
        }

        $rules = [
                    'name' => 'required',
                    'card_number' => 'required',
                    'card_cvv' => 'required',
                    'card_month' => 'required',
                    'card_year' => 'required',
                    'primary' => 'nullable'
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
        $data['user_id'] = $user_id;
        $data['card_date'] = $request->card_month.'/'.$request->card_year;
        $paymentMethod = UserPaymentMethods::create($data);
        if ($paymentMethod->update($data)) {
            $resArr = [
                'status' => 'success',
                'message' => trans('api.yourDataHasBeenSavedSuccessfully'),
                'data' => $paymentMethod
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
    public function myPaymentMethodList(Request $request)
    {
        $lang = $request->header('lang');
        $user_id = $request->header('user');

        if (checkUserForApi($lang, $user_id) !== true) {
            return checkUserForApi($lang, $user_id);
        }

        $list = UserPaymentMethods::where('user_id',$user_id)->orderBy('id','desc')->get();
        $resArr = [
            'status' => 'success',
            'message' => '',
            'data' => $list
        ];
        return response()->json($resArr);

    }
    public function PaymentMethodDetails(Request $request, $id)
    {
        $lang = $request->header('lang');
        $user_id = $request->header('user');

        if (checkUserForApi($lang, $user_id) !== true) {
            return checkUserForApi($lang, $user_id);
        }
        $paymentMethod = UserPaymentMethods::find($id);
        if ($paymentMethod != '') {
            $resArr = [
                'status' => 'success',
                'message' => trans('api.yourDataHasBeenSavedSuccessfully'),
                'data' => $paymentMethod
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

    public function UpdatePaymentMethod(Request $request, $id)
    {
        $lang = $request->header('lang');
        $user_id = $request->header('user');

        if (checkUserForApi($lang, $user_id) !== true) {
            return checkUserForApi($lang, $user_id);
        }

        $rules = [
            'name' => 'required',
            'card_number' => 'required',
            'card_cvv' => 'required',
            'card_month' => 'required',
            'card_year' => 'required',
            'primary' => 'nullable'
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
        $paymentMethod = UserPaymentMethods::find($id);
        if ($paymentMethod->update($data)) {
            $resArr = [
                'status' => 'success',
                'message' => trans('api.yourDataHasBeenSavedSuccessfully'),
                'data' => $paymentMethod
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
    public function DeletePaymentMethod(Request $request, $id)
    {
        $lang = $request->header('lang');
        $user_id = $request->header('user');

        if (checkUserForApi($lang, $user_id) !== true) {
            return checkUserForApi($lang, $user_id);
        }

        $paymentMethod = UserPaymentMethods::find($id);
        if ($paymentMethod->delete()) {
            $resArr = [
                'status' => 'success',
                'message' => trans('api.yourDataHasBeenSavedSuccessfully'),
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
