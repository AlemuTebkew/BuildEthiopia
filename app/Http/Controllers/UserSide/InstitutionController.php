<?php

namespace App\Http\Controllers\UserSide;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\InstitutionPostResource;
use App\Http\Resources\Admin\NewsResource;
use App\Models\InstitutionPost;
use App\Models\News;
use Illuminate\Http\Request;

class InstitutionController extends Controller
{
    public function getInstitutions(){

        $per_page=request('per_page') ?? 10;
        return  InstitutionPostResource::collection(InstitutionPost::where('type',request('type'))
                                                    ->paginate($per_page));
    }

    public function getSuccessStories(){
        $per_page=request('per_page') ?? 10;
        return  NewsResource::collection(News::paginate($per_page));
    }
}
