<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Work;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ContentController extends Controller
{
    public function attendance(Request $request) {
    $date = Carbon::now();
    $selectedDate = Carbon::parse($request->input('date', $date->toDateString()));

    $works = Work::whereDate('start_time', $selectedDate)
                ->orderBy('user_id', 'asc')
                ->orderBy('start_time', 'asc')
                ->get();

    $workData = [];
    foreach ($works as $work) {
        $totalWorkTime = 0;
        $totalBreakTime = 0;

        // 勤務時間の計算
        if ($work->start_time && $work->end_time) {
            $startTime = Carbon::parse($work->start_time);
            $endTime = Carbon::parse($work->end_time);
            $totalWorkTime = $endTime->diffInMinutes($startTime);

            $breaks = $work->stops;

            foreach ($breaks as $break) {
                $breakStart = Carbon::parse($break->break_in);
                $breakEnd = Carbon::parse($break->break_out);

                $effectiveBreakStart = max($startTime, $breakStart);
                $effectiveBreakEnd = min($endTime, $breakEnd);

                if ($effectiveBreakStart < $effectiveBreakEnd) {
                    $totalBreakTime += $effectiveBreakEnd->diffInMinutes($effectiveBreakStart);
                }
            }
        }

        // ユーザー名を取得
        $user = $work->user;

        $workData[] = [
            'user_name' => $user->name,  // ユーザー名を追加
            'date' => $startTime->toDateString(),
            'start_time' => $work->start_time,
            'end_time' => $work->end_time,
            'totalBreakTime' => $totalBreakTime,
            'work_time' => $totalWorkTime - $totalBreakTime,
        ];
    }

    return view('attendance', [
        'workData' => $workData,
        'selectedDate' => $selectedDate,
        'date' => $date,
    ]);
}



}
