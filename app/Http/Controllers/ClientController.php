<?php

namespace App\Http\Controllers;

use App\Client;
use App\ClientInvoice;
use App\ClientInvoiceItem;
use App\ClientPayment;
use App\Customer;

use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * @return mixed
     */
    private function getClients()
    {
        $clients = auth()->user()->clients()->orderBy('id', 'DESC')->paginate($this->perPage);
        if ($clients) {
            foreach ($clients as $client) {
                $client->total_debits = $client->payments()->whereType('debit')->sum('amount');
                $client->total_credits = $client->payments()->whereType('credit')->sum('amount');
                $client->payments = $client->payments()->orderBy('id', 'DESC')->get();
            }
        }
        return $clients;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function clients(Request $request)
    {
        return response()->json(
            [
                'clients' => $this->getClients(),
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
            Client::whereId($request->id)->update($data);
        } else {
            Client::create($data);
        }
        return response()->json(
            [
                'clients' => $this->getClients()
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
        Client::whereId($request->id)->delete();
        ClientPayment::where('client_id', $request->id)->delete();
        ClientInvoice::where('client_id', $request->id)->delete();
        ClientInvoiceItem::where('client_id', $request->id)->delete();
        return response()->json(
            [
                'clients' => $this->getClients()
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
        $client = Client::find($customerId);
        return response()->json(
            [
                'client' => $client,
                'total_debits' => $client->payments()->whereType('debit')->sum('amount'),
                'total_credits' => $client->payments()->whereType('credit')->sum('amount'),
                'payments' => $client->payments()->orderBy('id', 'DESC')->paginate($this->perPage),
            ],
            200
        );
    }
}
