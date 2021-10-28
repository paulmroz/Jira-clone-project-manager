<?php

namespace Tests\Feature;

use App\Models\Task;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RecordActivityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function creating_a_project_records_activity()
    {
        $project = ProjectFactory::create();

        $this->assertCount(1, $project->activity);
        $this->assertEquals('created', $project->activity[0]->description);
    }

    /** @test */
    function updating_a_project_records_activity()
    {
        $project = ProjectFactory::create();

        $project->update(['title' => 'Changed']);

        $this->assertCount(2, $project->activity);
        $this->assertEquals('updated', $project->activity->last()->description);
    }

    /** @test */
    function creating_a_new_task_records_project_activity()
    {
        $project = ProjectFactory::create();

        $project->addTask('Some task');

        $this->assertCount(2, $project->activity);
        $this->assertEquals('created_task', $project->activity->last()->description);
    }

    /** @test */
    function completing_a_new_task_records_project_activity()
    {
        $project = ProjectFactory::withTasks(1)->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks[0]->path(), [
                'body' => 'foobar',
                'completed' => true
            ]);

        $this->assertCount(3, $project->activity);
        $this->assertEquals('completed_task', $project->activity->last()->description);
    }
//
//    /** @test */
//    public function creating_a_project_record_activity()
//    {
//        $project = ProjectFactory::create();
//
//        $this->assertCount(1, $project->activity);
//
//        $this->assertEquals('created', $project->activity[0]->description);
//    }
//
//    /** @test */
//    public function updating_a_project_record_activity()
//    {
//        $project = ProjectFactory::create();
//
//        $project->update(['title' => 'Changed']);
//
//        $this->assertCount(2, $project->activity);
//
//        $this->assertEquals('updated', $project->activity->last()->description);
//    }
//
//    /** @test */
//    public function creating_a_new_task_records_project_activity()
//    {
//        $project = ProjectFactory::create();
//
//        $project->addTask('Some task');
//
//        $this->assertCount(2, $project->activity);
//
//        tap($project->activity->last(), function ($activity) {
//            $this->assertEquals('created_task', $activity->description);
//            $this->assertInstanceOf(Task::class, $activity->subject);
//            $this->assertEquals('Some task', $activity->subject->body);
//        });
//    }
//
//    /** @test */
//    public function completing_a_task_records_project_activity()
//    {
//        $project = ProjectFactory::withTasks(1)->create();
//
//        $this->actingAs($project->owner)->patch($project->tasks[0]->path(), [
//            'body' => 'foobar',
//            'completed' => true
//        ]);
//
//        $this->assertCount(3, $project->activity);
//
//        tap($project->activity->last(), function ($activity) {
//            $this->assertEquals('completed_task', $activity->description);
//            $this->assertInstanceOf(Task::class, $activity->subject);
//        });
//    }
//
    /** @test */
    public function incompleting_a_task_records_project_activity()
    {
        $project = ProjectFactory::withTasks(1)->create();

        $this->actingAs($project->owner)->patch($project->tasks[0]->path(), [
            'body' => 'foobar',
            'completed' => true
        ]);

        $this->assertCount(3, $project->activity);

        $this->patch($project->tasks[0]->path(), [
            'body' => 'foobar',
            'completed' => false
        ]);

        $this->assertCount(4, $project->fresh()->activity);

        $this->assertEquals('uncompleted_task', $project->fresh()->activity->last()->description);

    }
//
//    /** @test */
//    public function deleting_a_task_records_project_activity()
//    {
//        $project = ProjectFactory::withTasks(1)->create();
//
//        $project->tasks[0]->delete();
//
//        $this->assertCount(3, $project->fresh()->activity);
//
//    }

}
