<?php

namespace App\Http\Controllers;

require '../vendor/autoload.php';

use App\Models\Rest;
use App\Models\User;
use App\Models\Time;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;



class RestController extends Controller
{
    public function update(Request $request)
    {
        $user = Auth::id();
        $time = Carbon::now()-> format('H:i:s');

        //勤務登録
        $currentTime = Carbon::now();
        Rest::create(['rest_start' => $time]);

        //勤務開始
        $work_start = Carbon::now();
        //勤務終了
        $work_end = Carbon::now();
        //勤務時間
        $work_total = $work_end->diff($work_start)->format('%H:%I:%S');

        //休憩開始
        $rest_start = Carbon::now();
        //休憩終了
        $rest_end = Carbon::now();
        //休憩時間
        $rest_total = $rest_end->diff($rest_start)-> format('%H:%I:%S');

        return view( 'attendance', compact('user', 'time','work_total','rest_total'));
    }

    public function start(Request $request)
    {
        $user = Auth::id();
        // timesテーブルから最新のレコードを取得
        $latest_time = Time::latest()->first();
        $rest_start = Carbon::now();

         $lastRecord = Time::where('user_id', $user)->latest()->first();

        $restStartButtonDisabled = true; // ボタンの活性化

        // 勤務開始ボタンの状態を取得
        $workStartButtonDisabled = $lastRecord->work_start !== null;

          $workEndButtonDisabled = $lastRecord->work_end !== null;


          if ($latest_time) {
        $time_id = $latest_time->id;
        // 最新の勤務情報がある場合、ボタンを非アクティブにする
        $restStartButtonDisabled = false;
    } else {
        // 最新のレコードが存在しない場合は、エラーメッセージを設定する
        return back()->withErrors('No time record found.');
    }
    
        Rest::create([
        'time_id' => $time_id,
        'rest_start' => $rest_start
    ]);



    // リダイレクトなどの適切なレスポンスを返す
    return view( 'index', compact('time_id','rest_start','workStartButtonDisabled','workEndButtonDisabled','restStartButtonDisabled'));
}


    public function end(Request $request)
    {
    
        $user = Auth::id();
        // timesテーブルから最新のレコードを取得
        $latest_time = Time::latest()->first();
        $rest_end = Carbon::now();
        $buttonDisabled = false; // ボタンの活性化
    
     // 最新のレコードが存在する場合、その time_id を取得
        if ($latest_time) {
        $time_id = $latest_time->id;
        }
        else {
        // 最新のレコードが存在しない場合は、適切なエラー処理を行う
        return back()->withErrors('No time record found.');
    }


    // 最新の勤務レコードを取得
        $rest_record = Rest::where('time_id', $time_id)->latest()->first();

    if ($rest_record) {
        $rest_record->update(['rest_end' => $rest_end]);
    } else {
         // レコードが見つからなかった場合は、適切なエラー処理を行う
        return back()->withErrors('No rest record found for the given time.');
    }

    // リダイレクトなどの適切なレスポンスを返す
     return view( 'index', compact('time_id','rest_end','buttonDisabled'));
}
}
