<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function responseError($message = null, $status = 500)
    {
        $output = [
            'success' => false,
            'message' => $message,
        ];
        return response()->json($output, $status);
    }
    protected function responseSuccess($data = null, $status = 200)
    {
        $output = [
            'success' => true,
            'data' => $data,
        ];
        return response()->json($output, $status);
    }
}
