<?php

namespace Tests\Feature;

use App\Models\Project;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ManageProjectsTest extends TestCase
{
    use WithFaker, DatabaseTransactions;

    /** @test */
    public function guest_cannot_manage_projects()
    {
        $project = factory('App\Models\Project')->create();

        $this->get('/projects')->assertRedirect('login');
        $this->get('/projects/create')->assertRedirect('login');
        $this->post('/projects', $project->toArray())->assertRedirect('login');
        $this->get($project->path())->assertRedirect('login');
    }

    /** @test */
    public function a_user_can_create_a_project()
    {
        $this->signIn();

        $this->get('/projects/create')->assertSuccessful();

        $attributes = [
            'title' => $this->faker->sentence,
            'description' => 'Some description here.',
            'notes' => 'General notes here.'
        ];

        $response = $this->post('/projects', $attributes);

        $project = Project::where($attributes)->first();

        $response->assertRedirect($project->path());

        $this->assertDatabaseHas('projects', $attributes);

        $this->get($project->path())
            ->assertSee($attributes['title'])
            ->assertSee($attributes['description'])
            ->assertSee($attributes['notes']);
    }

    /** @test */
    public function user_can_update_a_project()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $project = factory('App\Models\Project')->create(['owner_id' => auth()->id()]);

        $this->patch($project->path(), [
            'notes' => 'Changed'
        ])->assertRedirect($project->path());

        $this->assertDatabaseHas('projects', ['notes' => 'Changed']);
    }

    /** @test */
    public function a_user_can_view_their_project()
    {
        $this->signIn();

        $project = factory('App\Models\Project')->create(['owner_id' => auth()->id()]);

        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee(str_limit($project->description));
    }

    /** @test */
    public function a_authenticated_cannot_view_the_projects_of_others()
    {
        $this->signIn();

        $project = factory('App\Models\Project')->create();

        $this->get($project->path())
            ->assertForbidden();
    }

    /** @test */
    public function a_authenticated_cannot_update_the_projects_of_others()
    {
        $this->signIn();

        $project = factory('App\Models\Project')->create();

        $this->patch($project->path(), ['notes' => 'changed'])
            ->assertForbidden();
    }

    /** @test */
    public function a_project_requires_a_title()
    {
        $this->signIn();
        $attributes = factory('App\Models\Project')->raw(['title' => '']);
        $this->post('/projects', $attributes)->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_project_requires_a_description()
    {
        $this->signIn();
        $attributes = factory('App\Models\Project')->raw(['description' => '']);
        $this->post('/projects', $attributes)->assertSessionHasErrors('description');
    }
}
