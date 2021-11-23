<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectActivityController extends Controller
{
    public function index(Project $project){
        $activities = $project->activity()->paginate(10);

        return view('projects.activity.index', compact('activities'));

    }
}
