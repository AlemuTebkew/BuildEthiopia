<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstitutionPost extends Model
{
    use HasFactory;
    protected $fillable=['title','type','description','woreda','kebele','zone_id','posted_by'];

    protected $casts = [
        'updated_at' => 'datetime',
    ];
    public function postedBy(){
        return $this->belongsTo(Admin::class,'posted_by');
    }

    public function zone(){
        return $this->belongsTo(Zone::class);
    }

    public function images(){
        return $this->hasMany(Image::class);
    }

}
