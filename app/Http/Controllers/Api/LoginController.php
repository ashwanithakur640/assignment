<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\validator;
use Illuminate\Support\Facades\Hash;
use App\User;
use JWTAuth;

class LoginController extends Controller
{
	/**
     * @OA\Post(
     *      path="/login",
     *      operationId="/login",
     *      tags={"login"},
     *      summary="login functionality",
     *      @OA\Parameter(
     *          name="email",
     *          required=true,
     *          in="query",
     *          description="Email if of user",
     *          @OA\Schema(
     *				type="string"
     *          )
     *       ),
     *      @OA\Parameter(
     *          name="password",
     *          required=true,
     *          in="query",
     *          description="password",
     *          @OA\Schema(
     *				type="string"
     *          )
     *       ),
     *      @OA\Response(
     *          response=200,
     *          description="User logged in successfully."
     *      ),
     *      @OA\Response(response=400, description="Bad Request"),
     *      @OA\Response(response=500, description="In case of Exception")
     *     )
     */
    public function login(Request $request)
    {
    	try{
	    	$reqData = $request->all();

	    	$validator = validator::make($reqData, User::loginRules(), User::loginMessages());
	    	if($validator->fails()){
	    		return $this->getJsonResponse(400, null, null, $validator->errors()->first());
	    	}
	    	if (! $token = JWTAuth::attempt($reqData)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
	    	return $this->getJsonResponse(200, $token, 'User has been login sucessfully.', null);
	    } catch (\Exception $e){
	    	return $this->getJsonResponse(500, null, null, $e->getMessage());
	    }
    }
}
