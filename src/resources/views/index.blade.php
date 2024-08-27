@extends('layouts.add')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
    <div class="main">
        <div class="main__inner">
            <div class="main__title">
                <p class="main__title-ttl">{{ $user->name }}さんお疲れ様です!</p>
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
                    <form action="{{ route('work.start') }}" method="post">
                        @csrf
                        <div class="work__button-ttl">
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                            <button type="submit" class="start__button">勤務開始</button>
                        </div>
                    </form>
                    <form action="{{ route('work.end') }}"  method="post">
                        @csrf
                        <div class="work__button-ttl">
                            <input type="hidden" name="user_id" value="user_id">
                            <button class="end__button" name="end_time" value="{{Auth::user()->id}}">勤務終了</button>
                        </div>
                    </form>
                </div>
                <div class="break">
                    <form action="{{ route('break.in') }}" method="post">
                    @csrf
                        <div class="rest__button">
                            <input type="hidden" name="user_id" value="user_id">
                            <button class="rest__start-button" name="break_in" value="{{Auth::user()->id}}">休憩開始</button>
                        </div>
                    </form>
                    <form action="{{ route('break.out') }}" method="post">
                    @csrf
                        <div class="rest__button">
                            <input type="hidden" name="user_id" value="user_id">
                            <button class="rest__end-button" name="break_out" value="{{Auth::user()->id}}">休憩終了</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
