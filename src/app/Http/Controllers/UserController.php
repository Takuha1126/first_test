<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Stop;
use App\Models\Work;
use Carbon\Carbon;


class UserController extends Controller
{

    public function index()
    {
        $users = User::paginate(10);
        $date = Carbon::now();
        return view('users.index', [
            'users' => $users,
            'date' => $date,
        ]);
    }

    public function show($userId)
    {
        $date = Carbon::now();
        $user = User::findOrFail($userId);

        $works = Work::where('user_id', $userId)
            ->orderBy('start_time', 'desc')
            ->get();

        $workData = [];
        foreach ($works as $work) {
            $totalWorkTime = 0;
            $totalBreakTime = 0;

            if ($work->start_time && $work->end_time) {
                $totalWorkTime = Carbon::parse($work->end_time)->diffInMinutes(Carbon::parse($work->start_time));
            }

            $breaks = Stop::where('user_id', $userId)
                ->whereBetween('break_in', [$work->start_time, $work->end_time])
                ->get();


            foreach ($breaks as $break) {
                if ($break->break_in && $break->break_out) {
                    $totalBreakTime += Carbon::parse($break->break_out)->diffInMinutes(Carbon::parse($break->break_in));
                }
            }

            $workData[] = [
                'date' => Carbon::parse($work->start_time)->toDateString(),
                'start_time' => $work->start_time,
                'end_time' => $work->end_time,
                'totalBreakTime' => $totalBreakTime,
                'work_time' => $totalWorkTime - $totalBreakTime,
            ];
        }

        return view('users.show', [
            'user' => $user,
            'workData' => $workData,
            'date' => $date,
        ]);

    }
}
