@extends('layouts.frontend')

@section('panel')
<div id="panel">
    <h1>Todo List</h1>
    <div id="todo-list">
        <ul>
            <li class="new">
                <div class="checkbox"></div>
                <div class="content" contenteditable="true"></div>
            </li>
        </ul>
    </div>
</div>
@endsection