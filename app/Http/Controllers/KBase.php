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
    "Designs for Health": {"title": "", "description": "", "price": "0.00", "discountedPrice": "0.00", "products": ["handle1", "handle2"]}
  },
  "female_40u" {
    "Metagenics": ["handle1", "handle2"],
    "Orthomolecular": ["handle1", "handle2"],
    "Designs for Health": ["handle1", "handle2"]
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
            $query = DB::table('products')->where('group_name', '=', 'i1_nutritional_wellness')->pluck('handle');
            $handleArr = json_decode($query, true);
            $json['nutritional_wellness']['title'] = 'Nutritional Wellness Bundle';
            $json['nutritional_wellness']['description'] = 'This is the Nutritional Wellness Bundle';
            $json['nutritional_wellness']['price'] = 499;
            $json['nutritional_wellness']['discountedPrice'] = 399;

            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['nutritional_wellness']['products'][$i] = $handleArr[$i];
            }

            $query = DB::table('products')->where('group_name', '=', 'i1_environmental_wellness')->pluck('handle');
            $handleArr = json_decode($query, true);
            $json['environmental_wellness']['title'] = 'Environmental Wellness Bundle';
            $json['environmental_wellness']['description'] = 'This is the Environmental Wellness Bundle';
            $json['environmental_wellness']['price'] = 499;
            $json['environmental_wellness']['discountedPrice'] = 399;

            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['environmental_wellness']['products'][$i] = $handleArr[$i];
            }

            $query = DB::table('products')->where('group_name', '=', 'i1_physical_wellness')->pluck('handle');
            $handleArr = json_decode($query, true);
            $json['physical_wellness']['title'] = 'Environmental Wellness Bundle';
            $json['physical_wellness']['description'] = 'This is the Environmental Wellness Bundle';
            $json['physical_wellness']['price'] = 499;
            $json['physical_wellness']['discountedPrice'] = 399;

            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['physical_wellness']['products'][$i] = $handleArr[$i];
            }

            $query = DB::table('products')->where('group_name', '=', 'i1_emotional_wellness')->pluck('handle');
            $handleArr = json_decode($query, true);
            $json['emotional_wellness']['title'] = 'Environmental Wellness Bundle';
            $json['emotional_wellness']['description'] = 'This is the Environmental Wellness Bundle';
            $json['emotional_wellness']['price'] = 499;
            $json['emotional_wellness']['discountedPrice'] = 399;

            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['emotional_wellness']['products'][$i] = $handleArr[$i];
            }
        }
        else if ($ix = "i2")
        {
            $json = [];
            
            $query = DB::table('products')->where([['group_name', '=', 'i2_female_breastfeeding'], ['brand','=','Metagenics']])->pluck('handle');
            $handleArr = json_decode($query, true);
            $json['female_breastfeeding']['Metagenics']['title'] = 'Female Breastfeeding Bundle - Metagenics';
            $json['female_breastfeeding']['Metagenics']['description'] = 'This is the Female Breastfeeding Bundle - Metagenics';
            $json['female_breastfeeding']['Metagenics']['price'] = 499;
            $json['female_breastfeeding']['Metagenics']['discountedPrice'] = 399;

            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['female_breastfeeding']['Metagenics']['products'][$i] = $handleArr[$i];
            }
            
            $query = DB::table('products')->where([['group_name', '=', 'i2_female_breastfeeding'], ['brand','=','Orthomolecular']])->pluck('handle');
            $handleArr = json_decode($query, true);
            $json['female_breastfeeding']['Orthomolecular']['title'] = 'Female Breastfeeding Bundle - Orthomolecular';
            $json['female_breastfeeding']['Orthomolecular']['description'] = 'This is the Female Breastfeeding Bundle - Orthomolecular';
            $json['female_breastfeeding']['Orthomolecular']['price'] = 499;
            $json['female_breastfeeding']['Orthomolecular']['discountedPrice'] = 399;

            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['female_breastfeeding']['Orthomolecular']['products'][$i] = $handleArr[$i];
            }
            
            $query = DB::table('products')->where([['group_name', '=', 'i2_female_breastfeeding'], ['brand','=','Designs for Health']])->pluck('handle');
            $handleArr = json_decode($query, true);
            $json['female_breastfeeding']['Designs for Health']['title'] = 'Female Breastfeeding Bundle - Orthomolecular';
            $json['female_breastfeeding']['Designs for Health']['description'] = 'This is the Female Breastfeeding Bundle - Orthomolecular';
            $json['female_breastfeeding']['Designs for Health']['price'] = 499;
            $json['female_breastfeeding']['Designs for Health']['discountedPrice'] = 399;

            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['female_breastfeeding']['Designs for Health']['products'][$i] = $handleArr[$i];
            }
            
            $query = DB::table('products')->where([['group_name', '=', 'i2_female_menopause'], ['brand','=','Metagenics']])->pluck('handle');
            $handleArr = json_decode($query, true);
            $json['female_menopause']['Metagenics']['title'] = 'Female Menopause Bundle - Metagenics';
            $json['female_menopause']['Metagenics']['description'] = 'This is the Female Menopause Bundle - Metagenics';
            $json['female_menopause']['Metagenics']['price'] = 499;
            $json['female_menopause']['Metagenics']['discountedPrice'] = 399;

            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['female_menopause']['Metagenics']['products'][$i] = $handleArr[$i];
            }
            
            $query = DB::table('products')->where([['group_name', '=', 'i2_female_menopause'], ['brand','=','Orthomolecular']])->pluck('handle');
            $handleArr = json_decode($query, true);
            $json['female_menopause']['Orthomolecular']['title'] = 'Female Menopause Bundle - Orthomolecular';
            $json['female_menopause']['Orthomolecular']['description'] = 'This is the Female Menopause Bundle - Orthomolecular';
            $json['female_menopause']['Orthomolecular']['price'] = 499;
            $json['female_menopause']['Orthomolecular']['discountedPrice'] = 399;

            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['female_menopause']['Orthomolecular']['products'][$i] = $handleArr[$i];
            }
            
            $query = DB::table('products')->where([['group_name', '=', 'i2_female_menopause'], ['brand','=','Designs for Health']])->pluck('handle');
            $handleArr = json_decode($query, true);
            $json['female_menopause']['Designs for Health']['title'] = 'Female Menopause Bundle - Designs for Health';
            $json['female_menopause']['Designs for Health']['description'] = 'This is the Female Menopause Bundle - Designs for Health';
            $json['female_menopause']['Designs for Health']['price'] = 499;
            $json['female_menopause']['Designs for Health']['discountedPrice'] = 399;

            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['female_menopause']['Designs for Health']['products'][$i] = $handleArr[$i];
            }
            
            $query = DB::table('products')->where([['group_name', '=', 'i2_female_menstruating'], ['brand','=','Metagenics']])->pluck('handle');
            $handleArr = json_decode($query, true);
            $json['female_menstruating']['Metagenics']['title'] = 'Female Menstruating Bundle - Metagenics';
            $json['female_menstruating']['Metagenics']['description'] = 'This is the Female Menstruating Bundle - Metagenics';
            $json['female_menstruating']['Metagenics']['price'] = 499;
            $json['female_menstruating']['Metagenics']['discountedPrice'] = 399;

            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['female_menstruating']['Metagenics']['products'][$i] = $handleArr[$i];
            }
            
            $query = DB::table('products')->where([['group_name', '=', 'i2_female_menstruating'], ['brand','=','Orthomolecular']])->pluck('handle');
            $handleArr = json_decode($query, true);
            $json['female_menstruating']['Orthomolecular']['title'] = 'Female Menstruating Bundle - Orthomolecular';
            $json['female_menstruating']['Orthomolecular']['description'] = 'This is the Female Menstruating Bundle - Orthomolecular';
            $json['female_menstruating']['Orthomolecular']['price'] = 499;
            $json['female_menstruating']['Orthomolecular']['discountedPrice'] = 399;

            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['female_menstruating']['Orthomolecular']['products'][$i] = $handleArr[$i];
            }
            
            $query = DB::table('products')->where([['group_name', '=', 'i2_female_menstruating'], ['brand','=','Designs for Health']])->pluck('handle');
            $handleArr = json_decode($query, true);
            $json['female_menstruating']['Designs for Health']['title'] = 'Female Menstruating Bundle - Designs for Health';
            $json['female_menstruating']['Designs for Health']['description'] = 'This is the Female Menstruating Bundle - Designs for Health';
            $json['female_menstruating']['Designs for Health']['price'] = 499;
            $json['female_menstruating']['Designs for Health']['discountedPrice'] = 399;

            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['female_menstruating']['Designs for Health']['products'][$i] = $handleArr[$i];
            }
            
            $query = DB::table('products')->where([['group_name', '=', 'i2_female_pregnant'], ['brand','=','Metagenics']])->pluck('handle');
            $handleArr = json_decode($query, true);
            $json['female_pregnant']['Metagenics']['title'] = 'Female Pregnant Bundle - Metagenics';
            $json['female_pregnant']['Metagenics']['description'] = 'This is the Female Pregnant Bundle - Metagenics';
            $json['female_pregnant']['Metagenics']['price'] = 499;
            $json['female_pregnant']['Metagenics']['discountedPrice'] = 399;

            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['female_pregnant']['Metagenics']['products'][$i] = $handleArr[$i];
            }
            
            $query = DB::table('products')->where([['group_name', '=', 'i2_female_pregnant'], ['brand','=','Orthomolecular']])->pluck('handle');
            $handleArr = json_decode($query, true);
            $json['female_pregnant']['Orthomolecular']['title'] = 'Female Pregnant Bundle - Orthomolecular';
            $json['female_pregnant']['Orthomolecular']['description'] = 'This is the Female Pregnant Bundle - Orthomolecular';
            $json['female_pregnant']['Orthomolecular']['price'] = 499;
            $json['female_pregnant']['Orthomolecular']['discountedPrice'] = 399;

            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['female_pregnant']['Orthomolecular']['products'][$i] = $handleArr[$i];
            }
            
            $query = DB::table('products')->where([['group_name', '=', 'i2_female_pregnant'], ['brand','=','Designs for Health']])->pluck('handle');
            $handleArr = json_decode($query, true);
            $json['female_pregnant']['Designs for Health']['title'] = 'Female Pregnant Bundle - Designs for Health';
            $json['female_pregnant']['Designs for Health']['description'] = 'This is the Female Pregnant Bundle - Designs for Health';
            $json['female_pregnant']['Designs for Health']['price'] = 499;
            $json['female_pregnant']['Designs for Health']['discountedPrice'] = 399;

            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['female_pregnant']['Designs for Health']['products'][$i] = $handleArr[$i];
            }
            
            $query = DB::table('products')->where([['group_name', '=', 'i2_male_45o'], ['brand','=','Metagenics']])->pluck('handle');
            $handleArr = json_decode($query, true);
            $json['male_45o']['Metagenics']['title'] = 'Male Over 45 Bundle - Metagenics';
            $json['male_45o']['Metagenics']['description'] = 'This is the Male Over 45 Bundle - Metagenics';
            $json['male_45o']['Metagenics']['price'] = 499;
            $json['male_45o']['Metagenics']['discountedPrice'] = 399;

            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['male_45o']['Metagenics']['products'][$i] = $handleArr[$i];
            }
            
            $query = DB::table('products')->where([['group_name', '=', 'i2_male_45o'], ['brand','=','Orthomolecular']])->pluck('handle');
            $handleArr = json_decode($query, true);
            $json['male_45o']['Orthomolecular']['title'] = 'Male Over 45 Bundle - Orthomolecular';
            $json['male_45o']['Orthomolecular']['description'] = 'This is the Male Over 45 Bundle - Orthomolecular';
            $json['male_45o']['Orthomolecular']['price'] = 499;
            $json['male_45o']['Orthomolecular']['discountedPrice'] = 399;

            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['male_45o']['Orthomolecular']['products'][$i] = $handleArr[$i];
            }
            
            $query = DB::table('products')->where([['group_name', '=', 'i2_male_45o'], ['brand','=','Designs for Health']])->pluck('handle');
            $handleArr = json_decode($query, true);
            $json['male_45o']['Designs for Health']['title'] = 'Male Over 45 Bundle - Designs for Health';
            $json['male_45o']['Designs for Health']['description'] = 'This is the Male Over 45 Bundle - Designs for Health';
            $json['male_45o']['Designs for Health']['price'] = 499;
            $json['male_45o']['Designs for Health']['discountedPrice'] = 399;

            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['male_45o']['Designs for Health']['products'][$i] = $handleArr[$i];
            }
            
            
            $query = DB::table('products')->where([['group_name', '=', 'i2_male_45u'], ['brand','=','Metagenics']])->pluck('handle');
            $handleArr = json_decode($query, true);
            $json['male_45u']['Metagenics']['title'] = 'Male Over 45 Bundle - Metagenics';
            $json['male_45u']['Metagenics']['description'] = 'This is the Male Over 45 Bundle - Metagenics';
            $json['male_45u']['Metagenics']['price'] = 499;
            $json['male_45u']['Metagenics']['discountedPrice'] = 399;

            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['male_45u']['Metagenics']['products'][$i] = $handleArr[$i];
            }
            
            $query = DB::table('products')->where([['group_name', '=', 'i2_male_45u'], ['brand','=','Orthomolecular']])->pluck('handle');
            $handleArr = json_decode($query, true);
            $json['male_45u']['Orthomolecular']['title'] = 'Male Over 45 Bundle - Orthomolecular';
            $json['male_45u']['Orthomolecular']['description'] = 'This is the Male Over 45 Bundle - Orthomolecular';
            $json['male_45u']['Orthomolecular']['price'] = 499;
            $json['male_45u']['Orthomolecular']['discountedPrice'] = 399;

            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['male_45u']['Orthomolecular']['products'][$i] = $handleArr[$i];
            }
            
            $query = DB::table('products')->where([['group_name', '=', 'i2_male_45u'], ['brand','=','Designs for Health']])->pluck('handle');
            $handleArr = json_decode($query, true);
            $json['male_45u']['Designs for Health']['title'] = 'Male Over 45 Bundle - Designs for Health';
            $json['male_45u']['Designs for Health']['description'] = 'This is the Male Over 45 Bundle - Designs for Health';
            $json['male_45u']['Designs for Health']['price'] = 499;
            $json['male_45u']['Designs for Health']['discountedPrice'] = 399;

            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['male_45u']['Designs for Health']['products'][$i] = $handleArr[$i];
            }
        }
        else if ($ix == "i3")
        {
            $query = DB::table('products')->where('group_name', '=', 'i3_cardiometabolic')->pluck('handle');
        }

        return response()->json($json, 200);
    }
}
