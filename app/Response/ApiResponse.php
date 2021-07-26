<?php

namespace App\Response;

use Illuminate\Http\JsonResponse;
use JsonSerializable;

class ApiResponse
{
    /**
     * @param JsonSerializable|array $data
     * @return JsonResponse
     */
    public static function generateHttpResponse($data)
    {
        return new JsonResponse([
            'success' => true,
            'result' => $data,
            'message' => null,
            'error' => null,
            'request_id' => '', // this is the trace id that will help us debug. Added via AWS or CF
        ]);
    }

    /**
     * @param string $message
     * @param int $code
     * @param array $trace
     * @return JsonResponse
     */
    public static function generateErrorResponse(string $message, int $code, array $trace)
    {
        return new JsonResponse([
            'success' => false,
            'result' => null,
            'message' => $message,
            'error' => $trace,
            'request_id' => '', // this is the trace id that will help us debug. Added via AWS or CF
        ], $code);
    }
}
