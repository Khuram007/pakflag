<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Invoice;
use App\InvoiceItem;
use App\Payment;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * @return mixed
     */
    private function getCustomers()
    {
        $customers = auth()->user()->customers()->orderBy('id', 'DESC')->paginate($this->perPage);
        if ($customers) {
            foreach ($customers as $customer) {
                $customer->total_debits = $customer->payments()->whereType('debit')->sum('amount');
                $customer->total_credits = $customer->payments()->whereType('credit')->sum('amount');
                $customer->payments = $customer->payments()->orderBy('id', 'DESC')->get();
            }
        }
        return $customers;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function customers(Request $request)
    {
        return response()->json(
            [
                'customers' => $this->getCustomers(),
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
                'name' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
                'country' => 'required',
                'state' => 'required',
                'city' => 'required',
                'address' => 'required',
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
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'country' => $request->country,
            'state' => $request->state,
            'city' => $request->city,
            'address' => $request->address,
        ];
        if ($request->id) {
            Customer::whereId($request->id)->update($data);
        } else {
            Customer::create($data);
        }
        return response()->json(
            [
                'customers' => $this->getCustomers()
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
        Customer::whereId($request->id)->delete();
        Payment::where('customer_id',$request->id)->delete();
        Invoice::where('customer_id',$request->id)->delete();
        InvoiceItem::where('customer_id',$request->id)->delete();
        return response()->json(
            [
                'customers' => $this->getCustomers()
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
                'customer' => $customer,
                'total_debits' => $customer->payments()->whereType('debit')->sum('amount'),
                'total_credits' => $customer->payments()->whereType('credit')->sum('amount'),
                'payments' => $customer->payments()->orderBy('id', 'DESC')->paginate($this->perPage),
            ],
            200
        );
    }
}
