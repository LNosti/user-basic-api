<?php

namespace Tests\app\Infrastructure\Controller;

use App\Application\UserDataSource\UserDataSource;
use App\Domain\User;
use Exception;
use Illuminate\Http\Response;
use Mockery;
use Tests\TestCase;

class UserListControllerTest extends TestCase
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
    public function errorGivingAListUser()
    {
        $this->userDataSource
            ->expects('getList')
            ->once()
            ->andThrow(new Exception('Hubo un error al realizar la peticion'));

        $response = $this->get('/api/users/list');

        $response->assertStatus(Response::HTTP_BAD_REQUEST)->assertExactJson(['error' => 'Hubo un error al realizar la peticion']);
    }


    /**
     * @test
     */
    public function emptyUserListReturnEmptyList()
    {
        $userList = [];
        $this->userDataSource
            ->expects('getList')
            ->with()
            ->once()
            ->andReturn($userList);

        $response = $this->get('/api/users/list');

        $response->assertStatus(Response::HTTP_OK)->assertExactJson(['res' => '[]']);
    }

    /**
     * @test
     */
    public function userListReturnsAllOfThem()
    {
        $user1 = new User(1,'email@email.com');
        $user2 = new User(2,'email@email.com');
        $user3 = new User(3,'email@email.com');
        $userList = [$user1,$user2,$user3];
        $this->userDataSource
            ->expects('getList')
            ->with()
            ->once()
            ->andReturn($userList);

        $response = $this->get('/api/users/list');

        $response->assertStatus(Response::HTTP_OK)->assertExactJson(['res' => "[{id: '1'}, {id: '2'}, {id: '3'}, ]"]);
    }



}
