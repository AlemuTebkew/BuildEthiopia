<?php

namespace App\Http\Controllers\UserSide;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    public function saveDonation(Request $request){

        $request->validate([

            'full_name'=>'required',
            'donation_amount'=>'required',

        ]);

        $user=User::create($request->all());
        return response()->json($user,201);
    }

    public function getDonation(){
        $per_page=request('per_page') ?? 10;
        return User::paginate($per_page);
    }
}
