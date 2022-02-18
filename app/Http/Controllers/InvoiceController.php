<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Invoice;
use App\InvoiceItem;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class InvoiceController extends Controller
{
    /**
     * @param         $customerId
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store($customerId, Request $request)
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
            $invoice = Invoice::create(
                [
                    'customer_id' => (int)$request->customer_id
                ]
            );
            foreach ($request->cart as $item) {
                InvoiceItem::create(
                    [
                        'customer_id' => (int)$request->customer_id,
                        'invoice_id' => (int)$invoice->id,
                        'type' => $item['type'],
                        'date' => $item['date'],
                        'rate' => (int)$item['rate'],
                        'weight' => $item['weight'],
                        'delivered_form' => $item['delivered_form'],
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
     * @param $customerId
     * @return \Illuminate\Http\JsonResponse
     */
    public function detail($customerId)
    {
        $customer = Customer::find($customerId);
        return response()->json(
            [
                'invoices' => $customer->invoices()->with('items')->orderBy('id', 'DESC')->paginate($this->perPage),
            ],
            200
        );
    }

    /**
     * @param $invoiceId
     * @return mixed
     */
    public function download($invoiceId)
    {
        $invoice = Invoice::find($invoiceId);
        $pdf = PDF::loadView(
            'reports.invoice',
            [
                'customer' => $invoice->customer,
                'items' => $invoice->items,
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
        $invoice = Invoice::find($request->id);
        $invoice->items->map(
            function ($item) {
                $item->delete();
            }
        );
        $invoice->delete();
        return response()->json([], 200);
    }
}
