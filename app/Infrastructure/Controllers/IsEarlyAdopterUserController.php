<?php

namespace App\Infrastructure\Controllers;

use App\Application\EarlyAdopter\IsEarlyAdopterService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class IsEarlyAdopterUserController extends BaseController
{
    private $isEarlyAdopterService;

    /**
     * IsEarlyAdopterUserController constructor.
     */
    public function __construct(IsEarlyAdopterService $isEarlyAdopterService)
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
