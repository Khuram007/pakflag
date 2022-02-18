<?php

namespace App\Http\Controllers;

use App\Client;
use App\ClientPayment;
use App\Customer;
use App\Payment;
use Illuminate\Http\Request;

class ClientPaymentController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'client_id' => 'required',
            'type' => 'required',
            'payment_type' => 'required',
            'amount' => 'required',
            'date' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first()
            ], 422);
        }
        $client = Client::find($request->client_id);
        ClientPayment::create([
            'client_id' => $client->id,
            'type' => $request->type,
            'payment_type' => (string)$request->payment_type,
            'amount' => (int)$request->amount,
            'date' => $request->date
        ]);
        return response()->json([
            'payments' => $client->payments()->orderBy('id', 'DESC')->get()
        ], 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        ClientPayment::whereId($request->id)->delete();
        return response()->json([], 200);
    }
}
