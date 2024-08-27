<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Work;
use App\Models\Stop;
use Carbon\Carbon;

class WorkController extends Controller
{
    public function index() {
        $user = Auth::user();
        $date = Carbon::now();
        $currentWork = Work::where('user_id', $user->id)
                ->whereNull('end_time')
                ->latest()
                ->first();
        return view('index',compact('user','date','currentWork'));
    }

    public function startWork(Request $request)
{
    $user = Auth::user();

    $existingWork = Work::where('user_id', $user->id)
                    ->whereDate('start_time', now()->toDateString())
                    ->whereNull('end_time')
                    ->latest()
                    ->first();

    if ($existingWork) {
        return redirect()->back()->with('error', '勤務はすでに開始されています。');
    }


    $existingEndWork = Work::where('user_id', $user->id)
                        ->whereDate('start_time', now()->toDateString())
                        ->whereNotNull('end_time')
                        ->latest()
                        ->first();

    if ($existingEndWork) {
        return redirect()->back()->with('error', '今日の勤務はすでに終了しています。');
    }

    Work::create([
        'user_id' => $user->id,
        'start_time' => now(),
    ]);

    return redirect()->back()->with('message', '勤怠開始しました');
}

    public function endWork(Request $request)
    {
        $user = Auth::user();

        $work = Work::where('user_id', $user->id)
            ->whereNotNull('start_time')
            ->whereNull('end_time')
            ->latest()
            ->first();

        if (!$work) {
            return redirect()->back()->with('error', '勤務が開始されていません。');
        }

        $currentBreak = Stop::where('user_id', $user->id)
            ->whereNull('break_out')
            ->latest()
            ->first();

        if ($currentBreak) {
            return redirect()->back()->with('error', '休憩を終了してから勤務終了してください。');
        }

        $endTime = now();
        $work->end_time = $endTime;

        $startTime = Carbon::parse($work->start_time);
        $totalWorkTime = $endTime->diffInMinutes($startTime);

        $breaks = Stop::where('user_id', $user->id)
            ->whereBetween('break_in', [$work->start_time, $endTime])
            ->whereNotNull('break_out')
            ->get();

        $totalBreakTime = 0;
        foreach ($breaks as $break) {
            $breakIn = Carbon::parse($break->break_in);
            $breakOut = Carbon::parse($break->break_out);
            $breakDuration = $breakOut->diffInMinutes($breakIn);
            $totalBreakTime += $breakDuration;
        }

        $work->work_time = $totalWorkTime - $totalBreakTime;
        $work->save();

        return redirect()->back()->with('message', '勤務終了しました。');
    }

    public function breakIn(Request $request)
    {
        $user = Auth::user();
        $currentWork = Work::where('user_id', $user->id)
            ->whereNull('end_time')
            ->latest()
            ->first();

        if (!$currentWork) {
            return redirect()->back()->with('error', '勤務を開始していません。');
        }

        Stop::create([
            'user_id' => $user->id,
            'work_id' => $currentWork->id,
            'break_in' => now()->format('H:i:s'),
            'break_out' => null,
            'rest_time' => null,
        ]);

        return redirect()->back()->with('message', '休憩開始しました。');
    }

    public function breakOut(Request $request)
    {
        $user = Auth::user();


        $work = Work::where('user_id', $user->id)
            ->whereNotNull('start_time')
            ->whereNull('end_time')
            ->latest()
            ->first();

        if (!$work) {
            return redirect()->back()->with('error', '勤務開始を行ってから休憩を開始してください。');
        }

        $currentBreak = Stop::where('user_id', $user->id)
            ->whereNull('break_out')
            ->latest()
            ->first();

        if (!$currentBreak) {
            return redirect()->back()->with('error', '休憩開始を行ってから休憩を終了してください。');
        }

        $breakOutTime = now();
        $restTime = $this->calculateRestTime($currentBreak->break_in, $breakOutTime);

        $currentBreak->update([
            'break_out' => $breakOutTime->format('H:i:s'),
            'rest_time' => $restTime,
        ]);

        return redirect()->back()->with('message', '休憩終了しました。');
    }

    protected function calculateRestTime($breakIn, $breakOut)
    {
    $breakInTime = Carbon::parse($breakIn);
    $breakOutTime = Carbon::parse($breakOut);

    return $breakOutTime->diffInMinutes($breakInTime);
    }

}



