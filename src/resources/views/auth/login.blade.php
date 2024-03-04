@extends('layouts.akk')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
<link rel="stylesheet" href="{{ asset('css/error.css') }}">
@endsection

@section('content')

<div class="main">
@if (count($errors) > 0)
<p class="error-title">入力に問題があります</p>
@endif
    <div class="main__inner">
        <div class="main__title">
            <p class="main__title-ttl">ログイン</p>
        </div>
        <div class="main__item">
            <form class="form" action="/login" method="post">
                @csrf

                <div class="main__item-email">
                    <input type="email" name="email" placeholder="メールアドレス" value="{{ old('email')}}">
                </div>
                <div class="error">
                @error('email')
                {{$errors->first('email')}}
                @enderror
                </div>
                <div class="main__item-password">
                    <input type="password" name="password" placeholder="パスワード">
                </div>
                <div class="error">
                @error('password')
                {{$errors->first('password')}}
                @enderror
                </div>
                <div class="button">
                    <button class="button__submit" type="submit">ログイン</button>
                </div>
            </form>
            <div class="login">
                <form class="form__second" action="/register" method="post">
                    @csrf
                    <div class="login__item">
                        <p class="login__p">アカウントをお持ちでない方はこちら</p>
                        <a class="login__button" href="/register">会員登録</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<footer class="footer">
    <div class="footer_title">
        <small class="footer__small">Atte,inc.</small>
    </div>
</footer>
@endsection
