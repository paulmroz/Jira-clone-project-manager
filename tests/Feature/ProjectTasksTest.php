<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function only_project_owner_can_add_task()
    {
        $this->withoutMiddleware();
        $this->signIn();

        $project = Project::factory()->create();

        $this->post($project->path() . '/tasks', ['body' => 'Lorem ipsum'])->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'Lorem ipsum']);
    }

    /** @test */
    public function only_project_owner_can_update_task()
    {
        $this->withoutMiddleware();
        $this->signIn();
        $project = ProjectFactory::withTasks(1)->create();

        $this->patch($project->tasks[0]->path(), ['body' => 'changed'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'changed']);
    }

//    /** @test */
//    public function a_project_can_have_tasks()
//    {
//        $this->withoutMiddleware();
//        $this->withoutExceptionHandling();
//        $project = ProjectFactory::create();
//
//        $this->actingAs($project->owner)->post($project->path() . '/tasks', ['body' => 'Lorem ipsum']);
//
//        $this->get($project->path())->assertSee('Lorem ipsum');
//    }

//    /** @test */
//    public function a_task_requires_a_body()
//    {
//        $project = ProjectFactory::create();
//
//        $attributes = Task::factory()->raw(['body' => '']);
//
//        $this->actingAs($project->owner)->post($project->path().'/tasks', $attributes)->assertSessionHasErrors('body');
//    }


    ///** @test */
//    public function a_task_can_be_updated()
//    {
//        $project = ProjectFactory::withTasks(1)->create();
//
//        $this->actingAs($project->owner)
//            ->patch($project->tasks->first()->path(),[
//            'body' => 'changed',
//        ]);
//
//
//        $this->assertDatabaseHas('tasks',[
//            'body' => 'changed',
//        ]);
//
//    }

//    /** @test */
//    public function a_task_can_be_completed()
//    {
//        $project = ProjectFactory::withTasks(1)->create();
//
//        $this->actingAs($project->owner)
//            ->patch($project->tasks->first()->path(),[
//                'body' => 'changed',
//                'status' => 3
//            ]);
//
//
//        $this->assertDatabaseHas('tasks',[
//            'body' => 'changed',
//            'status_id' => 3
//        ]);
//
//    }

//    /** @test */
//    public function a_task_can_be_marked_as_incomplete()
//    {
//        $project = ProjectFactory::withTasks(1)->create();
//
//        $this->actingAs($project->owner)
//            ->patch($project->tasks->first()->path(),[
//                'body' => 'changed',
//                'status' => 3
//            ]);
//
//        $this->patch($project->tasks->first()->path(),[
//                'body' => 'changed',
//                'status' => 2
//            ]);
//
//
//        $this->assertDatabaseHas('tasks',[
//            'body' => 'changed',
//            'status_id' => 1
//        ]);
//
//    }
}
