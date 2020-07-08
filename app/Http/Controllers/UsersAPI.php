<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsersAPI extends Controller
{
    public function getUsers()
    {
        $r = DB::table('users')->select('id','email')->get();

        return response()->json($r, 200);
    }

    public function getUser($users_id)
    {
        $r = DB::table('users')->where('id', $users_id)->get();

        return response()->json($r, 200);
    }

    public function addUser(Request $req)
    {
        $uid = $req["uid"];

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

            $users_id = DB::table('users')->insertGetId(
                ['first_name' => $fname, 'last_name' => $lname, 'birthday' => $bday, 'email' => $email, 'sex' => $sex, 'uid' => $uid]
            );

            return response()->json(["message" => "user successfully created with id: " . $users_id]);
        }
    }

    public function editUser(Request $req, $users_id)
    {
        if (DB::table('users')->where('id', $users_id)->exists())
        {
            $user = DB::table('users')->where('id', $users_id)->find($users_id);
            $first_name = is_null($req["firstname"]) ? $user->first_name : $req["firstname"];
            $last_name = is_null($req["lastname"]) ? $user->last_name : $req["lastname"];
            $email = is_null($req["email"]) ? $user->email : $req["email"];
            $birthday = is_null($req["birthday"]) ? $user->birthday : $req["birthday"];

            DB::table('users')->where('id', $users_id)->update(["first_name"=>$first_name, "last_name"=>$last_name, "email"=>$email, "birthday"=>$birthday]);
        }
        else
        {
            return response()->json(["message" => "user not found"], 404);
        }
    }
}
