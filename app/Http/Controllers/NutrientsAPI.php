<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NutrientsAPI extends Controller
{
    public function getAllNutrients()
    {
        $r = DB::table('nutrients')->select('id', 'name', 'dosage')->get();
        return response()->json($r, 200);
    }

    public function getNutrient($nid)
    {
        $r = DB::table('nutrients')->where("id","=",$nid)->select("id","name","dosage")->get();
        return response()->json($r, 200);
    }

    public function getBenefits($nid)
    {
        $r = DB::table('nutrients')->join("nutrients_benefits","nutrients.id","=","nutrients_benefits.nutrients_id")
                                    ->join("benefits","benefits.id","=","nutrients_benefits.benefits_id")
                                    ->where("nutrients.id","=",$nid)
                                    ->select("nutrients.name","benefits.benefit")->get();
        return response()->json($r, 200);
    }

    public function getRisks($nid)
    {
        $r = DB::table('nutrients')->join("nutrients_risks","nutrients.id","=","nutrients_risks.nutrients_id")
                                    ->join("risks","risks.id","=","nutrients_risks.risks_id")
                                    ->where("nutrients.id","=",$nid)
                                    ->select("nutrients.name","risks.risk")->get();
        return response()->json($r, 200);
    }
}
