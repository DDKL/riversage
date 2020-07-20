<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Survey;
use App\SurveysQuestions;
use App\Questions;
use App\Responses;
use App\Users;
use App\ResponsesWellmatrix;

class SurveyAPI extends Controller
{
    private function createResponse($uid = 0, $surveys_id)
    {
        $rid = Responses::insertGetId([
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

        $users_id = Users::insertGetId(
            ['first_name' => $fname, 'last_name' => $lname, 'birthday' => $bday, 'email' => $email, 'sex' => $sex, 'uid' => $uid]
        );

        return $users_id;

    }

    private function storeResults($recs, $rid)
    {
        $pid = $recs->input('pid');
        foreach($p as $pid)
        {
            DB::table('responses_products')->insert(['responses_id' => $rid, 'products_id' => $p]);
        }
    }
    public function postSurvey(Request $req, $sid)
    {
        //Save responses
        $surveys_id = $req->input('surveys_id');
        $uid = $req->input('uid');
        $info = $req->input('info');

        if (!Users::where('uid', $req->input('uid'))->exists())
        {
            $users_id = SurveyAPI::createUser($uid, $info[0]);
        }

        $responses = $req->input('responses');
        $rid = SurveyAPI::createResponse($uid, $surveys_id);

        for ($i = 0; $i < 12; $i++)
        {
            ResponsesWellmatrix::insert(
                ['value' => $responses[$i]['value'], 'questions_id' => $responses[$i]['questions_id'], 'responses_id' => $rid]
            );
        }

        return response()->json(["message" => "response successfully stored"], 200);
    }

    public function getSurveys()
    {
            $r = Survey::get();

            return response()->json($r);

    }

    public function getSurvey($sid)
    {
        if (SurveysQuestions::where('surveys_id', $sid)->exists())
        {
            $r = Questions::join(
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