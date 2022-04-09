<?php

namespace App\Application\EarlyAdopter;

use App\Application\UserDataSource\UserDataSource;
use Exception;
use PhpParser\Node\Scalar\String_;
use function PHPUnit\Framework\isEmpty;

class IsEarlyAdopterService
{
    /**
     * @var UserDataSource
     */
    private $userDataSource;

    /**
     * IsEarlyAdopterService constructor.
     * @param UserDataSource $userDataSource
     */
    public function __construct(UserDataSource $userDataSource)
    {
        $this->userDataSource = $userDataSource;
    }

    /**
     * @param int $id
     * @return String
     * @throws Exception
     */
    public function execute(int $id): String
    {

        $user = $this->userDataSource->findById($id);

        print_r($user -> getId());
        print_r($user -> getEmail());

        if (!isEmpty($id)){
            return 1;
        }
        else if ($user -> getId() < 1000) {
            return '[{id: ‘'.$id.'’, email:’email@email.com’}]';
        }
        return 3;
    }
}
