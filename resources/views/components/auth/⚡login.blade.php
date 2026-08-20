<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class Login extends Component
{
    public $email = '';
    public $password = '';
    public $remember = false;

    public function login()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            throw ValidationException::withMessages([
                'email' => __('These credentials do not match our records.'),
            ]);
        }

        // Redirect based on role
        if (Auth::user()->hasRole('admin')) {
            return $this->redirectRoute('admin.dashboard', navigate: true);
        } elseif (Auth::user()->hasRole('owner')) {
            return $this->redirectRoute('owner.dashboard', navigate: true);
        } else {
            return $this->redirectRoute('dashboard', navigate: true);
        }
    }

    public function render()
    {
        return view('pages.auth.login');
    }
}
