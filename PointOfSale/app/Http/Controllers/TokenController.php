<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerCreateRequest;
use App\Utility\ILogger;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Exception;

class TokenController extends Controller
{

    private $logger;

    public function __construct(ILogger $iLogger)
    {
        $this->logger = $iLogger;
    }

	public function authenticate(Request $request)
	{
    	$credentials = $request->only('email', 'password');

    	try {
        	if (!$token = JWTAuth::attempt($credentials)) {
            	return response()->json(['error' => 'invalid_credentials'], 400);
        	}
    	} catch (JWTException $e) {
        	return response()->json(['error' => 'could_not_create_token'], 500);
    	}

    	return response()->json(compact('token'));
	}

	public function register(CustomerCreateRequest $request)
    {
        $model = resolve('App\ViewModels\User\RegisterCustomerModel');

        try {
            $model->createCustomer($request);
            if (!$customer = $model->customer){
                return response()->json(["error" =>'name or email has been already taken'], 400);
            }
            return response()->json([
                'success' => 'Your account has been created successfully'
            ],201);

        } catch (Exception $exception){
            $this->logger->write("Failed to create customer","error", $exception);
            return response()->json (['error' => "Failed to create customer"], 500);
        }
    }

	public function getAuthenticatedUser()
	{
    	try {

        	if (!$user = JWTAuth::parseToken()->authenticate()) {
            	return response()->json(['user_not_found'], 404);
        	}
    	} catch (TokenExpiredException $e) {

        	return response()->json(['token_expired'], $e->getCode());
    	} catch (TokenInvalidException $e) {

        	return response()->json(['token_invalid'], $e->getCode());
    	} catch (JWTException $e) {

        	return response()->json(['token_absent'], $e->getCode());
    	}

    	return response()->json(compact('user'));
	}
}
