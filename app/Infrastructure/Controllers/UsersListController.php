<?php

namespace App\Infrastructure\Controllers;

use App\Application\EarlyAdopter\UserService;

use App\Application\EarlyAdopter\UsersListService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use Exception;


class usersListController extends BaseController
{

    private $userListService;

    /**
     * UserController constructor.
     */

    public function __construct(UsersListService $userListService)
    {
        $this->userListService = $userListService;
    }

    public function __invoke(): JsonResponse
    {

        try {
            $userListService = $this->userListService->execute();

        } catch (Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([

            'res' => $userListService

        ], Response::HTTP_OK);
    }
}
