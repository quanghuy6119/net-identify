<?php
namespace App\Providers;

use App\Services\Auth\AuthService;
use App\Services\Auth\JwtTokenService;
use App\Services\Contracts\AuthServiceInterface;
use App\Services\Contracts\JWTTokenServiceInterface;
use Illuminate\Support\ServiceProvider;

class ServiceServiceProvider extends ServiceProvider{

    public  function register(){
        $this->app->bind(JWTTokenServiceInterface::class, JwtTokenService::class);
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
    }
    
    public  function boot(){
    }
}
