<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResultAPI extends Controller
{
    public function getAllResults($users_id)
    {
        $r = DB::table('responses')->where('users_id', $users_id)->get();

        return response()->json($r, 200);
    }

    public function getResult($users_id, $rid)
    {
        $sid = DB::table('responses')->where([['users_id', $users_id], ['responses_id', $rid]])->value('surveys_id');
        if ($sid == 1)
        {
            $r = DB::table('responses_wellmatrix')->where('responses_id', $rid)->select();
            return response()->json(['surveys_id' => $sid, $r], 200);
        }
    }
}
