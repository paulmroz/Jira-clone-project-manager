<?php

namespace Tests\Unit;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class ProjectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_path()
    {
        $project = Project::factory()->create();

        $this->assertEquals('/projects/' . $project->id, $project->path());
    }

    /** @test */
    public function belongs_to_owner()
    {
        $project = Project::factory()->create();

        $this->assertInstanceOf(User::class, $project->owner);
    }

    /** @test  */
    public function it_can_add_a_task()
    {
        $project = Project::factory()->create();

        $task = $project->addTask('Task task');

        $this->assertCount(1, $project->tasks);

        $this->assertTrue($project->tasks->contains($task));

    }


}
