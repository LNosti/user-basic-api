<?php

namespace Tests\app\Application\EarlyAdopter;

use App\Application\EarlyAdopter\UserService;
use App\Application\EarlyAdopter\UsersListService;
use App\Application\UserDataSource\UserDataSource;
use App\Domain\User;
use Mockery;
use Exception;
use Tests\TestCase;

class UserListServiceTest extends TestCase
{
    private UsersListService $UsersListService;
    private UserDataSource $userDataSource;

    /**
     * @setUp
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->userDataSource = Mockery::mock(UserDataSource::class);

        $this->UsersListService = new UsersListService($this->userDataSource);
    }

    /**
     * @test
     */
    public function errorGivenUserList()
    {

        $this->userDataSource
            ->expects('getList')
            ->with()
            ->once()
            ->andThrow(new Exception('Hubo un error al realizar la peticion'));

        $this->expectException(Exception::class);

        $this->UsersListService->execute();
    }

    /**
     * @test
     */
    public function emptyUsersListReturnEmptyList()
    {

        $usersList = [];

        $this->userDataSource
            ->expects('getList')
            ->with()
            ->once()
            ->andReturn($usersList);

        $userService = $this->UsersListService->execute();

        $this->assertEquals($userService,"[]");
    }



    /**
     * @test
     */
    public function idExistingReturnItsParameters()
    {

        $user1 = new User(1, 'email@email.com');
        $user2 = new User(2, 'email@email.com');
        $user3 = new User(3, 'email@email.com');
        $usersList = [$user1,$user2,$user3];

        $this->userDataSource
            ->expects('getList')
            ->with()
            ->once()
            ->andReturn($usersList);

        $userService = $this->UsersListService->execute();

        $this->assertEquals($userService,"[{id: '1'}, {id: '2'}, {id: '3'}, ]");
    }
}
