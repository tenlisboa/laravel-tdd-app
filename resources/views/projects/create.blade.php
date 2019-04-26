@extends('layouts.app')

@section('content')
  <form style="padding-top: 40px" action="/projects" method="post">
    @csrf

    <h1 class="heading is-1">Create a Project</h1>
    <div class="field">
      <label class="label">Title</label>

      <div class="control">
        <input type="text" class="input" name="title" placeholder="Title">
      </div>
    </div>

    <div class="field">
      <label class="label">Description</label>

      <div class="control">
        <input type="text" class="input" name="description" placeholder="Description">
      </div>
    </div>

    <div class="field">
      <button type="submit" class="button is-link">Create Porject</button>
      <a href="/projects">Cancel</a>
    </div>
  </form>
@endsection