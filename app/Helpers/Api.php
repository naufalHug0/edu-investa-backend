<?php
namespace App\Helpers;

class Api {
    public static function response ($status=null,$message=null,$data=null) {
        $response = [
            "status" => $status,
            "message" => $message
        ];

        if ((is_array($data) && count($data) > 1) || is_object($data)) {
            $data = ['data' => $data];
        } 

        if ($data) {
            $response = array_merge($response, $data);
        }

        return response()->json($response,$status);
    }

    public static function serverError ($data = null) 
    {
        return self::response(500, "Internal Server Error", ['data' => $data]);
    }
}