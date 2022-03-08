<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{

    public function login(Request $request){

        $request->validate([

            'email'=>'required',
            'password'=>'required',

        ]);

        $user=Admin::where('email',$request->email)->first();
        if (! $user ) {
            return response()->json([
                'message'=>' incorrect email and password',
                ]
               ,404 );
        }
        $check=Hash::check($request->password, $user->password);
        if (! $check ) {
            return response()->json([
                'message'=>' incorrect email and password',
                ]
               ,404 );
        }

        $token=$user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'access_token'=>$token,
            'user'=>$user,
        ],200);

     }

    public function logout(Request $request){
        //  return  $request->user();
            $request->user()->currentAccessToken()->delete();
            return response()->json([
                'message'=>$request->user(),
            ],200);

        }
}
