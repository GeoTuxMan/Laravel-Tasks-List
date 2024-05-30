{{-- @isset($name) --}}
{{-- The name is {{ $name }} --}}
{{-- @endisset --}}
{{--
<div>
    @if (count($tasks))
       @foreach ($tasks as $task)
         <div>{{ $task->title }}</div>
         <div>{{ $task->description }}</div>
         <div>{{ $task->long_description }}</div>
         <div>{{ $task->completed }}</div>
         <div>{{ $task->created_at }}</div>
         <div>{{ $task->updated_at }}</div>
         <br>
       @endforeach
    @else
       <div>There are no tasks !</div>
    @endif
</div>
--}}
@extends('layouts.app')
{{-- Varianta 2 --}}
@section('title', 'The list of tasks')
@section('content')
<nav class="mb-4">
    <a href="{{ route('tasks.create') }}" class="link">Add Task!</a>
  </nav>

    @forelse ($tasks as $task)
    <div>
        <a href="{{ route('tasks.show', ['task' => $task->id]) }}"
          @class(['line-through' => $task->completed])>{{ $task->title }}</a>
      </div>
     @empty
     <div>There are no tasks</div>
     @endforelse

     @if ($tasks->count())
     <nav class="mt-4">
        {{ $tasks->links() }}
     </nav>
     @endif
@endsection

