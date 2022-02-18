<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'customer_id' => 'required',
                'type' => 'required',
                'payment_type' => 'required',
                'amount' => 'required',
                'date' => 'required'
            ]
        );
        if ($validator->fails()) {
            return response()->json(
                [
                    'message' => $validator->errors()->first()
                ],
                422
            );
        }
        $customer = Customer::find($request->customer_id);
        Payment::create(
            [
                'customer_id' => $customer->id,
                'type' => $request->type,
                'payment_type' => (string)$request->payment_type,
                'amount' => (int)$request->amount,
                'date' => $request->date
            ]
        );
        return response()->json(
            [
                'payments' => $customer->payments()->orderBy('id', 'DESC')->get()
            ],
            200
        );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        Payment::whereId($request->id)->delete();
        return response()->json([], 200);
    }
}
