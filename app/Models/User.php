<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class User extends Model
{
    use HasFactory,Notifiable;
    protected $fillable = [
        'full_name',
        'email',
        'word_of_support',
        'donation_amount',
        'address',
        'donated_for',
        'is_visible',

    ];


    // public function getCreatedAtAttribute($value){
    //     return Carbon::parse($value)->diffForHumans();
    // }
    public function donated_for(){
        return $this->belongsTo(Zone::class,'donated_for');
    }


}
