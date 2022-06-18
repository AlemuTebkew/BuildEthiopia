<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\InstitutionPostResource;
use App\Models\Image;
use App\Models\InstitutionPost;
use App\Models\Region;
use Illuminate\Http\Request;
use App\ReusedModule;
use App\ReusedModule\ImageUpload;
use Illuminate\Support\Facades\Storage;

class InstitutionPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
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
     })
        ;
        return  InstitutionPostResource::collection($posts->with(['images','zone','postedBy'])->paginate($per_page));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


       // return  $data=$request->all();

        $request->validate([
            'title'=>'required',
            'type'=>'required',
            'description'=>'required',
            'images'=>'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'

        ]);

        $data=$request->all();
        $data['posted_by']=$request->user()->id;
        $post=InstitutionPost::create($data);

        //calling image upload method from php class

        $iu=new ImageUpload();
        $upload= $iu->multipleImageUpload($request->images,$post->id);
       if (count($upload) > 0) {
        return response()->json(new InstitutionPostResource($post->load('images')),201);
       }else{
        return response()->json('error while uploading..',401);
       }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(InstitutionPost $institutionPost)
    {
        return response()->json($institutionPost,200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title'=>'required',
            'type'=>'required',
            'description'=>'required'
        ]);

         $data=$request->all();
         $post=InstitutionPost::find($id);
         $post->update($data);

        return response()->json(new InstitutionPostResource($post->load('images')),200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post= InstitutionPost::find($id);
        $path= public_path().'/images/';
    //    return $post->images;
        foreach ($post->images as $image) {

            if($image->path && file_exists($path.$image->path)){
              //  return $image->path;
               // Storage::delete('images/'.$image->path);
                unlink($path.$image->path);
            }

            $image->delete();

        }

        $post->delete();
        return response()->json('sucessfully delete',200);

    }

    public function deleteImage($id){

        $image=Image::find($id);
        $path= public_path().'/images/';

     //   return $path.$image->path;
        if($image->path && file_exists($path.$image->path)){
         // return true;
             //Storage::delete('images/'.$image->path);
             unlink($path.$image->path);
        }

        $image->delete();
        return response()->json('sucessfully deleted',200);


    }

    public function updateImage(Request $request){
        $iu=new ImageUpload();
        $upload= $iu->multipleImageUpload($request->images,$request->post_id);
        if (count($upload) > 0) {
            return response()->json($upload,201);
        }else{
            return response()->json('error while uploading',401);

        }

    }


}
