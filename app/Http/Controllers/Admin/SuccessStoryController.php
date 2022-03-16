<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\NewsResource;
use App\Models\News;
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
            'description'=>'required'
        ]);

       $news= News::create($request->all());

        //calling image upload method from php class
        $iu=new ImageUpload();
        $iu->multipleImageUpload($request->images,$news->id);
        return response()->json($news,201);

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

        // $data=$request->except('images');
        // $data['posted_by']=$request->user()->id;
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
        $post= News::find($id);
        $path= public_path('/images');
        foreach ($post->images as $image) {
            if($image->path && file_exists($path.$image->path)){
                Storage::delete($path.$image->path);
               // unlink($path.$category->image);
            }

            $image->delete();

        }

        $post->delete();
        return response()->json('sucessfully saved',200);

    }
}
