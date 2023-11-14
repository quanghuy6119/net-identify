<?php

namespace App\Providers;

use App\Domain\Repositories\Contracts\UserRepositoryInterface;
use App\Domain\Repositories\User\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider{

    public  function register(){
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }

    public  function boot(){

    }
}
