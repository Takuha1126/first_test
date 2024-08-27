<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/add.css') }}">
    @yield('css')
</head>
<body>
    <header class="header">
        <div class="header__inner">
            <div class="header__title">
                <a class="header__title-ttl" href="/">Atte</a>
            </div>
            <nav class="nav">
                <a class="home__button" href="{{ route('home')}}">ホーム</a>
                <a class="content__button" href="{{ route('day.show', ['date' => $date->format('Y-m-d')]) }}">日付</a>
                <a class="my__page" href="{{ route('users.index')}}">ユーザー一覧</a>
                <form action="{{route('logout') }}" method="post">
                    @csrf
                    <button class="logout__button">ログアウト</button>
                </form>
            </nav>
        </div>
    </header>
    <main>
        @yield('content')
    </main>
</body>
</html>