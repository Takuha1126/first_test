@extends('layouts.add')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="main">
    <div class="main__inner">
        <div class="main__title">
            <p class="main__title-ttl">{{ $user }}さんお疲れ様です!</p>
        </div>
        @if (session('message'))
                <div class="message">
                    {{session('message')}}
                </div>
            @endif
            @if (session('error'))
                <div class="message">
                    {{session('error')}}
                </div>
            @endif
        <div class="main__button">
            <div class="work__button">
                <form action="/home" method="post">
                @csrf
                    <div class="work__button-ttl">
                        <input type="hidden" name="user_id" value="user_id">
                        <button class="start__button" name="start_time" value="{{Auth::user()->id}}">勤務開始</button>
                    </div>
                </form>
                <form action="end"  method="post">
                @csrf
                    <div class="work__button-ttl">
                        <input type="hidden" name="user_id" value="user_id">
                        <button class="end__button" name="end_time" value="{{Auth::user()->id}}">勤務終了</button>
                    </div>
                </form>
            </div>
            <div class="break">
            <form action="restIn" method="post">
                @csrf
                <div class="rest__button">
                    <input type="hidden" name="user_id" value="user_id">
                    <button class="rest__start-button" name="breakIn" value="{{Auth::user()->id}}">休憩開始</button>
                </div>
            </form>
            <form action="restOut" method="post">
                @csrf
                <div class="rest__button">
                    <input type="hidden" name="user_id" value="user_id">
                    <button class="rest__end-button" name="breakOut" value="{{Auth::user()->id}}">休憩終了</button>
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
