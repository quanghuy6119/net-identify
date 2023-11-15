<?php

namespace App\Http\Livewire;

use App\Services\Auth\HTTPCookieManager;
use App\Services\Contracts\AuthServiceInterface;
use App\Utilities\Container\ContainerTrait;
use Illuminate\Http\Request;
use Livewire\Component;

class Logout extends Component
{
    use ContainerTrait;
    
    public function render() {
        return view('livewire.logout');
    }

    public function logoutAllAccount() {
        $authService = $this->resolve(AuthServiceInterface::class);
        $authService->logoutAllAccount();

        return redirect(route('login'));
    }

    public function logoutSpecificAccount(Request $request) 
    {
        $token = HTTPCookieManager::getAccessToken($request);
        $authService = $this->resolve(AuthServiceInterface::class);
        $authService->logoutCurrentAccount($token);

        return redirect(route('login'));
    }
}