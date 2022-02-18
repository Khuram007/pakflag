<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Salary;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * @return mixed
     */
    private function getEmployees()
    {
        $employees = auth()->user()->employees()->with(['salaries', 'advanceSalaries'])->orderBy(
            'id',
            'DESC'
        )->paginate(
            $this->perPage
        );
        if ($employees) {
            foreach ($employees as $employee) {
                $employee->current_salaries = $employee->currentMonthSalaries()->orderBy('id', 'DESC')->get();
                $employee->current_advance_salaries = $employee->currentMonthAdvanceSalaries()->orderBy(
                    'id',
                    'DESC'
                )->get();
            }
        }
        return $employees;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function employees(Request $request)
    {
        return response()->json(
            [
                'employees' => $this->getEmployees()
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
                'dob' => 'required',
                'salary' => 'required',
                'designation' => 'required',
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
            'designation' => $request->designation,
            'salary' => (double)$request->salary,
            'hourly_rate' => (double)number_format($request->salary / 30 / 10, 2),
            'dob' => $request->dob,
            'city' => $request->city,
            'address' => $request->address,
        ];
        if ($request->id) {
            Employee::whereId($request->id)->update($data);
        } else {
            Employee::create($data);
        }

        return response()->json(
            [
                'employees' => $this->getEmployees()
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
        Employee::whereId($request->id)->delete();
        Salary::where('employee_id', $request->id)->delete();
        return response()->json(
            [
                'employees' => $this->getEmployees()
            ],
            200
        );
    }

    /**
     * @param $employeeId
     * @return \Illuminate\Http\JsonResponse
     */
    public function detail($employeeId)
    {
        $employee = Employee::find($employeeId);
        $employee->current_salaries = $employee->currentMonthSalaries()->orderBy('id', 'DESC')->get();
        return response()->json(
            [
                'employee' => $employee,
                'salaries' => $employee->salaries()->orderBy('id', 'DESC')->paginate($this->perPage)
            ],
            200
        );
    }

    /**
     * @param $employeeId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAdvanceSalaries($employeeId)
    {
        $employee = Employee::find($employeeId);
        $employee->current_advance_salaries = $employee->currentMonthAdvanceSalaries()->orderBy('id', 'DESC')->get();
        return response()->json(
            [
                'advance_salaries' => $employee->advanceSalaries()->orderBy('id', 'DESC')->paginate($this->perPage),
            ],
            200
        );
    }

    /**
     * @param $employeeId
     * @return mixed
     */
    public function download($employeeId)
    {
        $employee = Employee::find($employeeId);
        $employee->currency_advance_salaries = $employee->currentMonthAdvanceSalaries()->orderBy('id', 'DESC')->sum('amount');
        $currentSalary = (((10 * 30 + $employee->currentMonthSalaries()->sum('overtime'))
                - $employee->currentMonthSalaries()->sum('deduction')) * $employee->hourly_rate)-(double)$employee->currency_advance_salaries;
        $pdf = \PDF::loadView(
            'reports.employees.salary',
            [
                'employee' => $employee,
                'currentSalary' => $currentSalary,
                'totalDeductions' => $employee->currentMonthSalaries()->sum('deduction'),
                'totalOvertime' => $employee->currentMonthSalaries()->sum('overtime'),
                'salaries' => $employee->currentMonthSalaries()->orderBy('id', 'DESC')->get(),
            ]
        );
        return $pdf->stream('salary_' . time() . '.pdf');
    }
}
