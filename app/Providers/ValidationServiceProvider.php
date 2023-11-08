<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Validation\IValidable;
use App\Validation\LoginValidator;
use App\Services\Auth\AuthService;

class ValidationServiceProvider extends ServiceProvider{
    
    public  function register(){
        $this->app->when(AuthService::class)
            ->needs(LoginValidator::class)->give(LoginValidator::class);
    }
    public  function boot(){

    }
}