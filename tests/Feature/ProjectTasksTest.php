<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use Database\Factories\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_project_can_have_tasks()
    {

        $this->withExceptionHandling();
        $this->signIn();

        $project = Project::factory()->create(['owner_id' => auth()->id()]);

        $this->post($project->path() . '/tasks', ['body' => 'Lorem ipsum']);

        $this->get($project->path())->assertSee('Lorem ipsum');
    }

    /** @test */
    public function a_task_requires_a_body()
    {
        $this->signIn();

        $project = Project::factory()->create(['owner_id' => auth()->id()]);

        $attributes = Task::factory()->raw(['body' => '']);

        $this->post($project->path().'/tasks', $attributes)->assertSessionHasErrors('body');
    }

    /** @test */
    public function only_project_owner_can_add_task()
    {
        $this->signIn();

        $project = Project::factory()->create();

        $this->post($project->path() . '/tasks', ['body' => 'Lorem ipsum'])->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'Lorem ipsum']);
    }

    /** @test */
    public function a_task_can_be_updated()
    {
        $this->signIn();

        $project = auth()->user()->projects()->create(
            Project::factory()->raw()
        );

        $task = $project->addTask('Test task');

        $this->patch($project->path() . '/tasks/' . $task->id,[
            'body' => 'changed',
            'completed' => true
        ]);


        $this->assertDatabaseHas('tasks',[
            'body' => 'changed',
            'completed' => true
        ]);

    }


    /** @test */
    public function only_project_owner_can_update_task()
    {
        $this->signIn();

        $project = Project::factory()->create();

        $task = $project->addTask('Task test');

        $this->patch($task->path(), ['body' => 'changed'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'changed']);
    }

}
