<?php

namespace App\Http\Controllers\Api;

trait ApiResponseTrait
{
    public function apiResponse($data = [], $message = null, $status = 200)
    {
        $array = [
            'data'    => $data,
            'message' => $message,
            'status'  => $status,
        ];

        return response()->json($array, $status);
    }
}
