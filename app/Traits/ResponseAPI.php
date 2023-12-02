<?php

namespace App\Traits;

trait ResponseAPI
{
    /**
     * Core of response
     * 
     * @param   string          $message
     * @param   integer         $statusCode  
     * @param   boolean         $isSuccess
     * @param   array|object    $data
     */
    public function coreResponse($message, $statusCode, $isSuccess = true, $data = null)
    {
        if(!$message) return response()->json(['message' => 'Message is required'], 500);
        
        if($isSuccess) {
            return response()->json([
                'message' => $message,
                'success' => true,
                'code' => $statusCode,
                'results' => $data
            ], $statusCode);
        } else {
            return response()->json([
                'message' => $message,
                'success' => false,
                'code' => $statusCode,
            ], $statusCode);
        }
    }

    /**
     * Send any success response
     * 
     * @param   string          $message
     * @param   integer         $statusCode
     * @param   array|object    $data
     */
    public function success($message, $data = [], $statusCode = 200, )
    {
        return $this->coreResponse(message: $message, statusCode: $statusCode, data: $data);
    }

    /**
     * Send any error response
     * 
     * @param   string          $message
     * @param   integer         $statusCode    
     */
    public function error($message, $statusCode = 500)
    {
        return $this->coreResponse(message: $message, statusCode: $statusCode, isSuccess: false);
    }
}