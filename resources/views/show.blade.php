{{--  <div>
    @if (count($tasks))
       @foreach ($tasks as $task)
      @if ($task->id == $id)
         <div>{{ $task->title }}</div>
         <div>{{ $task->description }}</div>
         <div>{{ $task->long_description }}</div>
         <div>{{ $task->completed }}</div>
         <div>{{ $task->created_at }}</div>
         <div>{{ $task->updated_at }}</div>
         <br>
     @endif
       @endforeach
    @else
       <div>There are no tasks !</div>
    @endif
</div>
--}}
@extends('layouts.app')
{{-- Varianta 2 --}}
@section('title', $task->title)
@section('content')
<div class="mb-4">
    <a href="{{ route('tasks.index') }}" class="link">Go back to the tasks list ! </a>
</div>
<p class="mb-4 text-slate-700">{{ $task->description }}</p>
<p class="mb-4 text-slate-700">{{ $task->long_description }}</p>

<p class="mb-4 text-sm text-slate-500">Created {{ $task->created_at->diffForHumans() }} *** Updated {{ $task->updated_at->diffForHumans() }}</p>


<p class="mb-4">
    @if ($task->completed)
    <span class="font-medium text-green-500">Completed</span>
    @else
    <span class="font-medium text-red-500">Not completed</span>
    @endif
</p>
<div class="flex gap-2">
    <a href="{{ route('tasks.edit', ['task' => $task]) }}"
        class="btn">Edit</a>

    <form method="POST" action="{{ route('tasks.toggle-complete', ['task' => $task]) }}">
        @csrf
        @method('PUT')
        <button type="submit" class="btn">
          Mark as {{ $task->completed ? 'not completed' : 'completed' }}
        </button>
      </form>

    <form action="{{ route('tasks.destroy', ['task' => $task]) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn">Delete</button>
      </form>
</div>
@endsection
