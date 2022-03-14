<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    protected $fillable = [
        'full_name',
        'email',
        'word_of_support',
        'donation_amount',
        'is_visible',

    ];

}
