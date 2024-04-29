<?php

namespace App\Shared\Infrastructure\Controllers;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as STATUS;

class Response
{
    public static function NO_CONTENT(): JsonResponse
    {
        return response()->json([
        ], STATUS::HTTP_NO_CONTENT);
    }

    public static function BAD_REQUEST($message): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'status' => "BAD_REQUEST",
        ], STATUS::HTTP_BAD_REQUEST);
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

    public static function CREATED($message = "", $url = ""): JsonResponse
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

    public static function UNPROCESSABLE_ENTITY($message, $error): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'error' => $error,
            'status' => "UNPROCESSABLE_ENTITY"
        ], STATUS::HTTP_UNPROCESSABLE_ENTITY);
    }
}
