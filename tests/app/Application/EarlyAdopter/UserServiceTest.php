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
    private UserService $isEarlyAdopterService;
    private UserDataSource $userDataSource;

    /**
     * @setUp
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->userDataSource = Mockery::mock(UserDataSource::class);

        $this->isEarlyAdopterService = new UserService($this->userDataSource);
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

        $this->isEarlyAdopterService->execute($id);
    }


    /**
     * @test
     */
    public function idExistingReturnsItsParameters()
    {
        $id = 1;

        $user = new User($id, 'email@email.com');

        $this->userDataSource
            ->expects('findById')
            ->with($id)
            ->once()
            ->andReturn($user);

        $isUserEarlyAdopter = $this->isEarlyAdopterService->execute($id);

        $this->assertEquals($isUserEarlyAdopter,'[{id: ‘1’, email:’email@email.com’}]');
    }

    /**
     * @test
     */
    public function userIsAnEarlyAdopter()
    {
        $email = 'not_early_adopter@email.com';

        $user = new User(300, $email);

        $this->userDataSource
            ->expects('findByEmail')
            ->with($email)
            ->once()
            ->andReturn($user);

        $isUserEarlyAdopter = $this->isEarlyAdopterService->execute($email);

        $this->assertTrue($isUserEarlyAdopter);
    }
}
