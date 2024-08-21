<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class NoNodesAvailableException extends Exception
{
    public function render($request): JsonResponse
    {
        return response()->json(['message' => __("No Nodes Available")], 404);
    }
}
