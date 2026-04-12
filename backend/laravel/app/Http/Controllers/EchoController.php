<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class EchoController extends Controller
{
    public function echo(Request $request): JsonResponse
    {
        $message = $request->input('message', 'Hello from EchoController');
        return response()->json([
            'success' => true,
            'message' => $message,
            'method' => $request->method(),
            'timestamp' => now()->toDateTimeString(),
        ]);
    }
}