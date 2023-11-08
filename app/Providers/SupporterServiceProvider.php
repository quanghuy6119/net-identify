<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Proxy\HttpClientProxy;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Client as GuzzleHttpClient;
use App\Domain\UnitOfWork\UnitOfWork;
use App\Domain\UnitOfWork\UnitOfWorkInterface;
use Illuminate\Http\Request;


class SupporterServiceProvider extends ServiceProvider
{

    public  function register()
    {
        $this->app->when(HttpClientProxy::class)
            ->needs(ClientInterface::class)
            ->give(GuzzleHttpClient::class);

        $this->app->bind(HttpClientProxy::class, HttpClientProxy::class);

        $this->app->bind(UnitOfWorkInterface::class, UnitOfWork::class);
    }
    public  function boot()
    {
    }

    private function getBearerToken(Request $request)
    {
        $authorization = $request->headers->get("Authorization", '');
        $token = env('PASSPORT_CLIENT_TOKEN');
        if (\Str::startsWith($authorization, 'Bearer ')) {
            $token = \Str::substr($authorization, 7);
        }
        return $token;
    }
}
