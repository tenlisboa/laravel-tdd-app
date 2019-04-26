<div class="card" style="height: 200px;">
  <h3 class="card-header">
    <a href="{{ $project->path() }}">{{ $project->title }}</a>
  </h3>

  <div class="text-grey">{{ str_limit($project->description) }}</div>
</div>