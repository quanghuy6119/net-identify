<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    public $error = '';
    public $email = '';
    public $password = '';

    public function render()
    {
        return view('livewire.auth.login');
    }

    public function authenticate()
    {
        $this->validate(["email"=> 'required|email', "password"=> "required"]);


        Auth::attempt($this->form);
        if (Auth::attempt($this->form)) {
            session()->flash('success', "You are Logged in successfully!");
            return redirect(route("home"));
        }
        else {
            $this->error = "Email or Password wrong!!";
        }
    }
}
