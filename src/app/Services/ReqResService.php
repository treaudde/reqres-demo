<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

/**
 * Class ReqResService
 * @package App\Services
 */
class ReqResService
{
    /**
     * @var Client
     */
    protected $httpClient;

    /**
     * ReqResService constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->httpClient = $client;
    }

    /**
     * Login the user
     *
     * @param $email
     * @param $password
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function login($email, $password)
    {
        return $this->httpClient->post(
            '/api/login',
            [
                'json' => [
                    'email' => $email,
                    'password' => $password
                ]
            ]
        );
    }

    /**
     * List the users
     * since there are only 12 users, just getting them all
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function listUsers()
    {
        return $this->httpClient->get(
            '/api/users',
            [
                'query' => [
                    'page' => 1,
                    'per_page' => 12
                ]
            ]
        );
    }

    /**
     * Register the user
     *
     * @param $email
     * @param $password
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function register($email, $password)
    {
        return $this->httpClient->post(
            '/api/register',
            [
                'json' => [
                    'email' => $email,
                    'password' => $password
                ]
            ]
        );
    }

}
