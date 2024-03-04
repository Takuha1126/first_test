@extends('layouts.add')

@section('css')
<link rel="stylesheet" href="{{ asset('css/show.css') }}">
@endsection

@section('content')
<main>
    <div class="main">
        <div class="main__title">
            <p>{{$user->name}}さんのページ</p>
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
                @foreach ($works as $work)
                @php
                    // 作業ごとに休憩時間を初期化
                    $work_rest_time_seconds = 0;

                    // 作業ごとの休憩時間を計算
                    foreach ($stops as $stop) {
                        if ($stop->date == $work->date && $stop->rest_time !== null) {
                            // 各 Stop モデルの rest_time を合計
                            $rest_time_parts = explode(':', $stop->rest_time);
                            $work_rest_time_seconds += $rest_time_parts[0] * 3600 + $rest_time_parts[1] * 60 + $rest_time_parts[2];
                        }
                    }

                    // 作業時間を時間、分、秒に変換
                    $work_start = strtotime($work->start_time);
                    $work_end = strtotime($work->end_time);
                    $work_time_seconds = max(0, $work_end - $work_start);

                    // 作業時間から休憩時間を差し引いた残りの時間を計算
                    $work_time_seconds -= $work_rest_time_seconds;

                    // 残りの時間を時間、分、秒に変換
                    $work_hours = floor($work_time_seconds / 3600);
                    $work_minutes = floor(($work_time_seconds % 3600) / 60);
                    $work_seconds = $work_time_seconds % 60;
                    $formatted_work_time = sprintf('%02d:%02d:%02d', $work_hours, $work_minutes, $work_seconds);

                    // 休憩時間を時間、分、秒に変換
                    $rest_hours = floor($work_rest_time_seconds / 3600);
                    $rest_minutes = floor(($work_rest_time_seconds % 3600) / 60);
                    $rest_seconds = $work_rest_time_seconds % 60;
                @endphp

                <!-- 以下はテーブルの行のマークアップ -->
                <tr class="main__table-about">
                    <td class="main__table-td"><input type="text" name="date" value="{{ $work->date }}"></td>
                    <td class="main__table-td"><input type="text" name="start__time" value="{{ $work->start_time }}"></td>
                    <td class="main__table-td"><input type="text" name="end__time" value="{{ $work->end_time }}"></td>
                    {{-- 休憩時間をフォーマットして表示 --}}
                    <td class="main__table-td">
                        @php
        // 残りの時間を時間、分、秒に変換
        $rest_hours = floor($total_rest_time_seconds / 3600);
        $rest_minutes = floor(($total_rest_time_seconds % 3600) / 60);
        $rest_seconds = $total_rest_time_seconds % 60;
    @endphp
    <input type="text" name="rest__time" value="{{ sprintf('%02d:%02d:%02d', $rest_hours, $rest_minutes, $rest_seconds) }}">
                    </td>
                    {{-- 作業時間をフォーマットして表示 --}}
                    <td class="main__table-td"><input type="text" name="work__time" value="{{ $formatted_work_time }}"></td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</main>
<footer class="footer">
    <div class="footer_title">
        <small class="footer__small">Atte,inc.</small>
    </div>
</footer>
@endsection
