<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Salary;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function stats()
    {
        return response()->json(
            [
                'received' => (double)\App\Payment::whereType('debit')->sum('amount'),
                'pending' => (double)\App\Payment::whereType('credit')->sum('amount'),
                'customersCounter' => (int)\App\Customer::count(),
                'employeesCounter' => (int)\App\Employee::count()
            ],
            200
        );
    }
}
