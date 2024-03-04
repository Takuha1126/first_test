<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Work;
use App\Models\User;
use App\Models\Stop;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ContentController extends Controller
{
    public function attendance(Request $request) {
    $user_id = Auth::id();
    $year = $request->input('year', date('Y'));
    $month = $request->input('month', date('n'));
    $day = $request->input('day', date('j'));
    $selectedDate = Carbon::createFromDate($year, $month, $day);
    $nextDate = $selectedDate->copy()->addDay();
    $nextDay = $nextDate->day;
    $prevDate = $selectedDate->copy()->subDay();
    $prevDay = $prevDate->day;

    $authors = Work::whereDate('start_time', $selectedDate)->orderBy('start_time', 'desc')->paginate(5);
    
    $prevMonth = ($month == 1) ? 12 : $month - 1;
    $prevYear = ($month == 1) ? $year - 1 : $year;

    $nextMonth = ($month == 12) ? 1 : $month + 1;
    $nextYear = ($month == 12) ? $year + 1 : $year;

    $selectedDate = Carbon::createFromDate($year, $month, $day);
    $date = $selectedDate->toDateString();

    $breaks = Stop::whereDate('created_at', $selectedDate)->orderBy('created_at', 'desc')->get();
    $total_break_time_seconds = [];

    foreach ($breaks as $break) {
        Log::info('Rest time: ' . $break->rest_time);
        $break_start = Carbon::parse($break->breakIn);
        $break_end = Carbon::parse($break->breakOut);
        $break_duration_seconds = $break_end->diffInSeconds($break_start);


        if (!isset($total_break_time_seconds[$break->user_id])) {
            $total_break_time_seconds[$break->user_id] = 0;
        }
        $total_break_time_seconds[$break->user_id] += $break_duration_seconds;
    }



    return view('attendance', [
        'date' => $date,
        'prevDate' => $prevDate,
        'nextDate' => $nextDate,
        'prevMonth' => $prevMonth,
        'prevYear' => $prevYear,
        'nextMonth' => $nextMonth,
        'nextYear' => $nextYear,
        'prevDay' => $prevDay,
        'nextDay' => $nextDay,
        'authors' => $authors,
        'breaks' => $breaks,
        'total_break_time_seconds' => $total_break_time_seconds,
        'user_id' => $user_id,
        'break' => $break,
    ]);
}



    public function store(Request $request){
        $this->validate($request);
        $form = $request->all();
        Work::create($form);
        return redirect('attendance');
    }
    
}
