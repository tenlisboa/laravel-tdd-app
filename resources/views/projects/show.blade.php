@extends('layouts.app')

@section('content')

  <header class="flex items-end justify-between mb-3 py-4">
    <p class="text-grey text-sm font-normal">
      <a href="/projects" class="text-grey text-sm font-normal no-underline">My Projects</a> / {{ $project->title }}
    </p>
    <a href="/projects/create" class="button">New Project</a>
  </header>

  <main>
    <div class="lg:flex -mx-3">
      <div class="lg:w-3/4 px-3 mb-6">
        <div class="mb-8">
          <h2 class="text-lg text-grey font-normal mb-3">Tasks</h2>

          <!-- tasks -->
            @foreach ($project->tasks as $task)
                <div class="card mb-3">
                    <form action="{{ $task->path() }}" method="POST">
                        @method('PATCH')
                        @csrf

                        <div class="flex items-center justify-between">
                            <input name="body" value="{{ $task->body }}" class="w-full {{ $task->completed ? 'text-grey' : '' }}">
                            <input name="completed" type="checkbox" onChange="this.form.submit()" {{ $task->completed ? 'checked' : '' }}>
                        </div>
                    </form>
                </div>
            @endforeach
            <div class="card mb-3">
                <form action="{{ $project->path() . '/tasks' }}" method="POST">
                    @csrf
                    <input class="w-full" name="body" placeholder="Add a new task">
                </form>
            </div>
        </div>

        <div>
          <h2 class="text-lg text-grey font-normal mb-3">General Notes</h2>

          <!-- General notes -->
          <form method="POST" action="{{ $project->path() }}">
            @csrf
            @method('PATCH')

            <textarea
              class="card w-full mb-4"
              name="notes"
              style="min-height: 200px;"
              placeholde="Anything special that you want to make a note of?"

            >{{$project->notes}}</textarea>

            <button type="submit" class="button">Save</button>
          </form>
        </div>

      </div>

      <div class="lg:w-1/4 px-3 lg:py-8">
        @include ('projects.card')
      </div>
    </div>
  </main>

@endsection