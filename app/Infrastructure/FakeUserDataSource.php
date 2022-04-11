<?php

namespace App\Infrastructure;

use App\Application\UserDataSource\UserDataSource;
use App\Domain\User;

class FakeUserDataSource implements UserDataSource
{
    public function __construct()
    {
    }


    public function findById(int $id): User
    {
        $user = new User($id, 'email@email.com');
        return $user;
    }

    public function getList(): array
    {

    }
}
