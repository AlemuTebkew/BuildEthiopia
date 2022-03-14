<?php

namespace App\Http\Controllers\Admin;

use App\Models\Zone;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class ZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      //  $per_page=request('per_page') ?? 20;
        return Zone::with('region')->get();
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
            'name'=>'required',
            'damaged_info'=>'required',
            'region_id'=>'required'
        ]);

       $zone= Zone::create($request->all());

       return response()->json($zone->load('region'),201);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Zone  $zone
     * @return \Illuminate\Http\Response
     */
    public function show(Zone $zone)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Zone  $zone
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Zone $zone)
    {
        $request->validate([
            'name'=>'required',
            'damaged_info'=>'required',
            'region_id'=>'required'
        ]);

       $zone->update($request->all());

       return response()->json($zone->load('region'),200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Zone  $zone
     * @return \Illuminate\Http\Response
     */
    public function destroy(Zone $zone)
    {
        $zone->delete();
        return response()->json('successfully deleted',200);
    }
}
