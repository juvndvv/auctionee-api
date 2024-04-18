<?php

namespace App\Shared\Infraestructure\Controllers;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as STATUS;

class Response
{
    public static function NO_CONTENT($message = ""): JsonResponse
    {
        return response()->json([
            'data' => null,
            'message' => $message,
            'status' => "NO_CONTENT",
        ], STATUS::HTTP_NO_CONTENT);
    }

    public static function NOT_FOUND($message = ""): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'status' => "NOT_FOUND",
        ], STATUS::HTTP_NOT_FOUND);
    }

    public static function OK($data, $message = ""): JsonResponse
    {
        return response()->json([
            'data' => $data,
            'message' => $message,
            'status' => "OK"
        ], STATUS::HTTP_OK);
    }

    public static function CREATED($data = null, $message = "", $url = ""): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'url' => $url,
            'status' => "CREATED"
        ], STATUS::HTTP_CREATED);
    }

    public static function SERVER_ERROR($error = "Ocurrio un error inesperado"): JsonResponse
    {
        return response()->json([
            'error' => $error,
            'status' => "SERVER_ERROR"
        ], STATUS::HTTP_INTERNAL_SERVER_ERROR);
    }
}
