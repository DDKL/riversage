<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KBase extends Controller
{
    public function getFeaturedProducts($ix, $sx) {
        $ixsx = $ix . '_' . $sx;
        $r = DB::table('products')->where('group_name','=',$ixsx)->pluck('handle');
        return response()->json($r, 200);
    }
}
