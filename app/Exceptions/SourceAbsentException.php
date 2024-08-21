<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class SourceAbsentException extends Exception
{
    public function render($request): JsonResponse
    {
        return response()->json([
            'message' => __("Currency Source does not exist!")
        ], 404);
    }
}
