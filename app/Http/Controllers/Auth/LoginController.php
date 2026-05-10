<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    // If you keep the property, it will be overridden by the method.
    // protected $redirectTo = '/dashboard';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    protected function redirectTo()
    {
        if (auth()->user()->role === 'admin') {
            return '/admin/dashboard';
        }
        return '/dashboard';
    }

    protected function redirectPath()
    {
        return $this->redirectTo();
    }

    protected function authenticated(Request $request, $user)
    {
    if ($user->role === 'admin') {
        return redirect()->intended('/admin/dashboard');
    }
    return redirect()->intended('/dashboard');
    }
    
}