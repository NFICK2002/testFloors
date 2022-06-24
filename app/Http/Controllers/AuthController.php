<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;

class AuthController extends Controller
{
    public function show_login_form()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $req)
    {
        $data = [
            'login' => $req->login,
            'password' => $req->password
        ];

        if (auth('web')->attempt($data)) {


            return redirect(route('show_home'));
        }

        return redirect(route('login'))->withErrors(['login' => 'Пользователя с таким логином не существует или
         пользователь ввел неверный пароль']);
    }

    public function logout()
    {

        auth('web')->logout();

        return redirect(route('login'));
    }

    public function show_register_form()
    {
        return view('auth.register');
    }

    public function register(RegistrationRequest $req)
    {
        $user = User::create([
            'surname' => $req->surname,
            'name' => $req->name,
            'last_name' => $req->last_name,
            'login' => $req->login,
            'email' => $req->email,
            'password' => bcrypt($req->password)
        ]);

        if ($user) {
            auth('web')->login($user);
        }

        return redirect(route('show_home'));

    }
}
