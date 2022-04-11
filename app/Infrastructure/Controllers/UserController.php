<?php

namespace App\Infrastructure\Controllers;

use App\Application\EarlyAdopter\UserService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class UserController extends BaseController
{
    private $UserService;

    /**
     * UserController constructor.
     */
    public function __construct(UserService $UserService)
    {
        $this->UserService = $UserService;
    }

    public function __invoke(int $id): JsonResponse
    {
        try {
            $UserService = $this->UserService->execute($id);
        } catch (Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'res' => $UserService
        ], Response::HTTP_OK);
    }
}
