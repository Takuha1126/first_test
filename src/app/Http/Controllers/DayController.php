<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class DayController extends Controller
{
    public function showDay()
    {
        $date = Carbon::now();
        return view('day',['date' => $date]);
    }

    public function redirectToAttendance($date)
    {
        $date = Carbon::parse($date)->toDateString();

        return redirect()->route('attendance', ['date' => $date]);
    }

}
