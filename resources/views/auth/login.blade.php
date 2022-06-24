@extends('layouts.main')

@section('title')
    Авторизация
@endsection

@section('main_content')
    <div class="block_form">
        <form class="login_form" name="login_form" action="{{route('login_submit')}}" method="post">
            @csrf
            <h1 class="h1_login_form">Авторизация</h1>
            <label class="" for="login">Логин</label>
            @error('login')
            <p class="red_text">{{$message}}</p>
            @enderror
            <input class="@error('login') red_border @enderror" type="text" id="login" name="login" placeholder="Введите логин">


            <label for="pass">Пароль</label>
            @error('password')
            <p class="red_text">{{$message}}</p>
            @enderror
            <input class="@error('password') red_border @enderror" type="password" name="password" id="pass" placeholder="Введите пароль">
            <button class="c-button" type="submit">Войти</button>
        </form>
    </div>
@endsection
