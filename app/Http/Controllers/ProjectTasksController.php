<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
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

    public function updateStatus(Project $project, Task $task)
    {
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


    public function update(Project $project, Task $task)
    {
        $this->authorize('update', $task->project);

        \request()->validate([
            'body' => 'required',
        ]);

        $task->update([
            'body' => \request('body'),
        ]);


        return redirect($project->path());
    }

    public function assignUser(Project $project, Task $task)
    {
        $this->authorize('update', $task->project);

        if(\request('member') === 'delete'){
            $task->update([
                'user_id' => null,
            ]);

            return redirect($project->path());
        }

        if(null != User::find(\request('member'))) {
            $task->update([
                'user_id' => \request('member'),
            ]);
        } else {
            abort(403, 'Unauthorized action.');
        }

        return redirect($project->path());
    }

    public function delete(Project $project, Task $task){

        $this->authorize('update', $project);

        $task->update([
            'deleted' => 1,
        ]);

        return redirect($project->path());

    }
}
