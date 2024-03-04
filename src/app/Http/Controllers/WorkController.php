<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Work;
use App\Models\Address;
use App\Models\Stop;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\WorkRequest;

class WorkController extends Controller
{
    public function index() {
        $user = Auth::user()->name;
        $date = date('Y-m-d');
        $totalBreakTime = $this->showTotalBreakTime();
        return view('index',compact('user','date'));
    }
    public function create() {
        $user = Auth::user();

        $oldStartTime = Work::where('user_id',$user->id)->latest()->first();

        $oldDay= '';

        if($oldStartTime) {
            $oldTimePunchIn = new Carbon($oldStartTime->punchIn);
            $oldDay = $oldTimePunchIn->startOfDay();
        }
        $today = Carbon::today();

        if(($oldDay == $today) && (empty($oldStartTime->punchOut))) {
            return redirect()->back()->with('message','出勤打刻済みです');
        }

        if($oldStartTime) {
            $oldTimePunchOut = new Carbon($oldStartTime->punchOut);
            $oldDay = $oldTimePunchOut->startOfDay();
        }

        if(($oldDay == $today)) {
            return redirect()->back()->with('message','退勤打刻済みです');
        }

        $time = Work::create([
            'user_id' => $user->id,
            'start_time' => Carbon::now(),
            'date' => now()->toDateString(),
        ]);

        return redirect()->back()->with('message','出勤打刻が押されました');

    }

    public function store(Request $request){
        $user = Auth::user();
        $end_time = Work::where('user_id',$user->id)->latest()->first();
        
        if(!$end_time || !$end_time->start_time) {
            return redirect()->back()->with('message','出勤打刻がされていません');
        }

        if(!$end_time->punchOut) {
            $now = Carbon::now();
            $start_time = new Carbon($end_time->start_time);
            $stayTime = $start_time->diffInMinutes($now);

            $end_time->update([
                'end_time' => $now,
                'work_time' => $stayTime
            ]);
            return redirect()->back()->with('message','退勤打刻が押されました');
        } else {
            $today = Carbon::now();
            $day = $today->day;
            $oldPunchOut = new Carbon();
            $oldPunchOutDay = $oldPunchOut->day;
            if($day == $oldPunchOutDay) {
                return redirect()->back()->with('message','退勤済みです');
            } else {
                return redirect()->back()->with('message','出勤打刻が押されていません');
            }
        }
        }
        


    public function breakIn(Request $request)
    {
        $user = Auth::user();
        $break = Stop::where('user_id',$user->id)->latest()->first();
        
        if(!$break || $break->breakOut !== null) {
            Stop::create([
                'user_id' => $user->id,
                'breakIn' => now(),
                'date' => now()->toDateString(),
            ]);
            return redirect()->back()->with('message','休憩を開始します');
        } else {
            return redirect()->back()->with('error','すでに休憩を開始しています');
        }
    }

    public function breakOut(Request $request)
{
    $user = Auth::user();
    $break = Stop::where('user_id', $user->id)->latest()->first();


    if ($break && $break->breakIn !== null && $break->breakOut === null) {
        $startTime = \Carbon\Carbon::parse($break->breakIn);
        $breakOut = now();
        $rest_time = $startTime->diffInSeconds($breakOut);

        $break->update([
            'breakOut' => $breakOut,
            'rest_time' => $rest_time,

        ]);
        return redirect()->back()->with('message','休憩を終了しました');
    }else{
        return redirect()->back()->with('error','休憩を開始していません');
    }


}
   
    
    

    private function showTotalBreakTime()
    {
        $user = Auth::user();
        $breaks = Stop::where('user_id', $user->id)
            ->whereDate('created_at', today())
            ->get();

        $totalBreakTime = 0;

        foreach ($breaks as $break) {
            if ($break->breakIn && $break->breakOut) {
                $startTime = \Carbon\Carbon::parse($break->breakIn);
                $endTime = \Carbon\Carbon::parse($break->breakOut);
                $totalBreakTime += $startTime->diffInSeconds($endTime);
            }
        }

        return $totalBreakTime;
    }
}



