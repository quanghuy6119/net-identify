<?php

namespace App\Http\Livewire\Auth;

use App\Domain\Exceptions\InvalidInputException;
use App\Providers\RouteServiceProvider;
use App\Services\Contracts\AuthServiceInterface;
use App\Utilities\Container\ContainerTrait;
use Livewire\Component;

class Login extends Component
{
    use ContainerTrait;
    public $error = '';
    public $email = '';
    public $password = '';

    public function render() {
        return view('livewire.auth.login');
    }

    public function authenticate() {
        $this->validate(["email"=> 'required|email', "password"=> "required"]);

        try {
            $authService = $this->resolve(AuthServiceInterface::class);
            $authService->attempt($this->email, $this->password);
            
            return redirect()->intended(RouteServiceProvider::HOME);
        
        } catch(InvalidInputException $ex) {
            $this->error = $ex->getError();
        }
    }
}
