<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Salary;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'employee_id' => 'required',
                'deduction' => 'required_without:overtime',
                'overtime' => 'required_without:deduction'
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
            'employee_id' => (int)$request->employee_id ?? null,
            'deduction' => (int)$request->deduction ?? null,
            'overtime' => (int)$request->overtime ?? null,
        ];
        if ($request->id) {
            Salary::whereId($request->id)->update($data);
        } else {
            Salary::create($data);
        }
        return response()->json(
            [
                'employees' => auth()->user()->employees()->with('salaries')->orderBy('id', 'DESC')
                                     ->paginate($this->perPage)
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
        Salary::whereId($request->id)->delete();
        return response()->json([],200);
    }
}
