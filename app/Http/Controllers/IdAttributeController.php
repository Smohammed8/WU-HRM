<?php

namespace App\Http\Controllers;

use App\Models\IdAttribute;
use App\Http\Requests\StoreIdAttributeRequest;
use App\Http\Requests\UpdateIdAttributeRequest;
use Illuminate\Http\Request;

class IdAttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attributes = IdAttribute::paginate(10);
        return view('id_attributes.index', compact('attributes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('id_attributes.new');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreIdAttributeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        IdAttribute::create(['name'=>$request->get('name')]);
        return redirect()->route('attribute.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\IdAttribute  $idAttribute
     * @return \Illuminate\Http\Response
     */
    public function show(IdAttribute $idAttribute)
    {
        dd($idAttribute);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\IdAttribute  $idAttribute
     * @return \Illuminate\Http\Response
     */
    public function edit(IdAttribute $idAttribute)
    {
        dd($idAttribute);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateIdAttributeRequest  $request
     * @param  \App\Models\IdAttribute  $idAttribute
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateIdAttributeRequest $request, IdAttribute $idAttribute)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\IdAttribute  $idAttribute
     * @return \Illuminate\Http\Response
     */
    public function destroy(IdAttribute $idAttribute)
    {
        //
    }
}
