<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Books;
use App\Orders;
use App\OrderItems;

class OrdersController extends Controller
{
    //
    public function createOrder(Request $request)
    {

        $lang = $request->header('lang');
        $user_id = $request->header('user');
        
        if (checkUserForApi($lang, $user_id) !== true) {
            return checkUserForApi($lang, $user_id);
        }
        //this is how to create serial orders
        $orders = [];
        $dateTime = date('Y-m-d H:i:s');
        foreach ($request['items'] as $key => $value) {
            $bookDetails = Books::find($value['book_id']);
            if ($bookDetails != '') {
                $thisPublisherOrderKey = array_search($bookDetails['publisher_id'], array_column($orders, 'publisher_id'));
                if ($thisPublisherOrderKey === false) {
                    $orders[] = [
                        'publisher_id' => $bookDetails['publisher_id'],
                        'user_id' => $user_id,
                        'date_time' => $dateTime,
                        'date_time_str' => strtotime($dateTime),
                        'total' => $value['quntity'] * $value['price'],
                        'net_total' => $value['quntity'] * $value['price'],
                        'payment_method' => 'pod',
                        'payment_method_id' => '1',
                        'shipping_method' => 'free',
                        'shipping_address_id' => '2',
                        'items' => [
                            [
                                "book_id" => $value['book_id'],
                                "book_type" => $value['book_type'],
                                "quntity" => $value['quntity'],
                                "price" => $value['price']
                            ]
                        ]
                    ];
                } else {
                    $orders[$thisPublisherOrderKey]['total'] = $value['quntity'] * $value['price'] + $orders[$thisPublisherOrderKey]['net_total'];
                    $orders[$thisPublisherOrderKey]['net_total'] = ($value['quntity'] * $value['price']) + $orders[$thisPublisherOrderKey]['net_total'];
                    $orders[$thisPublisherOrderKey]['items'][] = [
                        "book_id" => $value['book_id'],
                        "book_type" => $value['book_type'],
                        "quntity" => $value['quntity'],
                        "price" => $value['price']
                    ];
                }
            }
        }

        //create our orders
        foreach ($orders as $singleOrder) {
            $theOrder = Orders::create([
                'publisher_id' => $singleOrder['publisher_id'],
                'user_id' => $user_id,
                'date_time' => $dateTime,
                'date_time_str' => strtotime($dateTime),
                'total' => $singleOrder['total'],
                'net_total' => $singleOrder['net_total'],
                'payment_method' => $singleOrder['payment_method'],
                'payment_method_id' => $singleOrder['payment_method_id'],
                'shipping_method' => $singleOrder['shipping_method'],
                'shipping_address_id' => $singleOrder['shipping_address_id'],
                'status' => 'done'
            ]);
            if ($theOrder) {
                if (count($singleOrder['items'])) {
                    foreach ($singleOrder['items'] as $value) {
                        $theOrder = OrderItems::create([
                            'publisher_id' => $singleOrder['publisher_id'],
                            'user_id' => $user_id,
                            'order_id' => $theOrder['id'],
                            'book_id' => $value['book_id'],
                            'book_type' => $value['book_type'],
                            'price' => $value['price'],
                            'quantity' => $value['quntity'],
                            'total' => $value['quntity'] * $value['price']
                        ]);
                    }
                }
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => trans('api.yourOrderHasBeenSentSuccessfully'),
            'data' => []
        ]);
    }
    public function myOrdersList(Request $request)
    {
        $lang = $request->header('lang');
        $user_id = $request->header('user');
        
        if (checkUserForApi($lang, $user_id) !== true) {
            return checkUserForApi($lang, $user_id);
        }

        $list = Orders::where('user_id',$user_id)->orderBy('id','desc')->get();
        $orders = [];
        foreach ($list as $key => $value) {
            $orders[] = $value->apiData($lang);
        }
        $resArr = [
            'status' => 'success',
            'message' => '',
            'data' => $orders
        ];
        return response()->json($resArr);

    }
    public function OrderDetails(Request $request, $id)
    {
        $lang = $request->header('lang');
        $user_id = $request->header('user');
        
        if (checkUserForApi($lang, $user_id) !== true) {
            return checkUserForApi($lang, $user_id);
        }
        $order = Orders::find($id);
        if ($order != '') {
            $resArr = [
                'status' => 'success',
                'message' => '',
                'data' => $order->apiData($lang)
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
