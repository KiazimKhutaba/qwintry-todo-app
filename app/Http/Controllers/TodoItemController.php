<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoItemFormRequest;
use App\Models\TodoItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
     *
     * @param TodoItemFormRequest $request
     * @return JsonResponse
     */
    public function store(TodoItemFormRequest $request): JsonResponse
    {
        $attributes = $request->only(['text', 'is_done', 'is_urgent']);
        //$validated = $attributes->safe()->only(['text', 'is_done', 'is_urgent']);

        //$todo = TodoItem::create($validated);


        return \response()->json($attributes);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        throw new NotImplementedException();
    }


    public function changeUrgentStatus(Request $request, int $id = 1): JsonResponse
    {
        $urgentStatus = $request->input('urgent');

        $todoItem = TodoItem::findOrFail($id);
        $todoItem->is_urgent = intval($urgentStatus);
        $savedTodo = $todoItem->save();

        return \response()->json([
            'data' => ['code' => $savedTodo, 'is_urgent' => $urgentStatus]
        ]);
    }


    public function changeStatus(Request $request, int $id = 1): JsonResponse
    {
        $urgentStatus = $request->input('is_urgent');
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
