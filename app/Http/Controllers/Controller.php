<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getJsonResponse($status, $data = null, $message = null, $error = null)
    {
        /**
         * @OA\Info(
         *    description="",
         *    version="1.0.0",
         *    title="Assignment ApplicationAPI",
         *    @OA\Contact(
         *      email="ashwani@gmail.com"
         *    )
         * )
         */
        /**
         * @OA\Server(
         *    description="Assignment Local API Server",
         *    url="http://127.0.0.1:8000/api/"
         * )
         */
        
    	return response()->json([
    		'status' =>$status,
    		'data' =>$data,
    		'message' =>$message,
    		'errors' =>$error
    	], $status);
    }
}
