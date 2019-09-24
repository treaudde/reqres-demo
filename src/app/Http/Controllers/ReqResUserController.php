<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use App\Services\ReqResService;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\CreateUserRequest;
use GuzzleHttp\Exception\RequestException;

/**
 * Class ReqResUserController
 * @package App\Http\Controllers
 */
class ReqResUserController extends Controller
{
    /**
     * @var Client
     */
    protected $reqResService;

    /**
     * ReqResUserController constructor.
     * @param Client $client
     */
    public function __construct(ReqResService $reqResService)
    {
        $this->reqResService = $reqResService;
    }

    /**
     * Log in the user
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
        try {
            $response = $this->reqResService->login(
                $request->input('email'),
                $request->input('password')
            );

            return response()->make(
                $response->getBody()->getContents(),
                $response->getStatusCode(),
                ['Content-Type' =>  'application/json']);
        }
        catch (RequestException $requestException) {
            return response()->make(
                json_encode(['error' => $requestException->getMessage()]),
                400,
                ['Content-Type' =>  'application/json']
            );
        }
    }

    /**
     * Create a new user
     *
     * @param CreateUserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function createUser(CreateUserRequest $request)
    {
        try {
            $response = $this->reqResService->register(
                $request->input('email'),
                $request->input('password')
            );

            return response()->make(
                $response->getBody()->getContents(),
                $response->getStatusCode(),
                ['Content-Type' =>  'application/json']);
        }
        catch (RequestException $requestException) {
            return response()->make(
                json_encode(['error' => $requestException->getMessage()]),
                400,
                ['Content-Type' =>  'application/json']
            );
        }
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function listUsers()
    {
        try {
            $response = $this->reqResService->listUsers();

            return response()->make(
                $response->getBody()->getContents(),
                $response->getStatusCode(),
                ['Content-Type' =>  'application/json']
            );
        }
        catch (RequestException $requestException) {
            return response()->make(
                json_encode(['error' => $requestException->getMessage()]),
                400,
                ['Content-Type' =>  'application/json']
            );
        }
    }
}
