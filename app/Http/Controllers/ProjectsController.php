<?php

namespace App\Http\Controllers;

use App\Models\Project;

class ProjectsController extends Controller
{
    public function index(){

        $projects = auth()->user()->projects;

        return view('projects.index', compact('projects'));
    }

    public function store(){

        $attributes = \request()->validate([
            'title' => 'required',
            'description' => 'required',
            'notes' => 'min:3'
        ]);

        $project = auth()->user()->projects()->create($attributes);

        return redirect($project->path());
    }

    public function show(Project $project){

        $this->authorize('update', $project);

        return view('projects.show', compact('project'));
    }

    public function create(Project $project){

        return view('projects.create');
    }


    public function update(Project $project){

        $this->authorize('update', $project);

        $attributes = request()->validate([
            'title'=>'sometimes|required',
            'description'=>'sometimes|required|max:255',
            'notes' => 'nullable'
        ]);

        $project->update($attributes);

        return redirect($project->path());
    }
}
