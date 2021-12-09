<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectInvitationRequest;
use App\Models\Project;
use App\Models\Task;
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

        $this->removeMemberFromProjectTasks($user);

        return redirect($project->path());
    }

    /**
     * @param $user
     */
    private function removeMemberFromProjectTasks($user): void
    {
        foreach (Task::where('user_id', '=', $user->id)->get() as $task) {
            $task->user_id = null;
            $task->save();
        }
    }
}
