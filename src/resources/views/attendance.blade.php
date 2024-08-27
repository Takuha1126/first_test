@extends('layouts.add')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
<link rel="stylesheet" href="{{ asset('css/page.css') }}">
@endsection

@section('content')
    <div class="main">
        <div class="main__ttl">
            <div class="main__table">
                <table class="main__table-ttl">
                    <tr class="main__table-title">
                        <th class="main__table-th">名前</th>
                        <th class="main__table-th">勤務開始</th>
                        <th class="main__table-th">勤務終了</th>
                        <th class="main__table-th">休憩時間</th>
                        <th class="main__table-th">勤務時間</th>
                    </tr>
                    @forelse ($workData as $work)
                        <tr class="main__table-about">
                            <td class="main__table-td">
                                {{ $work['user_name'] }}
                            </td>
                            <td class="main__table-td">
                                {{ $work['start_time'] }}
                            </td>
                            <td class="main__table-td">
                                {{ $work['end_time'] }}
                            </td>
                            <td class="main__table-td">
                                {{ $work['totalBreakTime'] }} 分
                            </td>
                            <td class="main__table-td">
                                {{ $work['work_time'] }} 分
                            </td>
                        </tr>
                    @empty
                        <tr class="main__table-about">
                            <td class="main__table-td" colspan="5">勤怠データはありません。</td>
                        </tr>
                    @endforelse
                </table>
            </div>
        </div>
    </div>
@endsection