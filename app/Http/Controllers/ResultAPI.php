<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Responses;
use App\ResponsesWellmatrix;

class ResultAPI extends Controller
{
    public function getAllResults($uid)
    {
        $r = Responses::where('uid', $uid)->get();

        return response()->json($r, 200);
    }

    public function getResult($uid, $rid)
    {
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
}
