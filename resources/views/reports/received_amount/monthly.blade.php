<head>
    <title>Invoice</title>
    <style>
        .border-row {
            border-right: 1px solid black;
            border: 1px solid black;
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
    <div class="col-sm-12">
        <h3>Received Amount</h3>
        <div class="card card-table">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-center table-hover datatable">
                        <thead class="thead-dark">
                        <tr class="border-row">
                            <th scope="col" class="border-row">Date</th>
                            <th scope="col" class="border-row">Description</th>
                            <th scope="col" class="border-row">Amount</th>
                            <th scope="col" class="border-row">Created At</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($receivedAmount)
                            @foreach($receivedAmount as $item)
                                <tr class="border-row">
                                    <td class="border-row">{{$item->date}}</td>
                                    <td class="border-row">{{$item->description}}</td>
                                    <td class="border-row">{{$item->amount}}</td>
                                    <td class="border-row">{{$item->created_at}}</td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                    <p><b>Total: </b>{{$total}}</p>
                </div>
            </div>
        </div>
    </div>
    <footer>
        PAK FLAG ENGINEERING (PVT) LTD Copyright &copy; {{ date("Y") }}
    </footer>
</div>
</body>

