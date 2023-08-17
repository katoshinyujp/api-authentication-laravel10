<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class ApiController extends Controller
{
    public function __construct(Request $request) {
        Log::info('['.$request->getMethod().']['. $request->getRequestUri().']', $request->all());
    }

    /**
     *
     * @param array|null $data
     * @param array $concat
     * @param string|null $message
     * @return response
     */
    public function success(array|null $data = null, array $concat = [],string $message = null) {
        $result =  array_merge([
            'code' => intval(Response::HTTP_OK.'000'),
            'status' => 'success',
            'data' => $data,
            'message' => $message,
        ], $concat);
        
        Log::info($message, $result);
        return response()->json($result , 200);
    }
    /**
     *
     * @param array|null $data
     * @param array $concat
     * @param string|null $message
     * @return response
     */
    public function errors(array|null $data = null, array $concat = [], string $message = null) {
        $result = array_merge([
            'code' => 200000,
            'status' => 'errors',
            'data' => $data,
            'message' => $message,
        ], $concat);

        Log::error($message, $result);
        return response()->json($result, 200);
    }
}
