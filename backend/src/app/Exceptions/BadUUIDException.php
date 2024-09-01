<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;

class BadUUIDException extends Exception
{
    public function report(): JsonResponse
    {
        return response()->json([
            'error' => sprintf('%s is not a valid UUID.', $this->message),
        ], 500);
    }
}
