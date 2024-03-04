@extends('layouts.add')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
<link rel="stylesheet" href="{{ asset('css/page.css') }}">
@endsection

@section('content')
<div class="main">
    <div class="main__ttl">
    <div class="first__page">
        <a class="page_ttl" href="{{ route('attendance',['year' => $prevYear,'month' => $prevMonth, 'day' => $prevDay]) }}"><</a>
            <span>{{$date}}</span>
        <a class="page_ttl" href="{{ route('attendance',['year' => $nextYear, 'month' => $nextMonth, 'day' => $nextDay]) }}">></a>
    </div>
    <div class="main__table">
        <table class="main__table-ttl">
            <tr class="main__table-title">
                <th class="main__table-th">名前</th>
                <th class="main__table-th">勤務開始</th>
                <th class="main__table-th">勤務終了</th>
                <th class="main__table-th">休憩時間</th>
                <th class="main__table-th">勤務時間</th>
            </tr> 
        @foreach ($authors as $author)
    @php
        $author_breaks = $breaks->where('user_id', $author->user_id);
        $total_break_time_seconds = 0;
        foreach ($author_breaks as $break) {
            $total_break_time_seconds += $break->rest_time;
        }
        $formatted_total_break_time = \Carbon\CarbonInterval::seconds($total_break_time_seconds)->cascade()->format('%H:%I:%S');
    @endphp

    <tr class="main__table-about">
        <td class="main__table-td">
            <input type="text" name="name" value="{{$author->user->name}}">
        </td>
        <td class="main__table-td">
            <input type="text" name="start__time" value="{{$author->start_time}}">
        </td>
        <td class="main__table-td">
            <input type="text" name="end__time" value="{{$author->end_time}}">
        </td>
        <td class="main__table-td">
            <input type="text" name="rest_time" value="{{ $formatted_total_break_time }}">
        </td>
        <td class="main__table-td">
            @php
                $start_time = \Carbon\Carbon::parse($author->start_time);
                $end_time = \Carbon\Carbon::parse($author->end_time);
                $work_duration_seconds = $end_time->diffInSeconds($start_time);
                $formatted_total_work_time = ($work_duration_seconds > 0) ? gmdate('H:i:s', $work_duration_seconds) : '00:00:00';
            @endphp
            <input type="text" name="total_work_time" value="{{ $formatted_total_work_time }}">
        </td>
    </tr>
@endforeach
        </table>
    </div>
    <div class="last__page">
       <p>{{$authors->links('vendor.pagination.bootstrap-4')}}</p>
    </div>
    </div>
</div>

<footer class="footer">
    <div class="footer_title">
        <small class="footer__small">Atte,inc.</small>
    </div>
</footer>
@endsection



