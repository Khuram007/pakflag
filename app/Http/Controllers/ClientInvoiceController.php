<?php

namespace App\Http\Controllers;

use App\Client;
use App\ClientInvoice;
use App\ClientInvoiceItem;
use PDF;
use Illuminate\Http\Request;

class ClientInvoiceController extends Controller
{
    /**
     * @param         $clientId
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store($clientId, Request $request)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'cart' => 'required'
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
        if ($request->cart) {
            $invoice = ClientInvoice::create(
                [
                    'client_id' => (int)$request->client_id
                ]
            );
            foreach ($request->cart as $item) {
                ClientInvoiceItem::create(
                    [
                        'client_id' => (int)$request->client_id,
                        'client_invoice_id' => (int)$invoice->id,
                        //                        'type' => $item['type'],
                        'date' => $item['date'],
                        'rate' => (int)$item['rate'],
                        'weight' => $item['weight'],
                        'description' => $item['description'],
                        'rupees' => (double)$item['rupees'],
                        'amount' => (double)$item['amount'],
                        'qty' => (int)$item['qty'],
                        'credit' => (double)$item['credit'],
                        'debit' => (double)$item['debit'],
                        'balance' => (double)$item['balance']
                    ]
                );
            }
        }
        return response()->json(
            [
                'invoice_id' => $invoice->id
            ],
            200
        );
    }

    /**
     * @param $clientId
     * @return \Illuminate\Http\JsonResponse
     */
    public function detail($clientId)
    {
        $client = Client::find($clientId);
        return response()->json(
            [
                'invoices' => $client->invoices()->with('items')->orderBy('id', 'DESC')->paginate($this->perPage),
            ],
            200
        );
    }

    /**
     * @param $clientId
     * @return mixed
     */
    public function download($clientId)
    {
        $client = Client::find($clientId);
        $pdf = PDF::loadView(
            'reports.client_invoice',
            [
                'client' => $client,
                'items' => ClientInvoiceItem::where('client_id', $clientId)->orderBy('id', 'DESC')->get(),
            ]
        );
        return $pdf->stream('invoice_' . time() . '.pdf');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        $invoice = ClientInvoice::find($request->id);
        $invoice->items->map(
            function ($item) {
                $item->delete();
            }
        );
        $invoice->delete();
        return response()->json([], 200);
    }
}
