<?php

namespace App\Providers;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use Kevinrob\GuzzleCache\CacheMiddleware;
use Kevinrob\GuzzleCache\Storage\LaravelCacheStorage;
use Kevinrob\GuzzleCache\Strategy\GreedyCacheStrategy;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //register a preconfigured httpclient here
        $this->app->bind(Client::class, function () {
            //push the caching middleware onto the stach
            $stack = HandlerStack::create();
            $stack->push(
                new CacheMiddleware(
                    new GreedyCacheStrategy(
                        new LaravelCacheStorage(
                            Cache::store('redis')
                        ),
                    60)
                ),
                'cache'
            );
            return new Client(['base_uri' => env('REQRES_URL'), 'handler' => $stack]);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
