<?php

namespace App\Shared\Infraestructure\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as STATUS;

abstract class BaseController
{
    public static function noContent(): JsonResponse
    {
        return response()->json([
        ], STATUS::HTTP_NO_CONTENT);
    }

    public static function badRequest($message): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'status' => "BAD_REQUEST",
        ], STATUS::HTTP_BAD_REQUEST);
    }

    public static function notFound($message): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'status' => "NOT_FOUND",
        ], STATUS::HTTP_NOT_FOUND);
    }

    public static function ok($message, $data = null): JsonResponse
    {
        return response()->json([
            'data' => $data,
            'message' => $message,
            'status' => "OK"
        ], STATUS::HTTP_OK);
    }

    public static function created($message): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'status' => "CREATED"
        ], STATUS::HTTP_CREATED);
    }

    public static function serverError($error = null): JsonResponse
    {
        // TODO: remove this, only for debugging
        if (!is_null($error)) {
            dd($error);
        }

        return response()->json([
            'error' => 'Ocurrio un error inesperado',
            'status' => "SERVER_ERROR"
        ], STATUS::HTTP_INTERNAL_SERVER_ERROR);
    }

    public static function unprocessableEntity($message, $error): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'error' => $error,
            'status' => "UNPROCESSABLE_ENTITY"
        ], STATUS::HTTP_UNPROCESSABLE_ENTITY);
    }
}
