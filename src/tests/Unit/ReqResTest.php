<?php

namespace Tests\Unit;

use Tests\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use App\Services\ReqResService;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Exception\RequestException;
use Illuminate\FoundaÎtion\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;


class ReqResTest extends TestCase
{
    use WithoutMiddleware;
    /**
     * Test a successful login
     */
    public function testLoginSuccess()
    {
        //mock the client so we don't call the network
        $mock = new MockHandler([
            new Response(200, [], '{"token": "QpwL5tke4Pnpja7X4"}'),
        ]);

        $handler = HandlerStack::create($mock);
        $this->app->instance(Client::class, new Client(['handler' => $handler]));

        //get the client
        $reqResClient = resolve(ReqResService::class);

        //login the user
        $response = $reqResClient->login('username', 'password');

        //
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getBody()->getContents(), '{"token": "QpwL5tke4Pnpja7X4"}');

    }

    /**
     * Test an error login
     */
    public function testLoginError()
    {
        //mock the client so we don't call the network
        $mock = new MockHandler([
            new Response(400, [], '{"error": "User not found."}'),
        ]);

        $handler = HandlerStack::create($mock);
        $this->app->instance(Client::class, new Client(['handler' => $handler]));

        //get the client
        $reqResClient = resolve(ReqResService::class);

        //login the user
        try{
            $reqResClient->login('username', 'password');
        } catch (RequestException $requestException) {
            $this->assertStringContainsString( '{"error": "User not found."}', $requestException->getMessage());
        }
    }


    /**
     * Test list users success
     */
    public function testListUsersSuccess()
    {
        //mock the client so we don't call the network
        $mock = new MockHandler([
            new Response(200, [], '{"page":1,"per_page":24,"total":1,"total_pages":1,"data":[{"id":1,"email":"george.bluth@reqres.in","first_name":"George","last_name":"Bluth","avatar":"https://s3.amazonaws.com/uifaces/faces/twitter/calebogden/128.jpg"}]}'),
        ]);

        $handler = HandlerStack::create($mock);
        $this->app->instance(Client::class, new Client(['handler' => $handler]));

        //get the client
        $reqResClient = resolve(ReqResService::class);

        //list users
        $response = $reqResClient->listUsers();

        //
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getBody()->getContents(), '{"page":1,"per_page":24,"total":1,"total_pages":1,"data":[{"id":1,"email":"george.bluth@reqres.in","first_name":"George","last_name":"Bluth","avatar":"https://s3.amazonaws.com/uifaces/faces/twitter/calebogden/128.jpg"}]}');
    }

    /**
     * Test list users error
     */
    public function testListUsersError()
    {
        //mock the client so we don't call the network
        $mock = new MockHandler([
            new Response(400, [], '{"error": "list users"}'),
        ]);

        $handler = HandlerStack::create($mock);
        $this->app->instance(Client::class, new Client(['handler' => $handler]));

        //get the client
        $reqResClient = resolve(ReqResService::class);

        //list user
        try {
            $reqResClient->listUsers();
        } catch (RequestException $requestException) {
            $this->assertStringContainsString( '{"error": "list users"}', $requestException->getMessage());
        }
    }


    /**
     * Test a successful registration
     */
    public function testRegisterSuccess()
    {
        //mock the client so we don't call the network
        $mock = new MockHandler([
            new Response(200, [], '{"token": "QpwL5tke4Pnpja7X4"}'),
        ]);

        $handler = HandlerStack::create($mock);
        $this->app->instance(Client::class, new Client(['handler' => $handler]));

        //get the client
        $reqResClient = resolve(ReqResService::class);

        //login the user
        $response = $reqResClient->register('username', 'password');

        //
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getBody()->getContents(), '{"token": "QpwL5tke4Pnpja7X4"}');

    }

    /**
     * Test an error registration
     */
    public function testRegisterError()
    {
        //mock the client so we don't call the network
        $mock = new MockHandler([
            new Response(400, [], '{"error": "Registration."}'),
        ]);

        $handler = HandlerStack::create($mock);
        $this->app->instance(Client::class, new Client(['handler' => $handler]));

        //get the client
        $reqResClient = resolve(ReqResService::class);

        //register user
        try {
            $reqResClient->register('username', 'password');
        } catch (RequestException $requestException) {
            $this->assertStringContainsString( '{"error": "Registration."}', $requestException->getMessage());
        }

    }
}
