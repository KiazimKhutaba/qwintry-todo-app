<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoItemFormRequest;
use App\Models\TodoItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Nette\NotImplementedException;

class TodoItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return \response()->json(TodoItem::all());
    }

    /**
     * Store a newly created resource in storage.
     * Todo: this action does too many things - should be refactored!
     *
     * @param TodoItemFormRequest $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $todo = $request->input('todo');
        $responseStatus = 200;


        if(!$todo)
            return \response()->json(['status_code' => 400, 'message' => 'Required parameter \'todo\' missing in request'], 400);

        $rules = [
            'text' => 'required|string|between:3,100',  //Must be a number and length of value is 8
            'is_done' => 'required|in:0,1',
            'is_urgent' => 'required|in:0,1',
        ];

        $messages = [
            'in' => 'Field :attribute should be :values'
        ];

        $validator = Validator::make($todo, $rules, $messages);

        if ($validator->passes())
        {
            $createdTodo = TodoItem::create($validator->valid());
            $responseData = ['message' => 'Todo created', 'todo' => $createdTodo];
        }
        else
        {
            $responseData = ['status_code' => 400, 'message' => $validator->messages()];
            $responseStatus = 400;
        }

        return \response()->json($responseData, $responseStatus);
    }



    public function changeStatus(Request $request, int $id): JsonResponse
    {
        $todo = $request->input('todo');

        if(!$todo)
            return \response()->json(['status_code' => 400, 'message' => 'Required parameter \'todo\' missing in request'], 400);

        $rules = [
            'id' => 'required|integer',
            'is_done' => 'prohibited_unless:is_urgent,null|required_without:is_urgent|in:0,1',
            'is_urgent' => 'prohibited_unless:is_done,null|required_without:is_done|in:0,1',
        ];

        $messages = [
            'in' => 'Field :attribute should be :values'
        ];

        $validator = Validator::make($todo, $rules, $messages);


        return \response()->json(['valid' => $validator->valid(), 'error' => $validator->messages()]);


        $urgentStatus = $request->input('status');
        $doneStatus = $request->input('is_done');

        $todoItem = TodoItem::findOrFail($id);
        $todoItem->is_urgent = intval($urgentStatus);
        $todoItem->is_done = intval($doneStatus);

        $savedTodo = $todoItem->save();

        return \response()->json([
            'data' => ['code' => $savedTodo, 'is_urgent' => $urgentStatus, 'done' => $doneStatus]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        return \response()->json([
            'message' => 'Item deleted',
            'id' => TodoItem::destroy($id)
        ]);
    }
}
