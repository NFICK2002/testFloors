<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use Illuminate\Routing\Redirector;

class AuthController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    /**
     * @param LoginRequest $req
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function login(LoginRequest $req): Redirector
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

    /**
     * @return Application|RedirectResponse|Redirector
     */
    public function logout(): Redirector
    {
        auth('web')->logout();

        return redirect(route('login'));
    }

    /**
     * @return Application|Factory|View
     */
    public function showRegisterForm(): View
    {
        return view('auth.register');
    }

    /**
     * @param RegistrationRequest $req
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function register(RegistrationRequest $req): Redirector
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
