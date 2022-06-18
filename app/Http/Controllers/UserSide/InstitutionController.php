<?php

namespace App\Http\Controllers\UserSide;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\InstitutionPostResource as AdminInstitutionPostResource;
use App\Http\Resources\Admin\NewsResource;
use App\Http\Resources\UserSide\InstitutionPostResource;
use App\Http\Resources\UserSide\NewsResource as UserSideNewsResource;
use App\Models\InstitutionPost;
use App\Models\News;
use App\Models\Region;
use Illuminate\Http\Request;

class InstitutionController extends Controller
{
    public function getInstitutions(){

        $per_page=request('per_page') ?? 10;
        $post_query=InstitutionPost::query();
       $posts= $post_query->where('type',request('type'))
        ->when(request('zone'),function($query){
               $query->where('zone_id',request('zone'));
        })
        ->when(request()->filled('region'),function($query){
            $region=Region::find(request('region'));
            $zones=$region->zones->pluck('id');
           // return $zones;
            $query->whereIn('zone_id',$zones);
     }) ;
        return  InstitutionPostResource::collection($posts->with(['zone','postedBy'])->paginate($per_page));

    }


    public function getSuccessStories(){
        $per_page=request('per_page') ?? 10;
        return  UserSideNewsResource::collection(News::paginate($per_page));
    }

    public function getSuccessStoryDetail($id){
        $new=News::find($id);
        return new NewsResource($new);
    }
    public function getPostDetail($id){

        $post=InstitutionPost::find($id);
        return new AdminInstitutionPostResource($post->load(['images','zone','postedBy']));

    }
}
