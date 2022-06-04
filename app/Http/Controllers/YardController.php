<?php

namespace App\Http\Controllers;

use App\Models\Yard;
use Illuminate\Http\Request;
use Illuminate\Support\ItemNotFoundException;

class YardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Yard::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $yard = new Yard();

        $yard->locator = $request->locator;
        $yard->length = $request->length;
        $yard->width = $request->width;

        $yard->save();

        return $yard;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Yard::find($id);
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
        $yard = Yard::find($id);
        
        if(!$yard)
        {
            abort(404, 'Yard not found');
        }

        $yard->locator = $request->locator;
        $yard->length = $request->length;
        $yard->width = $request->width;

        $yard->save();

        return $yard;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $yard = Yard::find($id);
        
        if(!$yard)
        {
            abort(404, 'Yard not found');
        }
        
        $yard->delete();
        
    }
}
