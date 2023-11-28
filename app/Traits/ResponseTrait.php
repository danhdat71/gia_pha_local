<?php

namespace App\Traits;

use Illuminate\Http\Response;

trait ResponseTrait
{
    public function errorMessage($messages)
    {
        return response()->json([
            'messages' => $messages
        ], Response::HTTP_BAD_REQUEST);
    }

    public function successMessage($messages)
    {
        return response()->json([
            'status' => true,
            'messages' => $messages,
        ], Response::HTTP_OK);
    }

    public function errorValidate($errors)
    {
        return response()->json([
            'status' => false,
            'errors' => $errors
        ], Response::HTTP_OK);
    }

    public function successData($data)
    {
        return response()->json([
            'status' => true,
            'data' => $data,
        ], Response::HTTP_OK);
    }
}