<?php

namespace Tests\app\Infrastructure\Controller;

use App\Application\UserDataSource\UserDataSource;
use App\Domain\User;
use Exception;
use Illuminate\Http\Response;
use Mockery;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    private UserDataSource $userDataSource;

    /**
     * @setUp
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->userDataSource = Mockery::mock(UserDataSource::class);
        $this->app->bind(UserDataSource::class, fn () => $this->userDataSource);
    }

    /**
     * @test
     */
    public function errorGivingAUser()
    {
        $this->userDataSource
            ->expects('findById')
            ->with(1)
            ->once()
            ->andThrow(new Exception('Hubo un error al realizar la peticion'));

        $response = $this->get('/api/users/1');

        $response->assertStatus(Response::HTTP_BAD_REQUEST)->assertExactJson(['error' => 'Hubo un error al realizar la peticion']);
    }

    /**
     * @test
     */
    public function userWithIdDoesNotExist()
    {
        $this->userDataSource
            ->expects('findById')
            ->with(10000)
            ->once()
            ->andThrow(new Exception('Usuario no encontrado'));

        $response = $this->get('/api/users/10000');

        $response->assertStatus(Response::HTTP_BAD_REQUEST)->assertExactJson(['error' => 'Usuario no encontrado']);
    }

    /**
     * @test
     */
    public function userIsEarlyAdopter()
    {
        $user = new User(1, 'email@email.com');

        $this->userDataSource
            ->expects('findById')
            ->with(1)
            ->once()
            ->andReturn($user);

        $response = $this->get('/api/users/1');

        $response->assertStatus(Response::HTTP_OK)->assertExactJson(['res' => '[{id: ‘1’, email:’email@email.com’}]']);
    }
}
