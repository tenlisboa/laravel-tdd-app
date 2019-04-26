<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function a_user_has_projects()
    {
        $this->withoutExceptionHandling();
        $user = factory('App\Models\User')->create();

        $this->assertInstanceOf(Collection::class, $user->projects);
    }
}
