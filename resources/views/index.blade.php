@extends('layouts.frontend')

@section('panel')
<div id="panel">
    <h1>Todo List</h1>
    <div id="todo-list">
        <ul>
            @foreach ($todos as $todo)
            <li data-id="{{$todo->id}}" class="{{$todo->iscomplete}}">
                <div class="checkbox"></div>
                <div class="content" contenteditable="false">{{$todo->event}}</div>
            </li>
            @endforeach
            <li class="new">
                <div class="checkbox"></div>
                <div class="content" contenteditable="true"></div>
            </li>
        </ul>
    </div>
</div>
@endsection