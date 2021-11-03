<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class ProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function a_user_can_create_a_project()
    {

        $this->signIn();

        $this->get('/projects/create')->assertStatus(200);

        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->sentence,
            'notes' => 'General notes'
        ];

        $response = $this->post('/projects', $attributes);

        $project = Project::where($attributes)->first();

        $response->assertRedirect($project->path());

        $this->get($project->path())
            ->assertSee($attributes['title'])
            ->assertSee($attributes['description'])
            ->assertSee($attributes['notes']);

    }

    /** @test */
    function tasks_can_be_included_as_part_a_new_project_creation()
    {
        $this->signIn();

        $attributes = Project::factory()->raw();

        $attributes['tasks'] = [
            ['body' => 'Task 1'],
            ['body' => 'Task 2']
        ];

        $this->post('/projects', $attributes);

        $this->assertCount(2, Project::first()->tasks);
    }

    /** @test */
    function unauthorized_users_cannot_delete_projects()
    {
        $project = ProjectFactory::create();

        $this->delete($project->path())
            ->assertRedirect('/login');

        $user = $this->signIn();

        $this->delete($project->path())->assertStatus(403);

        $project->invite($user);

        $this->actingAs($user)->delete($project->path())->assertStatus(403);
    }

    /** @test */
    function a_user_can_delete_a_project()
    {
        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
            ->delete($project->path())
            ->assertRedirect('/projects');

        $this->assertDatabaseMissing('projects', $project->only('id'));
    }

    /** @test */
    function a_user_can_see_all_projects_they_have_been_invited_to_on_their_dashboard()
    {
        $project = tap(ProjectFactory::create())->invite($this->signIn());

        $this->get('/projects')->assertSee($project->title);
    }

    /** @test */
    public function a_user_can_update_a_project()
    {

        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
            ->patch($project->path(),
            $attributes = ['title' => 'Changed', 'description' => 'Changed', 'notes' => 'Changed']
        )->assertRedirect($project->path());

        $this->get($project->path() . '/edit')->assertStatus(200);

        $this->assertDatabaseHas('projects', $attributes);
    }

    /** @test */
    public function a_user_can_update_a_project_general_notes()
    {

        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
            ->patch($project->path(),
                $attributes = ['notes' => 'Changed']
            )->assertRedirect($project->path());

        $this->assertDatabaseHas('projects', $attributes);
    }

    /** @test */
    public function project_require_title()
    {
        $this->signIn();

        $attributes = Project::factory()->raw(['title' => '']);

        $this->post('/projects', [$attributes])->assertSessionHasErrors('title');
    }

    /** @test */
    public function project_require_description()
    {
        $this->signIn();

        $attributes = Project::factory()->raw(['description' => '']);

        $this->post('/projects', [$attributes])->assertSessionHasErrors('description');
    }

    /** @test */
    public function user_can_view_a_project()
    {
        $project = ProjectFactory::create();

        $this->actingAs($project->owner)->get('/projects/' . $project->id)
            ->assertSee($project->title)
            ->assertSee(Str::limit($project->description,100));
    }

    /** @test */
    public function guess_cannot_create_projects()
    {
        $attributes = Project::factory()->raw();
        $this->get('/projects/create')->assertRedirect('login');


        $this->post('/projects', [$attributes])->assertRedirect('login');

    }

    /** @test */
    public function guess_cannot_view_projects()
    {
        $this->get('/projects/create')->assertRedirect('login');

        $this->get('/projects')->assertRedirect('login');

    }

    /** @test */
    public function guess_cannot_view_a_single_project()
    {
        $project = Project::factory()->create();

        $this->get($project->path() . '/edit')->assertRedirect('login');
        $this->get('/projects/create')->assertRedirect('login');

        $this->get($project->path())->assertRedirect('login');

    }

    /** @test */
    public function authenticated_user_cannot_view_the_project_of_other_users()
    {
        $this->signIn();

        $project = Project::factory()->create();

        $this->get($project->path())->assertStatus(403);

    }

    /** @test */
    public function authenticated_user_cannot_update_the_project_of_other_users()
    {
        $this->signIn();

        $project = Project::factory()->create();

        $this->patch($project->path())->assertStatus(403);

    }
}
