<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * @return mixed
     */
    public function getTasks()
    {
        return response()->json(
            [
                'tasks' => Task::orderBy('id', 'DESC')->paginate($this->perPage)
            ]
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
                'deadline' => 'required'
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
            'title' => $request->title,
            'deadline' => $request->deadline
        ];
        if ($request->id) {
            Task::whereId($request->id)->update($data);
        } else {
            Task::create($data);
        }
        return $this->getTasks();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        Task::whereId($request->id)->delete();
        return $this->getTasks();
    }
}
