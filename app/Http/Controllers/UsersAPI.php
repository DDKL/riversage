<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Users;
use Illuminate\Support\Facades\Log;

class UsersAPI extends Controller
{
    public function getUsers()
    {
		Log::info('getUsers() called, now running query.');
        $r = Users::select('id','email')->get();
		Log::info('query executed. result of $r: ' . $r);
        return response()->json($r, 200);
    }

    public function getUser($uid)
    {
		Log::info('getUser called, uid is: ' . $uid);
        $r = DB::table('users')->where('uid', $uid)->get();
		Log::info('query executed. result of $r: ' . $r);
        return response()->json($r, 200);
    }

    public function addUser(Request $req)
    {
		Log::info('addUser called.');
        $uid = $req["uid"];
		Log::info('requested uid is: ' . $uid);
        if (DB::table('users')->where('uid', $uid)->exists())
        {
            return response()->json(["message"=>"user with uid " . $uid . " exists."], 200);
        }
        else
        {
            $fname = $req["firstname"];
            $lname = $req["lastname"];
            $bday = $req["birthday"];
            $email = $req["email"];
            $sex = $req["sex"];
			
			Log::info('running query to insert new record to users table...');

            $users_id = DB::table('users')->insertGetId(
                ['first_name' => $fname, 'last_name' => $lname, 'birthday' => $bday, 'email' => $email, 'sex' => $sex, 'uid' => $uid]
            );
            return response()->json(["message" => "user successfully created with id: " . $users_id]);
        }
    }

    public function editUser(Request $req, $uid)
    {
		Log::info('editUser called, uid is: ' . $uid);
        if (Users::where('uid', $uid)->exists())
        {
            $user = Users::where('uid', $uid)->first();
            $first_name = is_null($req["firstname"]) ? $user->first_name : $req["firstname"];
            $last_name = is_null($req["lastname"]) ? $user->last_name : $req["lastname"];
            $email = is_null($req["email"]) ? $user->email : $req["email"];
            $birthday = is_null($req["birthday"]) ? $user->birthday : $req["birthday"];

            Users::where('uid', $uid)->update(["first_name"=>$first_name, "last_name"=>$last_name, "email"=>$email, "birthday"=>$birthday]);
        }
        else
        {
            return response()->json(["message" => "user not found"], 404);
        }
    }

    public function deleteUser($uid)
    {        
		Log::info('deleteUser called, uid is: ' . $uid);
        if (Users::where('uid', $uid)->exists())
        {
            Users::where('uid', $uid)->delete();

            return response()->json(["message" => "user successfully deleted with id: " . $uid]);
        }
        else
        {
            return response()->json(["message" => "user not found"], 404);
        }
    }
}
