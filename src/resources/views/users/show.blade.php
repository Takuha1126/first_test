@extends('layouts.add')

@section('css')
<link rel="stylesheet" href="{{ asset('css/show.css') }}">
@endsection

@section('content')
    <div class="main">
        <div class="main__ttl">
            <div class="main__title">
                <p>{{ $user->name }}さんのページ</p>
            </div>
            <div class="main__item">
                <table class="main__table">
                    <tr class="main__item-tr">
                        <th class="item__th">日付</th>
                        <th class="item__th">出勤時間</th>
                        <th class="item__th">退勤時間</th>
                        <th class="item__th">休憩時間</th>
                        <th class="item__th">勤務時間</th>
                    </tr>
                    @forelse ($workData as $work)
                        <tr class="main__item-tr">
                            <td class="main__td">{{ $work['date'] }}</td>
                            <td class="main__td">{{ $work['start_time'] }}</td>
                            <td class="main__td">{{ $work['end_time'] }}</td>
                            <td class="main__td">{{ $work['totalBreakTime'] }} 分</td>
                            <td class="main__td">{{ $work['work_time'] }} 分</td>
                        </tr>
                    @empty
                        <tr class="main__item-tr">
                            <td class="main__td" colspan="5">勤怠データはありません。</td>
                        </tr>
                    @endforelse
            </table>
        </div>
    </div>
</div>
@endsection