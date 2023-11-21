<?php

namespace Tests\Unit\User;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    use RefreshDatabase;

    private function service(): UserService
    {
        return new UserService(new UserRepository());
    }

    public function test_it_should_return_initial_username_when_not_exist_another_another_equal_username(): void
    {
        $name = "Test name";
        $expectedUsername = "test-name";

        $username = $this->service()->createUsername($name);
        $this->assertEquals($expectedUsername, $username);
    }

    public function test_it_should_return_a_new_username_when_already_exist_the_initial_username():void
    {
        $name = "Test name";
        $username = "test-name";

        User::factory()
            ->set('name', $name)
            ->set('username', $username)
            ->create();

        $expectedUsername = "test-name";

        $newUsername = $this->service()->createUsername($name);

        $this->assertNotEquals($expectedUsername, $newUsername);
    }
}
