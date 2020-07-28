<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Categories;
use Illuminate\Support\Facades\Log;

class CategoriesAPI extends Controller
{
    public function getCategories()
    {
		Log::info('getCategories called');
        // return active categories
        $result = Categories::where('notes', 'active')
          ->select('id', 'name', 'tiers')
          ->get();

        return response()->json($result);
    }

    public function getSubCategories($cid)
    {
		Log::info('getSubCategories called, cid is: ' . $cid);
        if (DB::table('subcategories')->where('categories_id', $cid)->exists())
            {
                $result = DB::table('subcategories')->where('categories_id', $cid)->get();
                return response()->json($result);
            }
            else
            {
                return response()->json(["message" => "subcategories not found"], 404);
            }
    }
}
