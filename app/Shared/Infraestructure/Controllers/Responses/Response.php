<?php

namespace App\Shared\Infraestructure\Controllers\Responses;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as STATUS;

class Response
{
    public static function NO_CONTENT($message = ""): JsonResponse
    {
        return response()->json([
            'data' => null,
            'message' => $message
        ], STATUS::HTTP_NO_CONTENT);
    }

    public static function NOT_FOUND($message = ""): JsonResponse
    {
        return response()->json([
            'message' => $message
        ], STATUS::HTTP_NOT_FOUND);
    }

    public static function OK($data, $message = ""): JsonResponse
    {
        return response()->json([
            'data' => $data,
            'message' => $message
        ], STATUS::HTTP_OK);
    }

    public static function CREATED($message = "", $url = ""): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'url' => $url
        ], STATUS::HTTP_CREATED);
    }

    public static function SERVER_ERROR($error = "Ocurrio un error inesperado"): JsonResponse
    {
        return response()->json([
            'error' => $error
        ], STATUS::HTTP_INTERNAL_SERVER_ERROR);
    }
}
