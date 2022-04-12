<?php

namespace App\Application\EarlyAdopter;

use App\Application\UserDataSource\UserDataSource;
use function PHPUnit\Framework\isEmpty;
use Exception;

class UsersListService
{
    /**
     * @var UserDataSource
     */
    private $userDataSource;

    /**
     * UserListService constructor.
     * @param UserDataSource $userDataSource
     */
    public function __construct(UserDataSource $userDataSource)
    {
        $this->userDataSource = $userDataSource;
    }

    /**
     * @return String
     * @throws Exception
     */
    public function execute(): String
    {
        $userList = $this->userDataSource->getList();

        $userListToString = '[';

        foreach($userList as $user){
            $stringUser = '{' . 'id: ' . "'".$user->getId()."'".'}, ';
            $userListToString .= $stringUser;
        }

        $userListToString .= ']';
        return $userListToString;
    }
}
