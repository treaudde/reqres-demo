# ReqRes Demo

This a demo of a VueJS / Laravel app using the ReqRes.In Api (https://reqres.in).

## Download and run the demo
1. Make sure `docker` and `docker-compose` are installed. If not follow instructions here 
to make install them: (https://docs.docker.com/install/) and (https://docs.docker.com/compose/install/)
2. Clone the repository and `cd` into the `reqres-demo` directory: 
    ```  
    git clone https://github.com/treaudde/reqres-demo.git
    cd reqres-demo 
    ```
3. Run the demo with the following command:
`docker-compose up -d`
4.  Open your browser and go to (http://localhost:8080) to view the app

## Information about the application
Very basic Javascript validation is included in the application.  As this is a demo
and the API doesn't support JWT tokens, a rudimentary log in / log out check is done
by storing the token sent back in session storage. In a true SPA, the token
would be sent with each request and verified by the backend API.
The app is run with hashed urls
to avoid having to have a catch-all route, and possibly messing up Laravel's backend
urls.  Ideally, the front-end and back-end would be run as separate services.

## API
The api consists of the following endpoints, only accessible through Ajax requests.
A middleware implementing `$request->isAjax()` check verifies this.
The header
```
'X-Requested-With': XMLHttpRequest
```
can be set with any http client to get around this check but it provides a basic 
security check to ensure the javascript in the app, made the request

The following endpoints are available:

**METHOD** | **ENDPOINT** | **DESCRIPTION**
--- | --- | ---
POST | api/user/login | calls the ReqRes.in `/api/login` endpoint
POST | api/user/create-user | calls the ReqRes.in `api/register` endpoint
POST | api/user/list-users | calls the ReqRes.in `api/listusers` endpoint

You can log in with any user registered on the site.  And only registered users (users 
in the list) can be used for registration.  I have been using the combination 
`lindsay.ferguson@reqres.in / cityslicka`

## Tests
The API backend is nearly fully tested as it was developed with Test Driven Development
and the tests can be run with the following command:
`docker exec -it reqres-app ./vendor/phpunit/phpunit/phpunit`

## Caching
Trying to be resourceful and try something new, I tried to use a GuzzleHttp middleware
package to cache requests using Redis.  The package can be found here: 
(https://github.com/Kevinrob/guzzle-cache-middleware)

It is configurable for both private and public cache strategies and can be configured
to cache based on the request properties.  It is configurable with the default laravel
caching store configuration.

