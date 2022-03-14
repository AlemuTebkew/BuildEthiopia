<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    public function getDonation(){
        $per_page=request('per_page') ?? 10;
        return User::paginate($per_page);
    }
}
