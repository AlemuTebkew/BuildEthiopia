<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\InstitutionPostResource;
use App\Models\Image;
use App\Models\InstitutionPost;
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
        return  InstitutionPostResource::collection(InstitutionPost::paginate($per_page));
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
            'type'=>'required',
            'description'=>'required'
        ]);

        $data=$request->except('images');
        $data['posted_by']=$request->user()->id;
        $post=InstitutionPost::create($data);

        //calling image upload method from php class
        $iu=new ImageUpload();
        $iu->multipleImageUpload($request->images,$post->id);

      return response()->json($post,201);


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

        // $data=$request->except('images');
        // $data['posted_by']=$request->user()->id;
        $post=InstitutionPost::find($id);
        $post->update($request->all());

      return response()->json('sucessfully saved',200);
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

    public function deleteImage($id){

        $image=Image::find($id);
        $path= public_path('/images');

        if($image->path && file_exists($path.$image->path)){
            Storage::delete($path.$image->path);
           // unlink($path.$category->image);
        }

        $image->delete();
        return response()->json('sucessfully saved',200);


    }

    public function updateImage(Request $request){
        $iu=new ImageUpload();
        $iu->multipleImageUpload($request->images,$request->id);
        return response()->json('sucessfully saved',200);

    }
}
