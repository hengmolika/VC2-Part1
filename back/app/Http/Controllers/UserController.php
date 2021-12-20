<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    
    public function register(Request $request)
    {
        $request->validate([
            "first_name" => "min:1|max:10",
            "last_name" => "min:1|max:10",
            "email" => ['email', 'unique:users'],
            "password" => ['min:4', 'confirmed']
        ]);

        //create user
        $user = new User();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);

        $user->save();


        return response()->json([
            'message' => "Registered",
            'user' => $user,
        ]);
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return response()->json(['message' => 'User logout']);
    }
    
    public function login(Request $request)
    { 
        //check email
        $user = User::where('email', $request->email)->first();

        //check password
        if(!$user || !Hash::check($request->password, $user->password)){
            return response()->json(['message' => 'fail']);
        }

        return response()->json([
            "message" => "logined",
            'user' => $user,
        ]);
    }
    
    public function index() {
        return User::get();
    }

    public function show($id) {
        return User::findOrfail($id);
    }

    public function destroy($id){
        return User::destroy($id);
    }
}
