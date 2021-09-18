<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerCreateRequest;
use App\Utility\ILogger;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthenticationController extends Controller
{
    private $logger;

    public function __construct(ILogger $iLogger)
    {
        $this->logger = $iLogger;
    }

    public function register(CustomerCreateRequest $request)
    {
        $model = resolve('App\ViewModels\User\RegisterCustomerModel');

        try {
            $model->createCustomer($request);
            if (!$customer = $model->customer){
                return response()->json(['errors' => ["error" =>'name or email has been already taken']], 500);
            }

            $token = JWTAuth::fromUser($customer);
            return response()->json([
                'token' => $token,
                'success' => 'Your account has been created successfully'
            ],201);

        } catch (Exception $exception){
            $this->logger->write("Failed to create customer","error", $exception);
            return response()->json(['errors' => ['error' => $exception->getMessage()]], 500);
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'wrong email or password'], 400);
            }
        } catch (JWTException $e) {
            $this->logger->write("Failed to logged in customer!", "error", $e);
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token'));
    }
}
