<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Region;
use Illuminate\Http\Request;

class RegionController extends Controller
{

    public function __construct()
    {

        $this->middleware('auth:sanctum')->except('index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       // $per_page=request('per_page') ?? 20;
        return Region::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // return $request->all();
        $request->validate([
            'name'=>'required',
            'damaged_info'=>'required'
        ]);


       $region= Region::create($request->all());

       return response()->json($region,201);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Region $region)
    {
        $request->validate([
            'name'=>'required',
            'damaged_info'=>'required'
        ]);

       $region->update($request->all());

       return response()->json($region,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Region $region)
    {
        $zones=$region->zones;
        foreach($zones as $zone){
            $zone->institution_posts()->delete();
        }
        $region->zones()->delete();
        $region->delete();
        return response()->json('sucessfully deleted',200);

    }
}
