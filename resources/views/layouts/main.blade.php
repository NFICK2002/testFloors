<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{url('css/app.css')}}">
    <script src="{{asset('js/app.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <title>@yield('title')</title>
</head>
<body>
<header>
    <div class="header_block">
        @guest('web')
            <a href="{{route('login')}}">Войти</a>
            <a href="{{route('register')}}">Регистрация</a>
        @endguest
        @auth('web')
            <a href="{{route('show_home')}}">Задачи</a>
            <a href="{{route('logout')}}">Выйти</a>
        @endauth
    </div>
</header>
<main>
    @yield('main_content')
</main>
<footer>

</footer>
</body>
<script src="{{asset('js/main.js')}}"></script>
</html>
