<?php

namespace Tests\Setup;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;

class ProjectFactory
{

    protected $taskCount = 0;

    protected $user;

    public function withTasks($count)
    {
        $this->taskCount = $count;

        return $this;
    }

    public function ownedBy($user)
    {
        $this->user = $user;

        return $this;
    }

    public function create()
    {
        $project = Project::factory()->create([
            'owner_id' => $this->user ?? User::factory()
        ]);

        Task::factory($this->taskCount)->create([
            'project_id' => $project->id
        ]);

        return $project;
    }

}
