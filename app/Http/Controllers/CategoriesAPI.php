<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Categories;

class CategoriesAPI extends Controller
{
    public function getCategories()
    {
        // return active categories
        $result = Categories::where('notes', 'active')
          ->select('id', 'name', 'tiers')
          ->get();

        return response()->json($result);
    }
}
