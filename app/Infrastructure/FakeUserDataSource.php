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
        $user1 = new User(1, 'email@email.com');
        $user2 = new User(2, 'email@email.com');
        $user3 = new User(3, 'email@email.com');
        $userList = [$user1,$user2,$user3];

        $numRandom = rand(1,2);
        if ($numRandom == 1){
            return $userList;
        }
        return [];
    }
}
