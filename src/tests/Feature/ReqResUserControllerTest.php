<?php

namespace Tests\Feature;

use Tests\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use App\Services\ReqResService;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReqResUserControllerTest extends TestCase
{
    /**
     * @var array
     */
    protected $headers;

    public function setUp(): void
    {
        parent::setUp();

        $this->headers = ['Accept' => 'application/json'];
    }

    public function testLoginSuccess()
    {
        //mock the client so we don't call the network
        $mock = new MockHandler([
            new Response(200, [], '{"token": "QpwL5tke4Pnpja7X4"}'),
        ]);

        $handler = HandlerStack::create($mock);
        $this->app->instance(Client::class, new Client(['handler' => $handler]));

        //login
        $this->post('api/user/login', ['email' => 'test@test.com', 'password' => 'password'], $this->headers)
            ->assertStatus(200)
            ->assertJson(['token' => 'QpwL5tke4Pnpja7X4']);

    }

    public function testLoginFailure()
    {
        //mock the client so we don't call the network
        $mock = new MockHandler([
            new Response(400, [], '{"error": "login failure"}'),
        ]);

        $handler = HandlerStack::create($mock);
        $this->app->instance(Client::class, new Client(['handler' => $handler]));

        //login
        $this->post('api/user/login', ['email' => 'test@test.com', 'password' => 'password'], $this->headers)
            ->assertStatus(400)
            ->assertSeeText('login failure');

    }

    public function testLoginValidationFailEmail()
    {
        //mock the client so we don't call the network
        $mock = new MockHandler([
            new Response(200, [], '{"token": "QpwL5tke4Pnpja7X4"}'),
        ]);

        $handler = HandlerStack::create($mock);
        $this->app->instance(Client::class, new Client(['handler' => $handler]));

        //login
        $this->post('api/user/login', ['password' => 'password'], $this->headers)
            ->assertStatus(422)
            ->assertJson(json_decode('{"errors":{"email":["The email field is required."]},"message":"The given data was invalid."}', true));

    }


    public function testLoginValidationFailPassword()
    {
        //mock the client so we don't call the network
        $mock = new MockHandler([
            new Response(200, [], '{"token": "QpwL5tke4Pnpja7X4"}'),
        ]);

        $handler = HandlerStack::create($mock);
        $this->app->instance(Client::class, new Client(['handler' => $handler]));

        //login
        $this->post('api/user/login', ['email' => 'email'], $this->headers)
            ->assertStatus(422)
            ->assertJson(json_decode('{"errors":{"password":["The password field is required."]},"message":"The given data was invalid."}', true));

    }


    public function testRegisterSuccess()
    {
        //mock the client so we don't call the network
        $mock = new MockHandler([
            new Response(200, [], '{"token": "QpwL5tke4Pnpja7X4"}'),
        ]);

        $handler = HandlerStack::create($mock);
        $this->app->instance(Client::class, new Client(['handler' => $handler]));

        //login
        $this->post('api/user/create-user', ['email' => 'test@test.com', 'password' => 'password'], $this->headers)
            ->assertStatus(200)
            ->assertJson(['token' => 'QpwL5tke4Pnpja7X4']);

    }

    public function testRegisterFailure()
    {
        //mock the client so we don't call the network
        $mock = new MockHandler([
            new Response(400, [], '{"error": "register failure"}'),
        ]);

        $handler = HandlerStack::create($mock);
        $this->app->instance(Client::class, new Client(['handler' => $handler]));

        //login
        $this->post('api/user/create-user', ['email' => 'test@test.com', 'password' => 'password'], $this->headers)
            ->assertStatus(400)
            ->assertSeeText('register failure');

    }

    public function testLRegisterValidationFailEmail()
    {
        //mock the client so we don't call the network
        $mock = new MockHandler([
            new Response(200, [], '{"token": "QpwL5tke4Pnpja7X4"}'),
        ]);

        $handler = HandlerStack::create($mock);
        $this->app->instance(Client::class, new Client(['handler' => $handler]));

        //login
        $this->post('api/user/create-user', ['password' => 'password'], $this->headers)
            ->assertStatus(422)
            ->assertJson(json_decode('{"errors":{"email":["The email field is required."]},"message":"The given data was invalid."}', true));

    }


    public function testRegisterValidationFailPassword()
    {
        //mock the client so we don't call the network
        $mock = new MockHandler([
            new Response(200, [], '{"token": "QpwL5tke4Pnpja7X4"}'),
        ]);

        $handler = HandlerStack::create($mock);
        $this->app->instance(Client::class, new Client(['handler' => $handler]));

        //login
        $this->post('api/user/create-user', ['email' => 'email'], $this->headers)
            ->assertStatus(422)
            ->assertJson(json_decode('{"errors":{"password":["The password field is required."]},"message":"The given data was invalid."}', true));

    }


    public function testListUsersSuccess()
    {
        //mock the client so we don't call the network
        $mock = new MockHandler([
            new Response(200, [], '{"users": "user"}'),
        ]);

        $handler = HandlerStack::create($mock);
        $this->app->instance(Client::class, new Client(['handler' => $handler]));

        //login
        $this->get('api/user/list-users', $this->headers)
            ->assertStatus(200)
            ->assertJson(['users' => 'user']);

    }

    public function testListUsersFailure()
    {
        //mock the client so we don't call the network
        $mock = new MockHandler([
            new Response(400, [], '{"error": "list users failure"}'),
        ]);

        $handler = HandlerStack::create($mock);
        $this->app->instance(Client::class, new Client(['handler' => $handler]));

        //login
        $this->get('api/user/list-users', $this->headers)
            ->assertStatus(400)
            ->assertSeeText('list users failure');

    }
}
