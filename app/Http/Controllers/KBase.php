<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KBase extends Controller
{
    public function getFeaturedProducts($ix, $sx) 
    {
        $ixsx = $ix . '_' . $sx;

        if ($ix == "i1")
        {
            $r = DB::table('products')->where([['group_name','=',$ixsx], ['status','=',1]])->pluck('handle');
        }
        else if ($ix == "i2")
        {
            $brands = DB::table('products')->select('brand')->where('group_name','=',$ixsx)->groupBy('brand')->get();

            $r = [];

            $brandsArr = json_decode($brands, true);
            for ($i = 0; $i < count($brandsArr); $i++)
            {
                $brand = $brandsArr[$i]["brand"];
                $brandHandle = DB::table('products')->select('handle')->where([['group_name','=',$ixsx],['brand','=',$brand], ['status','=',1]])->get();

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
            $r = DB::table('products')->where([['group_name','=',$ixsx], ['status','=',1]])->pluck('handle');
        }
        
        return response()->json($r, 200);
    }

/*

ok
{
"i1": {
  "nutritional_wellness": {"title": "", "description": "", "price": "0.00", "discountedPrice": "0.00", "products": ["handle1", "handle2"]},
  "physical_wellness": {"title": "", "description": "", "price": "0.00", "discountedPrice": "0.00", "products": ["handle1", "handle2"]},
  "emotional_wellness": {"title": "", "description": "", "price": "0.00", "discountedPrice": "0.00", "products": ["handle1", "handle2"]},
  "environmental_wellness": {"title": "", "description": "", "price": "0.00", "discountedPrice": "0.00", "products": ["handle1", "handle2"]}
},
"i2": {
  "female_breastfeeding" {
    "Metagenics": {"title": "", "description": "", "price": "0.00", "discountedPrice": "0.00", "products": ["handle1", "handle2"]},
    "Orthomolecular": {"title": "", "description": "", "price": "0.00", "discountedPrice": "0.00", "products": ["handle1", "handle2"]},
    "Designs For Health": {"title": "", "description": "", "price": "0.00", "discountedPrice": "0.00", "products": ["handle1", "handle2"]}
  },
  "female_40u" {
    "Metagenics": ["handle1", "handle2"],
    "Orthomolecular": ["handle1", "handle2"],
    "Designs For Health": ["handle1", "handle2"]
  }...
...
...
},
"i3": {
  "energy": ["handle1", "handle2"],
  "circulation": ["handle1", "handle2"],
  ...
...
...
...
},
*/

    public function getBundles($ix)
    {
        $json = [];
        if ($ix == "i1")
        {
            $query = DB::table('products')->where([['group_name', '=', 'i1_nutritional_wellness'], ['status','=',1]])->pluck('handle');
            $queryBundle = DB::table('products')->where([['group_name', '=', 'i1_nutritional_wellness'], ['status','=',1]])->pluck('bundle');
            $bundle = json_decode($queryBundle, true);
            $handleArr = json_decode($query, true);
            // $json['nutritional_wellness']['title'] = 'Nutritional Wellness Bundle';
            // $json['nutritional_wellness']['description'] = 'This is the Nutritional Wellness Bundle';
            // $json['nutritional_wellness']['price'] = 499;
            // $json['nutritional_wellness']['discountedPrice'] = 399;

            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['nutritional_wellness']['products'][$i] = $handleArr[$i];
            }
            $json['nutritional_wellness']['bundle'] = $bundle[0];

            $query = DB::table('products')->where([['group_name', '=', 'i1_environmental_wellness'], ['status','=',1]])->pluck('handle');
            $queryBundle = DB::table('products')->where([['group_name', '=', 'i1_environmental_wellness'], ['status','=',1]])->pluck('bundle');
            $bundle = json_decode($queryBundle, true);
            $handleArr = json_decode($query, true);

            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['environmental_wellness']['products'][$i] = $handleArr[$i];
            }
            $json['environmental_wellness']['bundle'] = $bundle[0];

            $query = DB::table('products')->where([['group_name', '=', 'i1_physical_wellness'], ['status','=',1]])->pluck('handle');
            $queryBundle = DB::table('products')->where([['group_name', '=', 'i1_physical_wellness'], ['status','=',1]])->pluck('bundle');
            $bundle = json_decode($queryBundle, true);
            $handleArr = json_decode($query, true);

            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['physical_wellness']['products'][$i] = $handleArr[$i];
            }
            $json['physical_wellness']['bundle'] = $bundle[0];

            $query = DB::table('products')->where([['group_name', '=', 'i1_emotional_wellness'], ['status','=',1]])->pluck('handle');
            $queryBundle = DB::table('products')->where([['group_name', '=', 'i1_emotional_wellness'], ['status','=',1]])->pluck('bundle');
            $bundle = json_decode($queryBundle, true);
            $handleArr = json_decode($query, true); 

            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['emotional_wellness']['products'][$i] = $handleArr[$i];
            }
            $json['emotional_wellness']['bundle'] = $bundle[0];
        }
        else if ($ix == "i2")
        {
            $json = [];
            
            $query = DB::table('products')->where([['group_name', '=', 'i2_female_breastfeeding'], ['brand','=','Metagenics'], ['status','=',1]])->pluck('handle');
            $queryBundle = DB::table('products')->where([['group_name', '=', 'i2_female_breastfeeding'], ['brand','=','Metagenics'], ['status','=',1]])->pluck('bundle');
            $bundle = json_decode($queryBundle, true);
            $handleArr = json_decode($query, true);

            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['female_breastfeeding']['Metagenics']['products'][$i] = $handleArr[$i];
            }
            $json['female_breastfeeding']['Metagenics']['bundle'] = $bundle[0];
            
            $query = DB::table('products')->where([['group_name', '=', 'i2_female_breastfeeding'], ['brand','=','Orthomolecular'], ['status','=',1]])->pluck('handle');
            $queryBundle = DB::table('products')->where([['group_name', '=', 'i2_female_breastfeeding'], ['brand','=','Orthomolecular'], ['status','=',1]])->pluck('bundle');
            $bundle = json_decode($queryBundle, true);
            $handleArr = json_decode($query, true);

            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['female_breastfeeding']['Orthomolecular']['products'][$i] = $handleArr[$i];
            }
            $json['female_breastfeeding']['Orthomolecular']['bundle'] = $bundle[0];
            
            $query = DB::table('products')->where([['group_name', '=', 'i2_female_breastfeeding'], ['brand','=','Designs For Health'], ['status','=',1]])->pluck('handle');
            $queryBundle = DB::table('products')->where([['group_name', '=', 'i2_female_breastfeeding'], ['brand','=','Designs For Health'], ['status','=',1]])->pluck('bundle');
            $bundle = json_decode($queryBundle, true);
            $handleArr = json_decode($query, true);

            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['female_breastfeeding']['Designs For Health']['products'][$i] = $handleArr[$i];
            }
            $json['female_breastfeeding']['Designs For Health']['bundle'] = $bundle[0];
            
            $query = DB::table('products')->where([['group_name', '=', 'i2_female_menopause'], ['brand','=','Metagenics'], ['status','=',1]])->pluck('handle');
            $queryBundle = DB::table('products')->where([['group_name', '=', 'i2_female_menopause'], ['brand','=','Metagenics'], ['status','=',1]])->pluck('bundle');
            $bundle = json_decode($queryBundle, true);
            $handleArr = json_decode($query, true);

            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['female_menopause']['Metagenics']['products'][$i] = $handleArr[$i];
            }
            $json['female_menopause']['Metagenics']['bundle'] = $bundle[0];
            
            $query = DB::table('products')->where([['group_name', '=', 'i2_female_menopause'], ['brand','=','Orthomolecular'], ['status','=',1]])->pluck('handle');
            $queryBundle = DB::table('products')->where([['group_name', '=', 'i2_female_menopause'], ['brand','=','Orthomolecular'], ['status','=',1]])->pluck('bundle');
            $bundle = json_decode($queryBundle, true);
            $handleArr = json_decode($query, true);

            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['female_menopause']['Orthomolecular']['products'][$i] = $handleArr[$i];
            }
            $json['female_menopause']['Orthomolecular']['bundle'] = $bundle[0];
            
            $query = DB::table('products')->where([['group_name', '=', 'i2_female_menopause'], ['brand','=','Designs For Health'], ['status','=',1]])->pluck('handle');
            $queryBundle = DB::table('products')->where([['group_name', '=', 'i2_female_menopause'], ['brand','=','Designs For Health'], ['status','=',1]])->pluck('bundle');
            $bundle = json_decode($queryBundle, true);
            $handleArr = json_decode($query, true);

            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['female_menopause']['Designs For Health']['products'][$i] = $handleArr[$i];
            }
            $json['female_menopause']['Designs For Health']['bundle'] = $bundle[0];
            
            $query = DB::table('products')->where([['group_name', '=', 'i2_female_menstruating'], ['brand','=','Metagenics'], ['status','=',1]])->pluck('handle');
            $queryBundle = DB::table('products')->where([['group_name', '=', 'i2_female_menstruating'], ['brand','=','Metagenics'], ['status','=',1]])->pluck('bundle');
            $bundle = json_decode($queryBundle, true);
            $handleArr = json_decode($query, true);

            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['female_menstruating']['Metagenics']['products'][$i] = $handleArr[$i];
            }
            $json['female_menstruating']['Metagenics']['bundle'] = $bundle[0];
            
            $query = DB::table('products')->where([['group_name', '=', 'i2_female_menstruating'], ['brand','=','Orthomolecular'], ['status','=',1]])->pluck('handle');
            $queryBundle = DB::table('products')->where([['group_name', '=', 'i2_female_menstruating'], ['brand','=','Orthomolecular'], ['status','=',1]])->pluck('bundle');
            $bundle = json_decode($queryBundle, true);
            $handleArr = json_decode($query, true);

            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['female_menstruating']['Orthomolecular']['products'][$i] = $handleArr[$i];
            }
            $json['female_menstruating']['Orthomolecular']['bundle'] = $bundle[0];
            
            $query = DB::table('products')->where([['group_name', '=', 'i2_female_menstruating'], ['brand','=','Designs For Health'], ['status','=',1]])->pluck('handle');
            $queryBundle = DB::table('products')->where([['group_name', '=', 'i2_female_menstruating'], ['brand','=','Designs For Health'], ['status','=',1]])->pluck('bundle');
            $bundle = json_decode($queryBundle, true);
            $handleArr = json_decode($query, true);

            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['female_menstruating']['Designs For Health']['products'][$i] = $handleArr[$i];
            }
            $json['female_menstruating']['Designs For Health']['bundle'] = $bundle[0];
            
            $query = DB::table('products')->where([['group_name', '=', 'i2_female_pregnant'], ['brand','=','Metagenics'], ['status','=',1]])->pluck('handle');
            $queryBundle = DB::table('products')->where([['group_name', '=', 'i2_female_pregnant'], ['brand','=','Metagenics'], ['status','=',1]])->pluck('bundle');
            $bundle = json_decode($queryBundle, true);
            $handleArr = json_decode($query, true);

            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['female_pregnant']['Metagenics']['products'][$i] = $handleArr[$i];
            }
            $json['female_pregnant']['Metagenics']['bundle'] = $bundle[0];
            
            $query = DB::table('products')->where([['group_name', '=', 'i2_female_pregnant'], ['brand','=','Orthomolecular'], ['status','=',1]])->pluck('handle');
            $queryBundle = DB::table('products')->where([['group_name', '=', 'i2_female_pregnant'], ['brand','=','Orthomolecular'], ['status','=',1]])->pluck('bundle');
            $bundle = json_decode($queryBundle, true);
            $handleArr = json_decode($query, true);

            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['female_pregnant']['Orthomolecular']['products'][$i] = $handleArr[$i];
            }
            $json['female_pregnant']['Orthomolecular']['bundle'] = $bundle[0];
            
            $query = DB::table('products')->where([['group_name', '=', 'i2_female_pregnant'], ['brand','=','Designs For Health'], ['status','=',1]])->pluck('handle');
            $queryBundle = DB::table('products')->where([['group_name', '=', 'i2_female_pregnant'], ['brand','=','Designs For Health'], ['status','=',1]])->pluck('bundle');
            $bundle = json_decode($queryBundle, true);
            $handleArr = json_decode($query, true);

            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['female_pregnant']['Designs For Health']['products'][$i] = $handleArr[$i];
            }
            $json['female_pregnant']['Designs For Health']['bundle'] = $bundle[0];
            
            $query = DB::table('products')->where([['group_name', '=', 'i2_male_45o'], ['brand','=','Metagenics'], ['status','=',1]])->pluck('handle');
            $queryBundle = DB::table('products')->where([['group_name', '=', 'i2_male_45o'], ['brand','=','Metagenics'], ['status','=',1]])->pluck('bundle');
            $bundle = json_decode($queryBundle, true);
            $handleArr = json_decode($query, true);

            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['male_45o']['Metagenics']['products'][$i] = $handleArr[$i];
            }
            $json['male_45o']['Metagenics']['bundle'] = $bundle[0];
            
            $query = DB::table('products')->where([['group_name', '=', 'i2_male_45o'], ['brand','=','Orthomolecular'], ['status','=',1]])->pluck('handle');
            $queryBundle = DB::table('products')->where([['group_name', '=', 'i2_male_45o'], ['brand','=','Orthomolecular'], ['status','=',1]])->pluck('bundle');
            $bundle = json_decode($queryBundle, true);
            $handleArr = json_decode($query, true);

            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['male_45o']['Orthomolecular']['products'][$i] = $handleArr[$i];
            }
            $json['male_45o']['Orthomolecular']['bundle'] = $bundle[0];
            
            $query = DB::table('products')->where([['group_name', '=', 'i2_male_45o'], ['brand','=','Designs For Health'], ['status','=',1]])->pluck('handle');
            $queryBundle = DB::table('products')->where([['group_name', '=', 'i2_male_45o'], ['brand','=','Designs For Health'], ['status','=',1]])->pluck('bundle');
            $bundle = json_decode($queryBundle, true);
            $handleArr = json_decode($query, true);

            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['male_45o']['Designs For Health']['products'][$i] = $handleArr[$i];
            }
            $json['male_45o']['Designs For Health']['bundle'] = $bundle[0];
            
            
            $query = DB::table('products')->where([['group_name', '=', 'i2_male_45u'], ['brand','=','Metagenics'], ['status','=',1]])->pluck('handle');
            $queryBundle = DB::table('products')->where([['group_name', '=', 'i2_male_45u'], ['brand','=','Metagenics'], ['status','=',1]])->pluck('bundle');
            $bundle = json_decode($queryBundle, true);
            $handleArr = json_decode($query, true);

            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['male_45u']['Metagenics']['products'][$i] = $handleArr[$i];
            }
            $json['male_45u']['Metagenics']['bundle'] = $bundle[0];
            
            $query = DB::table('products')->where([['group_name', '=', 'i2_male_45u'], ['brand','=','Orthomolecular'], ['status','=',1]])->pluck('handle');
            $queryBundle = DB::table('products')->where([['group_name', '=', 'i2_male_45u'], ['brand','=','Orthomolecular'], ['status','=',1]])->pluck('bundle');
            $bundle = json_decode($queryBundle, true);
            $handleArr = json_decode($query, true);

            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['male_45u']['Orthomolecular']['products'][$i] = $handleArr[$i];
            }
            $json['male_45u']['Orthomolecular']['bundle'] = $bundle[0];
            
            $query = DB::table('products')->where([['group_name', '=', 'i2_male_45u'], ['brand','=','Designs For Health'], ['status','=',1]])->pluck('handle');
            $queryBundle = DB::table('products')->where([['group_name', '=', 'i2_male_45u'], ['brand','=','Designs For Health'], ['status','=',1]])->pluck('bundle');
            $bundle = json_decode($queryBundle, true);
            $handleArr = json_decode($query, true);

            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['male_45u']['Designs For Health']['products'][$i] = $handleArr[$i];
            }
            $json['male_45u']['Designs For Health']['bundle'] = $bundle[0];
        }
        else if ($ix == "i3")
        {
            $query = DB::table('products')->where([['group_name', '=', 'i3_cardiometabolic'], ['brand','=','Designs For Health'], ['status','=',1]])->pluck('handle');
            $queryBundle = DB::table('products')->where([['group_name', '=', 'i3_cardiometabolic'], ['brand','=','Designs For Health'], ['status','=',1]])->pluck('bundle');
            $bundle = json_decode($queryBundle, true);
            $handleArr = json_decode($query, true);
            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['cardiometabolic']['Designs For Health']['products'][$i] = $handleArr[$i];
            }
            $json['cardiometabolic']['Designs For Health']['bundle'] = $bundle[0];

            $query = DB::table('products')->where([['group_name', '=', 'i3_cardiometabolic'], ['brand','=','Orthomolecular'], ['status','=',1]])->pluck('handle');
            $queryBundle = DB::table('products')->where([['group_name', '=', 'i3_cardiometabolic'], ['brand','=','Orthomolecular'], ['status','=',1]])->pluck('bundle');
            $bundle = json_decode($queryBundle, true);
            $handleArr = json_decode($query, true);
            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['cardiometabolic']['Orthomolecular']['products'][$i] = $handleArr[$i];
            }
            $json['cardiometabolic']['Orthomolecular']['bundle'] = $bundle[0];
            
            $query = DB::table('products')->where([['group_name', '=', 'i3_cardiometabolic'], ['brand','=','Metagenics'], ['status','=',1]])->pluck('handle');
            $queryBundle = DB::table('products')->where([['group_name', '=', 'i3_cardiometabolic'], ['brand','=','Metagenics'], ['status','=',1]])->pluck('bundle');
            $bundle = json_decode($queryBundle, true);
            $handleArr = json_decode($query, true);
            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['cardiometabolic']['Metagenics']['products'][$i] = $handleArr[$i];
            }
            $json['cardiometabolic']['Metagenics']['bundle'] = $bundle[0];

            
            $query = DB::table('products')->where([['group_name', '=', 'i3_immune'], ['brand','=','Designs For Health'], ['status','=',1]])->pluck('handle');
            $queryBundle = DB::table('products')->where([['group_name', '=', 'i3_cardiometabolic'], ['brand','=','Designs For Health'], ['status','=',1]])->pluck('bundle');
            $bundle = json_decode($queryBundle, true);
            $handleArr = json_decode($query, true);
            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['immune']['Designs For Health']['products'][$i] = $handleArr[$i];
            }
            $json['immune']['Designs For Health']['bundle'] = $bundle[0];

            $query = DB::table('products')->where([['group_name', '=', 'i3_immune'], ['brand','=','Orthomolecular'], ['status','=',1]])->pluck('handle');
            $queryBundle = DB::table('products')->where([['group_name', '=', 'i3_cardiometabolic'], ['brand','=','Orthomolecular'], ['status','=',1]])->pluck('bundle');
            $bundle = json_decode($queryBundle, true);
            $handleArr = json_decode($query, true);
            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['immune']['Orthomolecular']['products'][$i] = $handleArr[$i];
            }
            $json['immune']['Orthomolecular']['bundle'] = $bundle[0];
            
            $query = DB::table('products')->where([['group_name', '=', 'i3_immune'], ['brand','=','Metagenics'], ['status','=',1]])->pluck('handle');
            $queryBundle = DB::table('products')->where([['group_name', '=', 'i3_cardiometabolic'], ['brand','=','Metagenics'], ['status','=',1]])->pluck('bundle');
            $bundle = json_decode($queryBundle, true);
            $handleArr = json_decode($query, true);
            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['immune']['Metagenics']['products'][$i] = $handleArr[$i];
            }
            $json['immune']['Metagenics']['bundle'] = $bundle[0];

            
            $query = DB::table('products')->where([['group_name', '=', 'i3_cognition'], ['brand','=','Designs For Health'], ['status','=',1]])->pluck('handle');
            $queryBundle = DB::table('products')->where([['group_name', '=', 'i3_cardiometabolic'], ['brand','=','Designs For Health'], ['status','=',1]])->pluck('bundle');
            $bundle = json_decode($queryBundle, true);
            $handleArr = json_decode($query, true);
            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['cognition']['Designs For Health']['products'][$i] = $handleArr[$i];
            }
            $json['cognition']['Designs For Health']['bundle'] = $bundle[0];

            $query = DB::table('products')->where([['group_name', '=', 'i3_cognition'], ['brand','=','Orthomolecular'], ['status','=',1]])->pluck('handle');
            $queryBundle = DB::table('products')->where([['group_name', '=', 'i3_cardiometabolic'], ['brand','=','Orthomolecular'], ['status','=',1]])->pluck('bundle');
            $bundle = json_decode($queryBundle, true);
            $handleArr = json_decode($query, true);
            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['cognition']['Orthomolecular']['products'][$i] = $handleArr[$i];
            }
            $json['cognition']['Orthomolecular']['bundle'] = $bundle[0];
            
            $query = DB::table('products')->where([['group_name', '=', 'i3_cognition'], ['brand','=','Metagenics'], ['status','=',1]])->pluck('handle');
            $queryBundle = DB::table('products')->where([['group_name', '=', 'i3_cardiometabolic'], ['brand','=','Metagenics'], ['status','=',1]])->pluck('bundle');
            $bundle = json_decode($queryBundle, true);
            $handleArr = json_decode($query, true);
            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['cognition']['Metagenics']['products'][$i] = $handleArr[$i];
            }
            $json['cognition']['Metagenics']['bundle'] = $bundle[0];

            
            $query = DB::table('products')->where([['group_name', '=', 'i3_musculoskeletal'], ['brand','=','Designs For Health'], ['status','=',1]])->pluck('handle');
            $queryBundle = DB::table('products')->where([['group_name', '=', 'i3_cardiometabolic'], ['brand','=','Designs For Health'], ['status','=',1]])->pluck('bundle');
            $bundle = json_decode($queryBundle, true);
            $handleArr = json_decode($query, true);
            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['musculoskeletal']['Designs For Health']['products'][$i] = $handleArr[$i];
            }
            $json['musculoskeletal']['Designs For Health']['bundle'] = $bundle[0];

            $query = DB::table('products')->where([['group_name', '=', 'i3_musculoskeletal'], ['brand','=','Orthomolecular'], ['status','=',1]])->pluck('handle');
            $queryBundle = DB::table('products')->where([['group_name', '=', 'i3_cardiometabolic'], ['brand','=','Orthomolecular'], ['status','=',1]])->pluck('bundle');
            $bundle = json_decode($queryBundle, true);
            $handleArr = json_decode($query, true);
            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['musculoskeletal']['Orthomolecular']['products'][$i] = $handleArr[$i];
            }
            $json['musculoskeletal']['Orthomolecular']['bundle'] = $bundle[0];
            
            $query = DB::table('products')->where([['group_name', '=', 'i3_musculoskeletal'], ['brand','=','Metagenics'], ['status','=',1]])->pluck('handle');
            $queryBundle = DB::table('products')->where([['group_name', '=', 'i3_cardiometabolic'], ['brand','=','Metagenics'], ['status','=',1]])->pluck('bundle');
            $bundle = json_decode($queryBundle, true);
            $handleArr = json_decode($query, true);
            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['musculoskeletal']['Metagenics']['products'][$i] = $handleArr[$i];
            }
            $json['musculoskeletal']['Metagenics']['bundle'] = $bundle[0];

            
            $query = DB::table('products')->where([['group_name', '=', 'i3_energy'], ['brand','=','Designs For Health'], ['status','=',1]])->pluck('handle');
            $queryBundle = DB::table('products')->where([['group_name', '=', 'i3_cardiometabolic'], ['brand','=','Designs For Health'], ['status','=',1]])->pluck('bundle');
            $bundle = json_decode($queryBundle, true);
            $handleArr = json_decode($query, true);
            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['energy']['Designs For Health']['products'][$i] = $handleArr[$i];
            }
            $json['energy']['Designs For Health']['bundle'] = $bundle[0];

            $query = DB::table('products')->where([['group_name', '=', 'i3_energy'], ['brand','=','Orthomolecular'], ['status','=',1]])->pluck('handle');
            $queryBundle = DB::table('products')->where([['group_name', '=', 'i3_cardiometabolic'], ['brand','=','Orthomolecular'], ['status','=',1]])->pluck('bundle');
            $bundle = json_decode($queryBundle, true);
            $handleArr = json_decode($query, true);
            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['energy']['Orthomolecular']['products'][$i] = $handleArr[$i];
            }
            $json['energy']['Orthomolecular']['bundle'] = $bundle[0];
            
            $query = DB::table('products')->where([['group_name', '=', 'i3_energy'], ['brand','=','Metagenics'], ['status','=',1]])->pluck('handle');
            $queryBundle = DB::table('products')->where([['group_name', '=', 'i3_cardiometabolic'], ['brand','=','Metagenics'], ['status','=',1]])->pluck('bundle');
            $bundle = json_decode($queryBundle, true);
            $handleArr = json_decode($query, true);
            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['energy']['Metagenics']['products'][$i] = $handleArr[$i];
            }
            $json['energy']['Metagenics']['bundle'] = $bundle[0];

            
            $query = DB::table('products')->where([['group_name', '=', 'i3_gastrointestinal'], ['brand','=','Designs For Health'], ['status','=',1]])->pluck('handle');
            $queryBundle = DB::table('products')->where([['group_name', '=', 'i3_cardiometabolic'], ['brand','=','Designs For Health'], ['status','=',1]])->pluck('bundle');
            $bundle = json_decode($queryBundle, true);
            $handleArr = json_decode($query, true);
            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['gastrointestinal']['Designs For Health']['products'][$i] = $handleArr[$i];
            }
            $json['gastrointestinal']['Designs For Health']['bundle'] = $bundle[0];

            $query = DB::table('products')->where([['group_name', '=', 'i3_gastrointestinal'], ['brand','=','Orthomolecular'], ['status','=',1]])->pluck('handle');
            $queryBundle = DB::table('products')->where([['group_name', '=', 'i3_cardiometabolic'], ['brand','=','Orthomolecular'], ['status','=',1]])->pluck('bundle');
            $bundle = json_decode($queryBundle, true);
            $handleArr = json_decode($query, true);
            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['gastrointestinal']['Orthomolecular']['products'][$i] = $handleArr[$i];
            }
            $json['gastrointestinal']['Orthomolecular']['bundle'] = $bundle[0];
            
            $query = DB::table('products')->where([['group_name', '=', 'i3_gastrointestinal'], ['brand','=','Metagenics'], ['status','=',1]])->pluck('handle');
            $queryBundle = DB::table('products')->where([['group_name', '=', 'i3_cardiometabolic'], ['brand','=','Metagenics'], ['status','=',1]])->pluck('bundle');
            $bundle = json_decode($queryBundle, true);
            $handleArr = json_decode($query, true);
            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['gastrointestinal']['Metagenics']['products'][$i] = $handleArr[$i];
            }
            $json['gastrointestinal']['Metagenics']['bundle'] = $bundle[0];

            
            $query = DB::table('products')->where([['group_name', '=', 'i3_hormone'], ['brand','=','Designs For Health'], ['status','=',1]])->pluck('handle');
            $queryBundle = DB::table('products')->where([['group_name', '=', 'i3_cardiometabolic'], ['brand','=','Designs For Health'], ['status','=',1]])->pluck('bundle');
            $bundle = json_decode($queryBundle, true);
            $handleArr = json_decode($query, true);
            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['hormone']['Designs For Health']['products'][$i] = $handleArr[$i];
            }
            $json['hormone']['Designs For Health']['bundle'] = $bundle[0];

            $query = DB::table('products')->where([['group_name', '=', 'i3_hormone'], ['brand','=','Orthomolecular'], ['status','=',1]])->pluck('handle');
            $queryBundle = DB::table('products')->where([['group_name', '=', 'i3_cardiometabolic'], ['brand','=','Orthomolecular'], ['status','=',1]])->pluck('bundle');
            $bundle = json_decode($queryBundle, true);
            $handleArr = json_decode($query, true);
            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['hormone']['Orthomolecular']['products'][$i] = $handleArr[$i];
            }
            $json['hormone']['Orthomolecular']['bundle'] = $bundle[0];
            
            $query = DB::table('products')->where([['group_name', '=', 'i3_hormone'], ['brand','=','Metagenics'], ['status','=',1]])->pluck('handle');
            $queryBundle = DB::table('products')->where([['group_name', '=', 'i3_cardiometabolic'], ['brand','=','Metagenics'], ['status','=',1]])->pluck('bundle');
            $bundle = json_decode($queryBundle, true);
            $handleArr = json_decode($query, true);
            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['hormone']['Metagenics']['products'][$i] = $handleArr[$i];
            }
            $json['hormone']['Metagenics']['bundle'] = $bundle[0];

            
            $query = DB::table('products')->where([['group_name', '=', 'i3_stress'], ['brand','=','Designs For Health'], ['status','=',1]])->pluck('handle');
            $queryBundle = DB::table('products')->where([['group_name', '=', 'i3_cardiometabolic'], ['brand','=','Designs For Health'], ['status','=',1]])->pluck('bundle');
            $bundle = json_decode($queryBundle, true);
            $handleArr = json_decode($query, true);
            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['stress']['Designs For Health']['products'][$i] = $handleArr[$i];
            }
            $json['stress']['Designs For Health']['bundle'] = $bundle[0];

            $query = DB::table('products')->where([['group_name', '=', 'i3_stress'], ['brand','=','Orthomolecular'], ['status','=',1]])->pluck('handle');
            $queryBundle = DB::table('products')->where([['group_name', '=', 'i3_cardiometabolic'], ['brand','=','Orthomolecular'], ['status','=',1]])->pluck('bundle');
            $bundle = json_decode($queryBundle, true);
            $handleArr = json_decode($query, true);
            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['stress']['Orthomolecular']['products'][$i] = $handleArr[$i];
            }
            $json['stress']['Orthomolecular']['bundle'] = $bundle[0];
            
            $query = DB::table('products')->where([['group_name', '=', 'i3_stress'], ['brand','=','Metagenics'], ['status','=',1]])->pluck('handle');
            $queryBundle = DB::table('products')->where([['group_name', '=', 'i3_cardiometabolic'], ['brand','=','Metagenics'], ['status','=',1]])->pluck('bundle');
            $bundle = json_decode($queryBundle, true);
            $handleArr = json_decode($query, true);
            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['stress']['Metagenics']['products'][$i] = $handleArr[$i];
            }
            $json['stress']['Metagenics']['bundle'] = $bundle[0];

            
            $query = DB::table('products')->where([['group_name', '=', 'i3_toxicity'], ['brand','=','Designs For Health'], ['status','=',1]])->pluck('handle');
            $queryBundle = DB::table('products')->where([['group_name', '=', 'i3_cardiometabolic'], ['brand','=','Designs For Health'], ['status','=',1]])->pluck('bundle');
            $bundle = json_decode($queryBundle, true);
            $handleArr = json_decode($query, true);
            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['toxicity']['Designs For Health']['products'][$i] = $handleArr[$i];
            }
            $json['toxicity']['Designs For Health']['bundle'] = $bundle[0];

            $query = DB::table('products')->where([['group_name', '=', 'i3_toxicity'], ['brand','=','Orthomolecular'], ['status','=',1]])->pluck('handle');
            $queryBundle = DB::table('products')->where([['group_name', '=', 'i3_cardiometabolic'], ['brand','=','Orthomolecular'], ['status','=',1]])->pluck('bundle');
            $bundle = json_decode($queryBundle, true);
            $handleArr = json_decode($query, true);
            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['toxicity']['Orthomolecular']['products'][$i] = $handleArr[$i];
            }
            $json['toxicity']['Orthomolecular']['bundle'] = $bundle[0];
            
            $query = DB::table('products')->where([['group_name', '=', 'i3_toxicity'], ['brand','=','Metagenics'], ['status','=',1]])->pluck('handle');
            $queryBundle = DB::table('products')->where([['group_name', '=', 'i3_cardiometabolic'], ['brand','=','Metagenics'], ['status','=',1]])->pluck('bundle');
            $bundle = json_decode($queryBundle, true);
            $handleArr = json_decode($query, true);
            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['toxicity']['Metagenics']['products'][$i] = $handleArr[$i];
            }
            $json['toxicity']['Metagenics']['bundle'] = $bundle[0];

            
            $query = DB::table('products')->where([['group_name', '=', 'i3_circulation'], ['brand','=','Designs For Health'], ['status','=',1]])->pluck('handle');
            $queryBundle = DB::table('products')->where([['group_name', '=', 'i3_cardiometabolic'], ['brand','=','Designs For Health'], ['status','=',1]])->pluck('bundle');
            $bundle = json_decode($queryBundle, true);
            $handleArr = json_decode($query, true);
            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['circulation']['Designs For Health']['products'][$i] = $handleArr[$i];
            }
            $json['circulation']['Designs For Health']['bundle'] = $bundle[0];

            $query = DB::table('products')->where([['group_name', '=', 'i3_circulation'], ['brand','=','Orthomolecular'], ['status','=',1]])->pluck('handle');
            $queryBundle = DB::table('products')->where([['group_name', '=', 'i3_cardiometabolic'], ['brand','=','Orthomolecular'], ['status','=',1]])->pluck('bundle');
            $bundle = json_decode($queryBundle, true);
            $handleArr = json_decode($query, true);
            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['circulation']['Orthomolecular']['products'][$i] = $handleArr[$i];
            }
            $json['circulation']['Orthomolecular']['bundle'] = $bundle[0];
            
            $query = DB::table('products')->where([['group_name', '=', 'i3_circulation'], ['brand','=','Metagenics'], ['status','=',1]])->pluck('handle');
            $queryBundle = DB::table('products')->where([['group_name', '=', 'i3_cardiometabolic'], ['brand','=','Metagenics'], ['status','=',1]])->pluck('bundle');
            $bundle = json_decode($queryBundle, true);
            $handleArr = json_decode($query, true);
            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['circulation']['Metagenics']['products'][$i] = $handleArr[$i];
            }
            $json['circulation']['Metagenics']['bundle'] = $bundle[0];
        }

        return response()->json($json, 200);
    }

    public function getBundlePack($bHandle)
    {
        $r = DB::table('products')->where('bundle','=',$bHandle)->pluck('handle');

        return response()->json($r, 200);
    }
}
