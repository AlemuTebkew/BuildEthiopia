<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;


    public $timestamps=false;
    protected $fillable=['name','damaged_info'];


    public function zones(){
        return $this->hasMany(Zone::class);
    }

}
