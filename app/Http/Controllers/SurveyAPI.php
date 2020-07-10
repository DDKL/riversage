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
            ["primary" => [["handle" => "physicians-daily-multivitamin-d3", "reason" => "This product is recommended because it contains essential vitamins and minerals to support body function.", "ingredients" => ["Vitamin B-6", "Vitamin B-12", "Folate", "Vitamin D3"]], 
                            ["handle" => "paleogreens-unflavored-powder-270g", "reason" => "This product is recommended because it provides nutrients found in fruits, vegetables, nuts and seeds.", "ingredients" => ["Greens Proprietary Blend"]], 
                            ["handle" => "omegagenics-epa-dha-1000-lemon-60sg", "reason" => "This product is recommended because it contains fish oil found in fish to benefit heart, brain, and healthy fats.", "ingredients" => ["EPA", "DHA"]]], 
                "secondary" => ["primal-plants", "metaglycemx-60tab", "complete-mineral-complex-90c"]],
            ["primary" => ["inflammacore-chocolate-mint-14-servings", "mitocore-protein-blend-strawberry", "osteobase-90c"], 
                "secondary" => ["perfect-protein-whey-chocolate-30-servings", "muscle-aid", "vitamin-d-synergy-240c"]],
            ["primary" => ["melatonin-100t", "nuadapt", "adren-all-120c"], 
                "secondary" => ["brain-vitale-60c", "neurocalm-60c", "stressarrest-90c"]],
            ["primary" => ["probiotic-225-15-packets","clear-change-10-day-detox-program-with-ultraclear-renew-berry","metalloclear-180tab"], 
                "secondary" => ["histaeze-120c", "n-acetyl-cysteine-60c", "vital-reds"]]
        ];

        $p = $tmp[--$sid];

        $json = $p;

        return $json;
    }

    private function storeResults($recs, $rid)
    {
        
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

        //Generate recommendation
        $recs = SurveyAPI::recommendationAlgorithm($sid, $responses);

        //Store the recommendation in responses_products
        SurveyAPI::storeResults($recs, $rid);

        return response()->json(["message" => "response successfully stored", "products" => $recs], 200);
    }

    public function getSurveys()
    {
        //localhost:8000/api/getsurveys/Well-Matrix
        //if (DB::table('surveys')->where('category',$cat)->exists())
        //{
            //$r = DB::table('surveys')->where('category',$cat)->get();
            //$r = DB::table('surveys')->get();
            $r = Survey::get();

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
