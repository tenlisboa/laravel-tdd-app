<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectTasksController extends Controller
{
    public function store(Project $project)
    {
        $project->addTask(request('body'));

        return redirect($project->path());
    }
}
