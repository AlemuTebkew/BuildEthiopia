<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    public function getDonation(){
        $per_page=request('per_page') ?? 10;

        return User::with('donated_for')->paginate($per_page);
    }


    public function getTotalDonation(){
        $user=User::whereNotNull('donation_amount')->count();
        $donation=User::sum('donation_amount');
        return response()->json(['total_user'=>$user,'total_money'=>$donation],200);
         
    }
 
}
