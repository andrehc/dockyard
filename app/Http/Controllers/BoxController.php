<?php

namespace App\Http\Controllers;

use App\Http\Requests\BoxCreateRequest;
use App\Models\Box;

class BoxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Box::paginate();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\BoxCreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BoxCreateRequest $request)
    {
        return Box::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Box  $box
     * @return \Illuminate\Http\Response
     */
    public function show(Box $box)
    {
        return $box;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Box  $box
     * @return \Illuminate\Http\Response
     */
    public function destroy(Box $box)
    {
        $box->delete();
    }
}
