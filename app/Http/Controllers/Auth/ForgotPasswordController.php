<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function forgot(Request $request)
    {
        $credentials = request()->validate(['email' => 'required|email']);
        if(Admin::where('email',$credentials)->doesntExist()){
            return response()->json([
                "msg" => "Email Not found"
            ],404);
        }
        Password::sendResetLink($credentials);

        return response()->json(["msg" => 'Reset password link sent on your email id.']);
    }

    public function reset(Request $request){
        $this->validate($request, [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ]);

        $admin = Admin::where('email',$request->email)->first();

        $admin->password = Hash::make($request->password);
        $admin->save();
        return response()->json([
            'message' => ' Reset Password Successfully',
        ], 200);
    }
}
