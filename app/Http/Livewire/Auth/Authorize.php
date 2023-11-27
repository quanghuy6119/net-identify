<?php

namespace App\Http\Livewire\Auth;

use App\Services\Contracts\JWTTokenServiceInterface;
use App\Utilities\Container\ContainerTrait;
use Livewire\Component;

class Authorize extends Component
{
    use ContainerTrait;
    
    public function render() {
        $jwtTokens = $this->resolve(JWTTokenServiceInterface::class);
        $users = $jwtTokens->getListCurrentAccounts();
        return view('livewire.auth.authorize', ['users' => $users]);
    }
}
