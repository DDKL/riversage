<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Responses;
use App\ResponsesWellmatrix;
use Illuminate\Support\Facades\Log;

class ResultAPI extends Controller
{
    public function getAllResults($uid)
    {
		Log::info('getAllResults called, uid is: ' . $uid);
        $r = Responses::where('uid', $uid)->get();

        return response()->json($r, 200);
    }

    public function getResult($uid, $rid)
    {
		Log::info('getResult called, uid is: ' . $uid . 'and rid is ' . $rid);
        $sid = Responses::where([['uid', $uid], ['responses_id', $rid]])->value('surveys_id');
        if ($sid == 1)
        {
            //$r = DB::table('responses_wellmatrix')->where('responses_id', $rid)->get();
            //return response()->json(['surveys_id' => $sid, $r], 200);

            $r = ResponsesWellmatrix::join(
                    'responses', 
                    function($join) use ($rid)
                    {
                        $join->on('responses.responses_id', '=', 'responses_wellmatrix.responses_id')
                        ->where('responses_wellmatrix.responses_id', '=', $rid);
                    })
                ->select('responses.responses_id','responses_wellmatrix.value','responses.surveys_id','responses_wellmatrix.questions_id','responses.uid')
                ->get();
            return response()->json($r);
        }
    }

    public function getResultTally($uid)
    {//select count(*) from responses where uid="zxS6yS4Smrej3lZkGN4aGGgAs7P2" and surveys_id=1;

        $s1tally = Responses::where([['uid', $uid], ['surveys_id', 1]])->get()->count();
        $s2tally = Responses::where([['uid', $uid], ['surveys_id', 2]])->get()->count();
        $s3tally = Responses::where([['uid', $uid], ['surveys_id', 3]])->get()->count();
        $s4tally = Responses::where([['uid', $uid], ['surveys_id', 4]])->get()->count();

        $tally = [
            ["surveys_id" => 1, "tally" => $s1tally],
            ["surveys_id" => 2, "tally" => $s2tally],
            ["surveys_id" => 3, "tally" => $s3tally],
            ["surveys_id" => 4, "tally" => $s4tally]
        ];

        return response()->json($tally);
    }
}
