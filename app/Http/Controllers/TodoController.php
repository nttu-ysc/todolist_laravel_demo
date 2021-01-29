<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTodo;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todos = Todo::where('user_id', Auth::id())->orderBy('order')->get();
        return view('index', ['todos' => $todos]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTodo $request)
    {
        $todo = new Todo;
        $todo->fill($request->all());
        $todo->user_id = Auth::id();
        $todo->save();
        return ['todo' => $todo];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(StoreTodo $request, Todo $todo)
    {
        $todo->event = $request->event;
        $todo->save();
    }

    public function iscomplete(Todo $todo)
    {
        $todo->iscomplete = ($todo->iscomplete) ? (0) : (1);
        $todo->save();
        return ['todo' => $todo];
    }

    public function order(Request $request)
    {
        foreach ($request->orderPair as  $order) {
            $todo = Todo::find($order['id']);
            $todo->order = $order['order'];
            $todo->save();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Todo $todo)
    {
        $todo->delete();
    }
}
