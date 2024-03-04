<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class UserController extends Controller
{

    public function index()
    {
        $users = User::paginate(10);
        return view('users.index', ['users' => $users]);
    }

    public function show($userId)
{
    $user = User::findOrFail($userId);
    $works = $user->works;
    $stops = $user->stops;

    // 休憩時間の合計を初期化
    $total_rest_time_seconds = 0;

    foreach ($stops as $stop) {
        // 休憩時間を合計
        $total_rest_time_seconds += $stop->rest_time;
    }

    // 各作業の作業時間を計算
    foreach ($works as $work) {
        $work->start_time = Carbon::parse($work->start_time)->format('H:i:s');
        $work->end_time = Carbon::parse($work->end_time)->format('H:i:s');
        
        // 作業時間計算時に休憩時間を差し引く
        $work_time_seconds = max(0, strtotime($work->end_time) - strtotime($work->start_time) - $total_rest_time_seconds);

        $work_hours = floor($work_time_seconds / 3600);
        $work_minutes = floor(($work_time_seconds % 3600) / 60);
        $work_seconds = $work_time_seconds % 60;
        $work->work_time = sprintf('%02d:%02d:%02d', $work_hours, $work_minutes, $work_seconds);
    }

    // 休憩時間の合計を時間と分に変換
    $total_rest_hours = floor($total_rest_time_seconds / 3600);
    $total_rest_minutes = floor(($total_rest_time_seconds % 3600) / 60);
    $total_rest_seconds = $total_rest_time_seconds % 60;
    $total_rest_time_formatted = sprintf('%02d:%02d:%02d', $total_rest_hours, $total_rest_minutes, $total_rest_seconds);

    // ビューに変数を渡す
    return view('users.show', compact('user', 'works', 'stops', 'total_rest_time_formatted', 'total_rest_time_seconds'));
}
}


