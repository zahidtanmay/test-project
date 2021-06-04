<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TodoController extends Controller
{
    /**
     * List Todos for only the authenticated user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $todos = Todo::where('user_id', auth()->user()->id)->get();
        return response()->json($todos, 200);
    }

    /**
     * Create a new Todo for the authenticated user
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'description' => ['required'],
        ]);

        $todo = Todo::create([
            'description' => $request->description,
            'user_id' => auth()->user()->id
        ]);

        return response()->json($todo, 201);
    }

    /**
     * Update a Todo for the authenticated user
     *
     * @param $todoId
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($todoId)
    {
        $todo = Todo::find($todoId);
        $todo->completed_at = Carbon::now()->toDateTimeString();
        $todo->save();

        return response()->json($todo, 200);
    }

    /**
     * Delete a Todo for the authenticated user
     *
     * @param Request $request
     * @param $todoId
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($todoId)
    {
        Todo::destroy($todoId);
        return response()->json([], 200);
    }
}
