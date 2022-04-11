<?php

namespace App\Infrastructure\Controllers;

use App\Application\EarlyAdopter\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;


class usersListController extends BaseController
{
    private $isEarlyAdopterService;

    /**
     * UserController constructor.
     */
    public function __construct(UserService $isEarlyAdopterService)
    {
        $this->isEarlyAdopterService = $isEarlyAdopterService;
    }

    public function __invoke(int $id): JsonResponse
    {
        try {
            $isEarlyAdopter = $this->isEarlyAdopterService->execute($id);
        } catch (Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'res' => $isEarlyAdopter
        ], Response::HTTP_OK);
    }
}
