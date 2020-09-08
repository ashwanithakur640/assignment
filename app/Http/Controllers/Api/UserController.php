<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\validator;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Job;
use App\JobApplication;
use JWTAuth;

class UserController extends Controller
{
	/**
     * @OA\Post(
     *      path="/register",
     *      operationId="/register",
     *      tags={"register"},
     *      summary="register functionality",
     *		@OA\Parameter(
     *          name="name",
     *          required=true,
     *          in="query",
     *          description="Name of user",
     *          @OA\Schema(
     *				type="string"
     *          )
     *       ),
     *      @OA\Parameter(
     *          name="email",
     *          required=true,
     *          in="query",
     *          description="Email id of user",
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
     *		@OA\Parameter(
     *          name="role",
     *          required=true,
     *          in="query",
     *          description="0 = job provider, 1 =job seeker",
     *          @OA\Schema(
     *				type="integer"
     *          )
     *       ),
     *      @OA\Response(
     *          response=200,
     *          description="User register successfully."
     *      ),
     *      @OA\Response(response=400, description="Bad Request"),
     *      @OA\Response(response=500, description="In case of Exception")
     *     )
     */
    public function register(Request $request)
    {
    	try{
	    	$reqData = $request->all();
	    	$validator = validator::make($reqData, User::rules(), User::messages());
	    	if($validator->fails()){
	    		return $this->getJsonResponse(400, null, null, $validator->errors()->first());
	    	}
	    	$reqData['password'] = Hash::make($reqData['password']);
	    	$user = User::create($reqData);
	    	/*$user['token'] = JWTAuth::fromUser($user);*/
	    	return $this->getJsonResponse(200, $user, 'User has been created sucessfully.', null);
	    } catch (\Exception $e){
	    	return $this->getJsonResponse(500, null, null, $e->getMessage());
	    }
    }

    /**
     * @OA\Post(
     *      path="/add-job",
     *      operationId="/add-job",
     *      tags={"add-job"},
     *      summary="Add new job functionality",
     *		@OA\Parameter(
     *          name="job_title",
     *          required=true,
     *          in="query",
     *          description="job title",
     *          @OA\Schema(
     *				type="string"
     *          )
     *       ),
     *      @OA\Parameter(
     *          name="job_description",
     *          required=true,
     *          in="query",
     *          description="job description",
     *          @OA\Schema(
     *				type="string"
     *          )
     *       ),
     *      @OA\Parameter(
     *          name="token",
     *          required=true,
     *          in="query",
     *          description="user token",
     *          @OA\Schema(
     *				type="string"
     *          )
     *       ),
     *      @OA\Response(
     *          response=200,
     *          description="Job added successfully."
     *      ),
     *      @OA\Response(response=400, description="Bad Request"),
     *      @OA\Response(response=500, description="In case of Exception")
     *     )
     */
    public function addNewJob(Request $request)
    {
    	try{
	    	$reqData = $request->all();
	    	$validator = validator::make($reqData, Job::rules(), Job::messages());
	    	if($validator->fails()){
	    		return $this->getJsonResponse(400, null, null, $validator->errors()->first());
	    	}
	    	$jwtAuthUser = JWTAuth::parseToken()->authenticate();
	    	$reqData['user_id'] = $jwtAuthUser->id;
	    	$job = Job::create($reqData);
	    	return $this->getJsonResponse(200, $job, 'Job has been added sucessfully.', null);
	    } catch (\Exception $e){
	    	return $this->getJsonResponse(500, null, null, $e->getMessage());
	    }
    }

    /**
     * @OA\Post(
     *      path="/apply-job",
     *      operationId="/apply-job",
     *      tags={"apply job"},
     *      summary="Apply for job functionality",
     *		@OA\Parameter(
     *          name="job_id",
     *          required=true,
     *          in="query",
     *          description="job id",
     *          @OA\Schema(
     *				type="integer"
     *          )
     *       ),
     *      @OA\Parameter(
     *          name="description",
     *          required=false,
     *          in="query",
     *          description="job description",
     *          @OA\Schema(
     *				type="string"
     *          )
     *       ),
     *      @OA\Parameter(
     *          name="token",
     *          required=true,
     *          in="query",
     *          description="user token",
     *          @OA\Schema(
     *				type="string"
     *          )
     *       ),
     *      @OA\Response(
     *          response=200,
     *          description="Job application added successfully."
     *      ),
     *      @OA\Response(response=400, description="Bad Request"),
     *      @OA\Response(response=500, description="In case of Exception")
     *     )
     */
    public function applyForJob(Request $request)
    {
    	try{
	    	$reqData = $request->all();
	    	$jwtAuthUser = JWTAuth::parseToken()->authenticate();
	    	$reqData['user_id'] = $jwtAuthUser->id;
	    	$jobApplication = JobApplication::create($reqData);
	    	return $this->getJsonResponse(200, $jobApplication, 'Job application has been added sucessfully.', null);
	    } catch (\Exception $e){
	    	return $this->getJsonResponse(500, null, null, $e->getMessage());
	    }
    }

    /**
     * @OA\Post(
     *      path="/request",
     *      operationId="/request",
     *      tags={"request"},
     *      summary="request status functionality",
     *		@OA\Parameter(
     *          name="job_id",
     *          required=true,
     *          in="query",
     *          description="job id",
     *          @OA\Schema(
     *				type="integer"
     *          )
     *       ),
     *      @OA\Parameter(
     *          name="request_status",
     *          required=true,
     *          in="query",
     *          description="request status",
     *          @OA\Schema(
     *				type="string"
     *          )
     *       ),
     *      @OA\Parameter(
     *          name="token",
     *          required=true,
     *          in="query",
     *          description="user token",
     *          @OA\Schema(
     *				type="string"
     *          )
     *       ),
     *      @OA\Response(
     *          response=200,
     *          description="Recuest accept or reject successfully."
     *      ),
     *      @OA\Response(response=400, description="Bad Request"),
     *      @OA\Response(response=500, description="In case of Exception")
     *     )
     */
    public function jobRequest(Request $request)
    {
    	try{
	    	$reqData = $request->all();
	    	JobApplication::where('id', $reqData['job_id'])->update(['request_status' => $reqData['request_status']]);
	    	if($reqData['request_status'] == 'Accept'){
	    		$msg = 'Request has been Accepted.';
	    	}else{
	    		$msg = 'Request has been Rejected.';
	    	}
	    	return $this->getJsonResponse(200, $request, $msg, null);
	    } catch (\Exception $e){
	    	return $this->getJsonResponse(500, null, null, $e->getMessage());
	    }
    }
}
