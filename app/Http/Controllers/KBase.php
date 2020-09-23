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
            // $json['nutritional_wellness']['title'] = 'Nutritional Wellness Bundle';
            // $json['nutritional_wellness']['description'] = 'This is the Nutritional Wellness Bundle';
            // $json['nutritional_wellness']['price'] = 499;
            // $json['nutritional_wellness']['discountedPrice'] = 399;

            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['nutritional_wellness']['products'][$i] = $handleArr[$i];
            }

            $query = DB::table('products')->where('group_name', '=', 'i1_environmental_wellness')->pluck('handle');
            $handleArr = json_decode($query, true);

            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['environmental_wellness']['products'][$i] = $handleArr[$i];
            }

            $query = DB::table('products')->where('group_name', '=', 'i1_physical_wellness')->pluck('handle');
            $handleArr = json_decode($query, true);

            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['physical_wellness']['products'][$i] = $handleArr[$i];
            }

            $query = DB::table('products')->where('group_name', '=', 'i1_emotional_wellness')->pluck('handle');
            $handleArr = json_decode($query, true);

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

            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['female_breastfeeding']['Metagenics']['products'][$i] = $handleArr[$i];
            }
            
            $query = DB::table('products')->where([['group_name', '=', 'i2_female_breastfeeding'], ['brand','=','Orthomolecular']])->pluck('handle');
            $handleArr = json_decode($query, true);

            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['female_breastfeeding']['Orthomolecular']['products'][$i] = $handleArr[$i];
            }
            
            $query = DB::table('products')->where([['group_name', '=', 'i2_female_breastfeeding'], ['brand','=','Designs for Health']])->pluck('handle');
            $handleArr = json_decode($query, true);

            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['female_breastfeeding']['Designs for Health']['products'][$i] = $handleArr[$i];
            }
            
            $query = DB::table('products')->where([['group_name', '=', 'i2_female_menopause'], ['brand','=','Metagenics']])->pluck('handle');
            $handleArr = json_decode($query, true);

            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['female_menopause']['Metagenics']['products'][$i] = $handleArr[$i];
            }
            
            $query = DB::table('products')->where([['group_name', '=', 'i2_female_menopause'], ['brand','=','Orthomolecular']])->pluck('handle');
            $handleArr = json_decode($query, true);

            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['female_menopause']['Orthomolecular']['products'][$i] = $handleArr[$i];
            }
            
            $query = DB::table('products')->where([['group_name', '=', 'i2_female_menopause'], ['brand','=','Designs for Health']])->pluck('handle');
            $handleArr = json_decode($query, true);

            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['female_menopause']['Designs for Health']['products'][$i] = $handleArr[$i];
            }
            
            $query = DB::table('products')->where([['group_name', '=', 'i2_female_menstruating'], ['brand','=','Metagenics']])->pluck('handle');
            $handleArr = json_decode($query, true);

            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['female_menstruating']['Metagenics']['products'][$i] = $handleArr[$i];
            }
            
            $query = DB::table('products')->where([['group_name', '=', 'i2_female_menstruating'], ['brand','=','Orthomolecular']])->pluck('handle');
            $handleArr = json_decode($query, true);

            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['female_menstruating']['Orthomolecular']['products'][$i] = $handleArr[$i];
            }
            
            $query = DB::table('products')->where([['group_name', '=', 'i2_female_menstruating'], ['brand','=','Designs for Health']])->pluck('handle');
            $handleArr = json_decode($query, true);

            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['female_menstruating']['Designs for Health']['products'][$i] = $handleArr[$i];
            }
            
            $query = DB::table('products')->where([['group_name', '=', 'i2_female_pregnant'], ['brand','=','Metagenics']])->pluck('handle');
            $handleArr = json_decode($query, true);

            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['female_pregnant']['Metagenics']['products'][$i] = $handleArr[$i];
            }
            
            $query = DB::table('products')->where([['group_name', '=', 'i2_female_pregnant'], ['brand','=','Orthomolecular']])->pluck('handle');
            $handleArr = json_decode($query, true);

            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['female_pregnant']['Orthomolecular']['products'][$i] = $handleArr[$i];
            }
            
            $query = DB::table('products')->where([['group_name', '=', 'i2_female_pregnant'], ['brand','=','Designs for Health']])->pluck('handle');
            $handleArr = json_decode($query, true);

            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['female_pregnant']['Designs for Health']['products'][$i] = $handleArr[$i];
            }
            
            $query = DB::table('products')->where([['group_name', '=', 'i2_male_45o'], ['brand','=','Metagenics']])->pluck('handle');
            $handleArr = json_decode($query, true);

            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['male_45o']['Metagenics']['products'][$i] = $handleArr[$i];
            }
            
            $query = DB::table('products')->where([['group_name', '=', 'i2_male_45o'], ['brand','=','Orthomolecular']])->pluck('handle');
            $handleArr = json_decode($query, true);

            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['male_45o']['Orthomolecular']['products'][$i] = $handleArr[$i];
            }
            
            $query = DB::table('products')->where([['group_name', '=', 'i2_male_45o'], ['brand','=','Designs for Health']])->pluck('handle');
            $handleArr = json_decode($query, true);

            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['male_45o']['Designs for Health']['products'][$i] = $handleArr[$i];
            }
            
            
            $query = DB::table('products')->where([['group_name', '=', 'i2_male_45u'], ['brand','=','Metagenics']])->pluck('handle');
            $handleArr = json_decode($query, true);

            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['male_45u']['Metagenics']['products'][$i] = $handleArr[$i];
            }
            
            $query = DB::table('products')->where([['group_name', '=', 'i2_male_45u'], ['brand','=','Orthomolecular']])->pluck('handle');
            $handleArr = json_decode($query, true);

            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['male_45u']['Orthomolecular']['products'][$i] = $handleArr[$i];
            }
            
            $query = DB::table('products')->where([['group_name', '=', 'i2_male_45u'], ['brand','=','Designs for Health']])->pluck('handle');
            $handleArr = json_decode($query, true);

            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['male_45u']['Designs for Health']['products'][$i] = $handleArr[$i];
            }
        }
        else if ($ix == "i3")
        {
            $query = DB::table('products')->where('group_name', '=', 'i3_cardiometabolic')->pluck('handle');
            $handleArr = json_decode($query, true);
            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['i3_cardiometabolic']['Designs for Health']['products'][$i] = $handleArr[$i];
            }

            $query = DB::table('products')->where('group_name', '=', 'i3_cardiometabolic')->pluck('handle');
            $handleArr = json_decode($query, true);
            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['i3_cardiometabolic']['Orthomolecular']['products'][$i] = $handleArr[$i];
            }
            
            $query = DB::table('products')->where('group_name', '=', 'i3_cardiometabolic')->pluck('handle');
            $handleArr = json_decode($query, true);
            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['i3_cardiometabolic']['Metagenics']['products'][$i] = $handleArr[$i];
            }

            
            $query = DB::table('products')->where('group_name', '=', 'i3_immune')->pluck('handle');
            $handleArr = json_decode($query, true);
            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['i3_immune']['Designs for Health']['products'][$i] = $handleArr[$i];
            }

            $query = DB::table('products')->where('group_name', '=', 'i3_immune')->pluck('handle');
            $handleArr = json_decode($query, true);
            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['i3_immune']['Orthomolecular']['products'][$i] = $handleArr[$i];
            }
            
            $query = DB::table('products')->where('group_name', '=', 'i3_immune')->pluck('handle');
            $handleArr = json_decode($query, true);
            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['i3_immune']['Metagenics']['products'][$i] = $handleArr[$i];
            }

            
            $query = DB::table('products')->where('group_name', '=', 'i3_cognition')->pluck('handle');
            $handleArr = json_decode($query, true);
            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['i3_cognition']['Designs for Health']['products'][$i] = $handleArr[$i];
            }

            $query = DB::table('products')->where('group_name', '=', 'i3_cognition')->pluck('handle');
            $handleArr = json_decode($query, true);
            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['i3_cognition']['Orthomolecular']['products'][$i] = $handleArr[$i];
            }
            
            $query = DB::table('products')->where('group_name', '=', 'i3_cognition')->pluck('handle');
            $handleArr = json_decode($query, true);
            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['i3_cognition']['Metagenics']['products'][$i] = $handleArr[$i];
            }

            
            $query = DB::table('products')->where('group_name', '=', 'i3_musculoskeletal')->pluck('handle');
            $handleArr = json_decode($query, true);
            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['i3_musculoskeletal']['Designs for Health']['products'][$i] = $handleArr[$i];
            }

            $query = DB::table('products')->where('group_name', '=', 'i3_musculoskeletal')->pluck('handle');
            $handleArr = json_decode($query, true);
            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['i3_musculoskeletal']['Orthomolecular']['products'][$i] = $handleArr[$i];
            }
            
            $query = DB::table('products')->where('group_name', '=', 'i3_musculoskeletal')->pluck('handle');
            $handleArr = json_decode($query, true);
            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['i3_musculoskeletal']['Metagenics']['products'][$i] = $handleArr[$i];
            }

            
            $query = DB::table('products')->where('group_name', '=', 'i3_energy')->pluck('handle');
            $handleArr = json_decode($query, true);
            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['i3_energy']['Designs for Health']['products'][$i] = $handleArr[$i];
            }

            $query = DB::table('products')->where('group_name', '=', 'i3_energy')->pluck('handle');
            $handleArr = json_decode($query, true);
            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['i3_energy']['Orthomolecular']['products'][$i] = $handleArr[$i];
            }
            
            $query = DB::table('products')->where('group_name', '=', 'i3_energy')->pluck('handle');
            $handleArr = json_decode($query, true);
            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['i3_energy']['Metagenics']['products'][$i] = $handleArr[$i];
            }

            
            $query = DB::table('products')->where('group_name', '=', 'i3_gastrointestinal')->pluck('handle');
            $handleArr = json_decode($query, true);
            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['i3_gastrointestinal']['Designs for Health']['products'][$i] = $handleArr[$i];
            }

            $query = DB::table('products')->where('group_name', '=', 'i3_gastrointestinal')->pluck('handle');
            $handleArr = json_decode($query, true);
            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['i3_gastrointestinal']['Orthomolecular']['products'][$i] = $handleArr[$i];
            }
            
            $query = DB::table('products')->where('group_name', '=', 'i3_gastrointestinal')->pluck('handle');
            $handleArr = json_decode($query, true);
            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['i3_gastrointestinal']['Metagenics']['products'][$i] = $handleArr[$i];
            }

            
            $query = DB::table('products')->where('group_name', '=', 'i3_hormone')->pluck('handle');
            $handleArr = json_decode($query, true);
            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['i3_hormone']['Designs for Health']['products'][$i] = $handleArr[$i];
            }

            $query = DB::table('products')->where('group_name', '=', 'i3_hormone')->pluck('handle');
            $handleArr = json_decode($query, true);
            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['i3_hormone']['Orthomolecular']['products'][$i] = $handleArr[$i];
            }
            
            $query = DB::table('products')->where('group_name', '=', 'i3_hormone')->pluck('handle');
            $handleArr = json_decode($query, true);
            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['i3_hormone']['Metagenics']['products'][$i] = $handleArr[$i];
            }

            
            $query = DB::table('products')->where('group_name', '=', 'i3_stress')->pluck('handle');
            $handleArr = json_decode($query, true);
            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['i3_stress']['Designs for Health']['products'][$i] = $handleArr[$i];
            }

            $query = DB::table('products')->where('group_name', '=', 'i3_stress')->pluck('handle');
            $handleArr = json_decode($query, true);
            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['i3_stress']['Orthomolecular']['products'][$i] = $handleArr[$i];
            }
            
            $query = DB::table('products')->where('group_name', '=', 'i3_stress')->pluck('handle');
            $handleArr = json_decode($query, true);
            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['i3_stress']['Metagenics']['products'][$i] = $handleArr[$i];
            }

            
            $query = DB::table('products')->where('group_name', '=', 'i3_toxicity')->pluck('handle');
            $handleArr = json_decode($query, true);
            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['i3_toxicity']['Designs for Health']['products'][$i] = $handleArr[$i];
            }

            $query = DB::table('products')->where('group_name', '=', 'i3_toxicity')->pluck('handle');
            $handleArr = json_decode($query, true);
            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['i3_toxicity']['Orthomolecular']['products'][$i] = $handleArr[$i];
            }
            
            $query = DB::table('products')->where('group_name', '=', 'i3_toxicity')->pluck('handle');
            $handleArr = json_decode($query, true);
            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['i3_toxicity']['Metagenics']['products'][$i] = $handleArr[$i];
            }

            
            $query = DB::table('products')->where('group_name', '=', 'i3_circulation')->pluck('handle');
            $handleArr = json_decode($query, true);
            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['i3_circulation']['Designs for Health']['products'][$i] = $handleArr[$i];
            }

            $query = DB::table('products')->where('group_name', '=', 'i3_circulation')->pluck('handle');
            $handleArr = json_decode($query, true);
            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['i3_circulation']['Orthomolecular']['products'][$i] = $handleArr[$i];
            }
            
            $query = DB::table('products')->where('group_name', '=', 'i3_circulation')->pluck('handle');
            $handleArr = json_decode($query, true);
            for ($i = 0; $i < count($handleArr); $i++)
            {
                $json['i3_circulation']['Metagenics']['products'][$i] = $handleArr[$i];
            }
        }

        return response()->json($json, 200);
    }
}
