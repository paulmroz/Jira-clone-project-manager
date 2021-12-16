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
    public function user_can_view_a_project()
    {
        $project = ProjectFactory::create();

        $this->actingAs($project->owner)->get('/projects/' . $project->id)
            ->assertSee($project->title)
            ->assertSee(Str::limit($project->description,100));
    }

    /** @test */
    function a_user_can_see_all_projects_they_have_been_invited_to_on_their_dashboard()
    {
        $project = tap(ProjectFactory::create())->invite($this->signIn());

        $this->get('/projects')->assertSee($project->title);
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
        $this->withoutMiddleware();
        $this->signIn();

        $project = Project::factory()->create();

        $this->patch($project->path())->assertStatus(403);

    }

    /** @test */
    public function guess_cannot_create_projects()
    {
        $this->get('/projects/create')->assertRedirect('login');
    }

    /** @test */
    public function project_require_title()
    {
        $this->signIn();

        $attributes = Project::factory()->raw(['title' => '']);

        $this->assertDatabaseMissing('projects',$attributes);
    }

    /** @test */
    public function project_require_description()
    {
        $this->signIn();

        $attributes = Project::factory()->raw(['description' => '']);

        $this->assertDatabaseMissing('projects', $attributes);
    }

}
