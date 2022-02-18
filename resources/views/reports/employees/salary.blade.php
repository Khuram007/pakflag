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
    <div class="col-md-6">
        <b>Employee #{{$employee->id}}: </b>{{$employee->name}} - #{{$employee->id}} since
        ({{$employee->created_at}})
        <p><b>Phone: </b>{{$employee->phone}}</p>
        <p><b>Email: </b>{{$employee->email}}</p>
        <p><b>Designation: </b>{{$employee->designation}}</p>
        <p><b>City: </b>{{$employee->city}}</p>
        <p><b>Address: </b>{{$employee->address}}</p>
        <p><b>Salary: </b>{{$employee->salary}}</p>
        <p><b>Hourly Rate: </b>{{$employee->hourly_rate}}</p>
    </div>

    <div class="col-sm-12">
        <h3>Salaries</h3>
        <div class="card card-table">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-center table-hover datatable">
                        <thead class="thead-dark">
                        <tr class="border-row">
                            <th scope="col" class="border-row">Deduction</th>
                            <th scope="col" class="border-row">Overtime</th>
                            <th scope="col" class="border-row">Created At</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($salaries)
                            @foreach($salaries as $item)
                                <tr class="border-row">
                                    <td class="border-row">{{$item->deduction}}</td>
                                    <td class="border-row">{{$item->overtime}}</td>
                                    <td class="border-row">{{$item->created_at}}</td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                    <p><b>Total Deductions: </b>{{$totalDeductions}}</p>
                    <p><b>Total Overtime: </b>{{$totalOvertime}}</p>
                    <p><b>Total Advance: </b>{{$employee->currency_advance_salaries}}</p>
                    <p><b>Current Salary: </b>{{$currentSalary}}</p>
                </div>
            </div>
        </div>
    </div>
    <footer>
        PAK FLAG ENGINEERING (PVT) LTD Copyright &copy; {{ date("Y") }}
    </footer>
</div>
</body>

