<head>
    <title>Invoice</title>
    <style>
        .border-row {
            border-right: 1px solid black;
            border: 1px solid black;
            width: 15%;
            text-align: center;
        }
        /** Define the footer rules **/
        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            /** Extra personal styles **/
            text-align: center;
        }
    </style>
</head>
<body>

<div class="">
    <div class="col-md-6">
        <img src="https://www.pakflagengineering.com/assets/img/logo.png" width="100" class="img-thumbnail" alt="">
    </div>
    <div class="col-md-6">
        <b>Customer: </b>{{$customer->name}}
        <br>
        <b>Address: </b>{{$customer->address}}, {{$customer->city}}, {{$customer->state}}, {{$customer->country}}
    </div>

    <div class="col-sm-12">
        <h3>Invoices #{{$items[0]->invoice_id}}</h3>
        <div class="card card-table">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-center table-hover datatable" style="width:100%">
                        <thead class="thead-dark">
                        <tr class="border-row">
                            <th class="border-row" scope="col">Date</th>
                            <th class="border-row" scope="col">Rate</th>
                            <th class="border-row" scope="col">Weight</th>
                            <th class="border-row" scope="col">Delivered Form</th>
                            <th class="border-row" scope="col">Type</th>
                            <th class="border-row" scope="col">Amount</th>
                            <th class="border-row" scope="col">Quantity</th>
                            <th class="border-row" scope="col">Credit</th>
                            <th class="border-row" scope="col">Debit</th>
                            <th class="border-row" scope="col">Balance</th>
                            <th class="border-row" scope="col">Created At</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($items)
                            @foreach($items as $item)
                                <tr class="border-row">
                                    <td class="border-row">{{$item->date}}</td>
                                    <td class="border-row">{{$item->rate}}</td>
                                    <td class="border-row">{{$item->weight}}</td>
                                    <td class="border-row">{{$item->delivered_form}}</td>
                                    <td class="border-row">{{$item->type}}</td>
                                    <td class="border-row">{{$item->amount}}</td>
                                    <td class="border-row">{{$item->qty}}</td>
                                    <td class="border-row">{{$item->credit}}</td>
                                    <td class="border-row">{{$item->debit}}</td>
                                    <td class="border-row">{{$item->balance}}</td>
                                    <td class="border-row">{{$item->created_at}}</td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                    <p><b>Total: </b>{{$items->sum('amount')}}</p>
                </div>
            </div>
        </div>
    </div>
    <footer>
        PAK FLAG ENGINEERING (PVT) LTD Copyright &copy; {{ date("Y") }}
    </footer>
</div>
</body>

