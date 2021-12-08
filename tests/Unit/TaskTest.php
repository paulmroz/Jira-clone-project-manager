<?php

namespace Tests\Unit;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function task_belongs_to_a_project()
    {
        $task = Task::factory()->create();

        $this->assertInstanceOf(Project::class, $task->project);
    }

    /** @test */
    public function it_has_a_path()
    {
        $task = Task::factory()->create();

        $this->assertEquals('/projects/'.$task->project->id.'/tasks/'.$task->id ,$task->path());
    }

    /** @test */
    function it_can_be_completed()
    {
        $task = Task::factory()->create();

        $this->assertEquals(1, $task->status_id);

        $task->complete();

        $this->assertEquals(3, $task->fresh()->status_id);
    }

    /** @test */
    function it_can_be_marked_as_incomplete()
    {
        $task = Task::factory()->create(['status_id' => 3]);

        $this->assertEquals(3, $task->status_id);

        $task->incomplete();

        $this->assertEquals(1,$task->fresh()->status_id);
    }
}
