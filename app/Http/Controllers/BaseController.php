<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function sendResponse($result, $message = "Success", $status = "Success")
    {
        $response = [
            'status' => $status,
            'message' => $message,
            'data'    => $result,
        ];
    
        return response()->json($response, 200);
    }
    
    public function sendError($message, $error = "No error",  $code = 500, $status = "Not Found")
    {
        $response = [
            'status' => $status,
            'message' => $message,
            // 'error' => $error
        ];
    
        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }
    
        return response()->json($response, $code);
    }
}
