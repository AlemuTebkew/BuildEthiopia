<?php
namespace App\ReusedModule;
use App\Models\Image;

Class ImageUpload{

    public function multipleImageUpload($files,$post_id){

        try {
            $images=[];

            foreach ($files as $file) {

               $name = time().'.'.$file->extension();
               $file->move(public_path().'/images', $name);
               $image=new Image();
               $image->path=$name;
               $image->institution_post_id=$post_id;
               $image->save();
              // $images[] = $image;

        }
            } catch (\Throwable $th) {

                return response()->json('error while uploading images...',400);
        }

    // $product->images()->saveMany($images);


 }
}
