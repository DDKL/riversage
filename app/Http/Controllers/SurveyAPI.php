<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SurveyAPI extends Controller
{
    private function createResponse($uid = 0, $surveys_id)
    {
        $rid = DB::table('responses')->insertGetId([
            'uid' => $uid, 'surveys_id' => $surveys_id
        ]);

        return $rid;
    }

    private function createUser($uid = 0, $req)
    {
        $fname = $req["firstname"];
        $lname = $req["lastname"];
        $bday = $req["birthday"];
        $email = $req["email"];
        $sex = $req["sex"];

        $users_id = DB::table('users')->insertGetId(
            ['first_name' => $fname, 'last_name' => $lname, 'birthday' => $bday, 'email' => $email, 'sex' => $sex, 'uid' => $uid]
        );

        return $users_id;

    }

    private function recommendationAlgorithm($sid, $responses)
    {
        //3 levels
        $lvl = 0; 
        for ($i = 0; $i < 11; $i++)
        {
            if ($i < 6)
            {
                $lvl = $lvl + ($responses[$i]['value'] == "no" ? 1 : 0);
            }
            else
            {
                $lvl = $lvl + ($responses[$i]['value'] == "yes" ? 1 : 0);
            }   
        }

        $lvl = round($lvl/4) + 1;         
        $tmp = [
            ["physicians-daily-multivitamin-d3", "paleogreens-unflavored-powder-270g", "omegagenics-epa-dha-1000-lemon-60sg"],
            ["inflammacore-chocolate-mint-14-servings", "mitocore-protein-blend-strawberry", "osteobase-90c"],
            ["melatonin-100t", "nuadapt", "adren-all-120c"],
            ["probiotic-225-15-packets","clear-change-10-day-detox-program-with-ultraclear-renew-berry","metalloclear-180tab"]
        ];

        $p = $tmp[$sid];

        $json = ["products" => $p];

        return $json;
    }


    /*
        1. save responses
        2. generate recommendations
        3. save recommended products
        4. return recommended products
    */
    public function postSurvey(Request $req, $sid)
    {
        //Save responses
        $surveys_id = $req->input('surveys_id');
        $uid = $req->input('uid');
        $info = $req->input('info');
        //$users_id = $req->input('users_id') != "" ? $req->input('users_id') : SurveyAPI::createUser($uid, $info[0]);

        if (!DB::table('users')->where('uid', $req->input('uid'))->exists())
        {
            $users_id = SurveyAPI::createUser($uid, $info[0]);
        }
        $responses = $req->input('responses');

        $rid = SurveyAPI::createResponse($uid, $surveys_id);

        for ($i = 0; $i < 12; $i++)
        {
            DB::table('responses_wellmatrix')->insert(
                ['value' => $responses[$i]['value'], 'questions_id' => $responses[$i]['questions_id'], 'responses_id' => $rid]
            );
        }

        //Generate recommendation
        $recs = SurveyAPI::recommendationAlgorithm($sid, $responses);

        

        return response()->json([["message" => "response successfully stored"], $recs], 200);
    }

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
