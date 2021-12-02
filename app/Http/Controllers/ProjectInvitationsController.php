<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectInvitationRequest;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class ProjectInvitationsController extends Controller
{
    public function store(Project $project, ProjectInvitationRequest $request)
    {
        $user = User::whereEmail(request('email'))->first();

        $project->invite($user);

        return redirect($project->path());
    }

    public function delete(Project $project)
    {
        $user = User::whereEmail(\request('email'))->first();

        $project->removeUser($user);

        return redirect($project->path());
    }
}
