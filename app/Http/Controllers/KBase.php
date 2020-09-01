<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KBase extends Controller
{
    public function getFeaturedProducts($ix) {
        $r = DB::table('products')->where('group_name','=',$ix)->pluck('handle');
        return response()->json($r, 200);
    }
}
