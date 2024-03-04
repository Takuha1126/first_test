@extends('layouts.add')

@section('css')
<link rel="stylesheet" href="{{ asset('css/user.css') }}">
<link rel="stylesheet" href="{{ asset('css/page.css') }}">
@endsection

@section('content')
    <div class="main">
        <div class="item">
            <h2 class="item__about">＜ユーザー一覧＞</h2>
            <p class="item__title">※データのみたい方のお名前をクリックしてください※</p>
            <ul class="item_ttl">
                @foreach($users as $user)
                    <li><a href="{{route('users.show',$user->id)}}">{{$user->name}}</a></li>
                @endforeach
            </ul>
            <div class="last__page">
                <p>{{$users->links('vendor.pagination.bootstrap-4')}}</p>
            </div>
        </div>
    </div>
    <footer class="footer">
        <div class="footer_title">
            <small class="footer__small">Atte,inc.</small>
        </div>
    </footer>
</body>
</html>
@endsection