<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Status;
use App\Models\Task;

class ProjectsController extends Controller
{
    public function index()
    {
        $projects = auth()->user()->accessibleProjects(\request('search'));

        return view('projects.index', compact('projects'));
    }

    public function show(Project $project)
    {
        $this->authorize('update', $project);

        $filters = ['sort_by_owner', 'sort_by_date', 'sort_by_status'];

        $tasks = Task::canFilter($filters)->where('project_id', '=' , $project->id)->paginate(5);

        $statuses = Status::all();

        return view('projects.show', compact('project', 'tasks', 'statuses'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store()
    {

        $attributes = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'notes' => 'nullable'
        ]);

        $project = auth()->user()->projects()->create($attributes);

        if ($tasks = request('tasks')) {
            $project->addTasks($tasks);
        }

        if (request()->wantsJson()) {
            return ['message' => $project->path()];
        }
        return redirect($project->path());
    }

    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    public function update(Project $project)
    {
        $this->authorize('update', $project);

        $project->update($this->validateRequest());

        return redirect($project->path());
    }

    protected function validateRequest()
    {
        return request()->validate([
            'title' => 'sometimes|required',
            'description' => 'sometimes|required',
            'notes' => 'nullable'
        ]);
    }

    public function destroy(Project $project)
    {
        $this->authorize('manage', $project);

        $project->delete();

        return redirect('/projects');
    }
}
