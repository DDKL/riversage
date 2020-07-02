<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SurveyAPI extends Controller
{
    public function getSurveys()
    {
        //localhost:8000/api/getsurveys/Well-Matrix
        //if (DB::table('surveys')->where('category',$cat)->exists())
        //{
            //$r = DB::table('surveys')->where('category',$cat)->get();
            $r = DB::table('surveys')->get();

            return response()->json($r);
        //}
        //else
        //{
        //    return response()->json(["message"=>"Category not found",404]);
        //}
    }

    public function getSurvey($sid)
    {
        //localhost:8000/api/getsurvey/1
        if (DB::table('surveys_questions')->where('surveys_id', $sid)->exists())
        {
            $r = DB::table('questions')
                ->join(
                    'surveys_questions', 
                    function($join) use ($sid)
                    {
                        $join->on('questions.id', '=', 'surveys_questions.questions_id')
                        ->where('surveys_questions.surveys_id', '=', $sid);
                    })
                ->get();
            return response()->json($r, 200);
        }
        else
        {
            return response()->json(["message"=>"Survey not found."], 404);
        }
    }
}
