<?php

namespace App\Http\Controllers\UserSide;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\ThankUForDonation;
use Illuminate\Http\Request;
use League\CommonMark\Extension\CommonMark\Renderer\Block\ThematicBreakRenderer;
use App\Http\Resources\UserSide\DonationResource;

class DonationController extends Controller
{
    public function saveDonation(Request $request){

        $request->validate([

            'full_name'=>'required',
            'donation_amount'=>'required',
            'currency_code'=>'required',

        ]);

        $user=User::create($request->all());
        $user->notify(new ThankUForDonation());
        return response()->json($user->load('donated_for'),201);
    }

    public function getDonation(){
        $per_page=request('per_page') ?? 10;
        $users_query=User::query()->with('donated_for')
        ->when(request('type') == 'top',function($q){
           $q->orderByDesc('donation_amount');
        },function($qq){
            $qq->latest();
        });
        return DonationResource::collection($users_query->paginate($per_page));
    }

    public function getWords(){
        $per_page=request('per_page') ?? 10;
        return User::with('donated_for')->whereNotNull('word_of_support')->paginate($per_page);
    }





}
