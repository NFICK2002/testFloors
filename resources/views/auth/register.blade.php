@extends('layouts.main')

@section('title')
    Регистрация
@endsection

@section('main_content')
    <div class="block_form">
        <form class="login_form" name="register_form" action="{{route('register_submit')}}" method="post">
            @csrf
            <h1 class="h1_login_form">Регистрация</h1>

            <label class="" for="surname">Фамилия</label>
            @error('surname')
            <p class="red_text">{{$message}}</p>
            @enderror
            <input class="@error('surname') red_border @enderror" type="text" id="surname" name="surname"
                   placeholder="Ваша фамилия">


            <label class="" for="name">Имя</label>
            @error('name')
            <p class="red_text">{{$message}}</p>
            @enderror
            <input class="@error('name') red_border @enderror" type="text" id="name" name="name" placeholder="Ваше имя">


            <label class="" for="last_name">Отчество</label>
            @error('last_name')
            <p class="red_text">{{$message}}</p>
            @enderror
            <input class="@error('last_name') red_border @enderror" type="text" id="last_name" name="last_name"
                   placeholder="Ваше отчество">


            <label class="" for="login">Логин</label>
            @error('login')
            <p class="red_text">{{$message}}</p>
            @enderror
            <input class="@error('login') red_border @enderror" type="text" id="login" name="login"
                   placeholder="Придумайте логин">


            <label class="" for="email">Email</label>
            @error('email')
            <p class="red_text">{{$message}}</p>
            @enderror
            <input class="@error('email') red_border @enderror" type="email" id="email" name="email"
                   placeholder="Ваш email">


            <label for="pass">Пароль</label>
            @error('password')
            <p class="red_text">{{$message}}</p>
            @enderror
            <input class="@error('password') red_border @enderror" type="password" name="password" id="pass"
                   placeholder="Введите пароль">


            <label for="pass_confirmation">Подтверждение пароля</label>
            @error('password_confirmation')
            <p class="red_text">{{$message}}</p>
            @enderror
            <input class="@error('password_confirmation') red_border @enderror" type="password"
                   name="password_confirmation" id="pass_confirmation" placeholder="Подтвердите пароль">


            <button class="c-button" type="submit">Зарегистрироваться</button>
        </form>
    </div>
@endsection
