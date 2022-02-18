<?php

namespace App\Http\Controllers;

use App\AdvanceSalary;
use Illuminate\Http\Request;

class AdvanceSalaryController extends Controller
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
                'amount' => 'required'
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
            'amount' => (double)$request->amount ?? null
        ];
        if ($request->id) {
            AdvanceSalary::whereId($request->id)->update($data);
        } else {
            AdvanceSalary::create($data);
        }
        return response()->json([], 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        AdvanceSalary::whereId($request->id)->delete();
        return response()->json([], 200);
    }
}
