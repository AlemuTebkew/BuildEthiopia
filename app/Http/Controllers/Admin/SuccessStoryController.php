<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\NewsResource;
use App\Models\Image;
use App\Models\News;
use App\Models\NewsImage;
use App\ReusedModule\ImageUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SuccessStoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $per_page=request('per_page') ?? 10;
        return  NewsResource::collection(News::paginate($per_page));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'=>'required',
            'description'=>'required',
            'images'=>'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

       $news= News::create($request->all());

        //calling image upload method from php class
        $iu=new ImageUpload();
        $upload=$iu->newsMultipleImageUpload($request->images,$news->id);
        if (count($upload) > 0) {
            return response()->json(new NewsResource($news->load('images')),201);
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
    public function show(News $new)
    {
        return response()->json($new,200);
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
            'description'=>'required'
        ]);

        $post=News::find($id);
        $post->update($request->all());

      return response()->json($post,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $news= News::find($id);
        $path= public_path('/images/');
        foreach ($news->images as $image) {
            if($image->path && file_exists($path.$image->path)){
                //Storage::delete($path.$image->path);
                unlink($path.$image->path);
               }

            $image->delete();

        }

        $news->delete();
        return response()->json('sucessfully deleted',200);

    }

    public function deleteImage($id){

        $image=NewsImage::find($id);
        $path= public_path('/images/');

        if($image->path && file_exists($path.$image->path)){
           // Storage::delete($path.$image->path);
            unlink($path.$image->path);
        }

        $image->delete();
        return response()->json('sucessfully deleted',200);

    }

    public function updateImage(Request $request){
        $iu=new ImageUpload();
       // return $request->all();
        $upload= $iu->newsMultipleImageUpload($request->images,$request->news_id);
        if (count($upload) > 0) {
            return response()->json($upload,201);
        }else{
            return response()->json('error while uploading',401);

        }

    }
}
