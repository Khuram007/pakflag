<?php

namespace App\Http\Controllers;

use App\ReceivedAmount;
use Illuminate\Http\Request;

class ReceivedAmountController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function receivedAmount(Request $request)
    {
        return response()->json(
            [
                'receivedAmount' => auth()->user()->receivedAmount()->orderBy('id', 'DESC')->paginate($this->perPage)
            ],
            200
        );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'description' => 'required',
                'date' => 'required',
                'amount' => 'required',
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
        $data = [
            'user_id' => auth()->id(),
            'description' => $request->description,
            'date' => $request->date,
            'amount' => (double)$request->amount,
        ];
        if ($request->id) {
            ReceivedAmount::whereId($request->id)->update($data);
        } else {
            ReceivedAmount::create($data);
        }

        return response()->json(
            [
                'receivedAmount' => auth()->user()->receivedAmount()->orderBy('id', 'DESC')->paginate($this->perPage)
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
        ReceivedAmount::whereId($request->id)->delete();
        return response()->json(
            [
                'receivedAmount' => auth()->user()->receivedAmount()->orderBy('id', 'DESC')->paginate($this->perPage)
            ],
            200
        );
    }

    /**
     * @return mixed
     */
    public function download()
    {
        $receivedAmount = ReceivedAmount::currentMonth()->get();
        $pdf = \PDF::loadView(
            'reports.received_amount.monthly',
            [
                'receivedAmount' => $receivedAmount,
                'total' => $receivedAmount->sum('amount')
            ]
        );
        return $pdf->stream('received_amount_' . time() . '.pdf');
    }
}
