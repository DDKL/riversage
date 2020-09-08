<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KBase extends Controller
{
    public function getFeaturedProducts($ix, $sx) {
        $ixsx = $ix . '_' . $sx;
        if ($ix == "i1")
        {
            $r = DB::table('products')->where('group_name','=',$ixsx)->pluck('handle');
        }
        else if ($ix == "i2")
        {
            $brands = DB::table('products')->select('brand')->where('group_name','=',$ixsx)->groupBy('brand')->get();

            $r = [];

            $brandsArr = json_decode($brands, true);
            for ($i = 0; $i < count($brandsArr); $i++)
            {
                $brand = $brandsArr[$i]["brand"];
                $brandHandle = DB::table('products')->select('handle')->where([['group_name','=',$ixsx],['brand','=',$brand]])->get();

                $bHandleArr = json_decode($brandHandle, true);
                
                for ($j = 0; $j < count($bHandleArr); $j++)
                {
                    $handle = $bHandleArr[$j]['handle'];
                    $r[$brand]['handle'][$j] = $handle;
                }
            }
        }
        else if ($ix == "i3")
        {
            $r = DB::table('products')->where('group_name','=',$ixsx)->pluck('handle');
        }
        
        return response()->json($r, 200);
    }
}
