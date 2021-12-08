<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class ProjectTasksController extends Controller
{
    public function store(Project $project)
    {
        $this->authorize('update', $project);


        \request()->validate(['body'=>'required']);
        $project->addTask(\request('body'));

        return redirect($project->path());
    }


    public function update(Project $project, Task $task)
    {
        $this->authorize('update', $task->project);

        \request()->validate([
            'body' => 'required',
        ]);

        $task->update([
            'body' => \request('body'),
        ]);

        switch (request('status')) {
            case 1:
                $task->incomplete();
                break;
            case 2:
                $task->inprogress();
                break;
            case 3:
                $task->complete();
                break;
        }

        return redirect($project->path());
    }
}
