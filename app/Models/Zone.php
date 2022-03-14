<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    use HasFactory;
    public $timestamps=false;

    protected $fillable=['name','damaged_info','region_id'];


    public function institution_posts(){
        return $this->hasMany(InstitutionPost::class);
    }

    public function region(){
        return $this->belongsTo(Region::class);
    }

}
