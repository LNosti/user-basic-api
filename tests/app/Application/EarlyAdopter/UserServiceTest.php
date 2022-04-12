<?php

namespace Tests\app\Application\EarlyAdopter;

use App\Application\EarlyAdopter\UserService;
use App\Application\UserDataSource\UserDataSource;
use App\Domain\User;
use Exception;
use Mockery;
use PHPUnit\Framework\TestCase;

class UserServiceTest extends TestCase
{
    private UserService $userService;
    private UserDataSource $userDataSource;

    /**
     * @setUp
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->userDataSource = Mockery::mock(UserDataSource::class);

        $this->userService = new UserService($this->userDataSource);
    }

    /**
     * @test
     */
    public function errorGivenUser()
    {
        $id = 100;


        $this->userDataSource
            ->expects('findById')
            ->with($id)
            ->once()
            ->andThrow(new Exception('Hubo un error al realizar la peticion'));

        $this->expectException(Exception::class);

        $this->userService->execute($id);
    }


    /**
     * @test
     */
    public function userNotFound()
    {
        $id = 10000;


        $this->userDataSource
            ->expects('findById')
            ->with($id)
            ->once()
            ->andThrow(new Exception('Usuario no encontrado'));

        $this->expectException(Exception::class);

        $this->userService->execute($id);
    }


    /**
     * @test
     */
    public function idExistingReturnItsParameters()
    {
        $id = 1;

        $user = new User($id, 'email@email.com');

        $this->userDataSource
            ->expects('findById')
            ->with($id)
            ->once()
            ->andReturn($user);

        $userService = $this->userService->execute($id);

        $this->assertEquals($userService,'[{id: ‘1’, email:’email@email.com’}]');
    }


}
