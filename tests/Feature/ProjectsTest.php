<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class ProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function user_can_create_project()
    {
        $this->withExceptionHandling();
        $this->signIn();
        $this->get('/projects/create')->assertStatus(200);

        $attributes = Project::factory()->raw(['owner_id' => auth()->id()]);

        $this->post('/projects', $attributes)->assertRedirect('/projects');

        $this->assertDatabaseHas('projects', $attributes);

        $this->get('/projects')->assertSee($attributes['title']);
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
        $this->signIn();

        $project = Project::factory()->create(['owner_id' => auth()->id()]);

        $this->get('/projects/' . $project->id)
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
}
