<?php

namespace App\Http\Controllers;

use App\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function expenses(Request $request)
    {
        return response()->json(
            [
                'expenses' => auth()->user()->expenses()->orderBy('id', 'DESC')->paginate($this->perPage)
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
                'title' => 'required',
                'description' => 'required',
                'expense_at' => 'required',
                'amount' => 'required',
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
            'title' => $request->title,
            'description' => $request->description,
            'expense_at' => $request->expense_at,
            'amount' => $request->amount,
        ];
        if ($request->id) {
            Expense::whereId($request->id)->update($data);
        } else {
            Expense::create($data);
        }

        return response()->json(
            [
                'expenses' => auth()->user()->expenses()->orderBy('id', 'DESC')->paginate($this->perPage)
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
        Expense::whereId($request->id)->delete();
        return response()->json(
            [
                'expenses' => auth()->user()->expenses()->orderBy('id', 'DESC')->paginate($this->perPage)
            ],
            200
        );
    }

    /**
     * @return mixed
     */
    public function download()
    {
        $expenses = Expense::currentMonthExpense()->get();
        $pdf = \PDF::loadView(
            'reports.expenses.monthly',
            [
                'expenses' => $expenses,
                'total' => $expenses->sum('amount')
            ]
        );
        return $pdf->stream('expense_' . time() . '.pdf');
    }
}
