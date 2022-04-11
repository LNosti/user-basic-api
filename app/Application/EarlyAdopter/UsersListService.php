<?php

namespace App\Application\EarlyAdopter;

use function PHPUnit\Framework\isEmpty;

class UsersListService
{




    /**
     * @param int $id
     * @return String
     * @throws Exception
     */
    public function execute(): String
    {
        $userListToString = '[';

        $userList = $this->userDataSource->getList();



        $userListToString .= ']';
    }
}
