<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KBase extends Controller
{
    public function getFeaturedProducts($ix, $sx) {
        $ixsx = $ix . '_' . $sx;
        if ($ix == "i2")
        {
            $brands = DB::table('products')->select('brand')->where('group_name','=',$ixsx)->groupBy('brand')->get();
            $handle = DB::table('products')->select('handle')->where('group_name','=',$ixsx)->get();

            $r = [];

            $arr = json_decode($brands, true);
            for ($i = 0; $i < count($arr); $i++)
            {
                $brand = $arr[$i]["brand"];
                $r[$i]['brand'] = $brand;
                $brandHandle = DB::table('products')->select('handle')->where([['group_name','=',$ixsx],['brand','=',$brand]])->get();

                $bArr = json_decode($brandHandle, true);
                
                for ($j = 0; $j < count($bArr); $j++)
                {
                    $handle = $bArr[$j]['handle'];
                    $r[$i]['brand'][$j]['handle'] = $handle;
                }
                //$r[$i]["handle"] = $brandHandle;
            }
        }
        else
        {
            $r = DB::table('products')->where('group_name','=',$ixsx)->pluck('handle');
        }
        
        return response()->json($r, 200);
    }
}
