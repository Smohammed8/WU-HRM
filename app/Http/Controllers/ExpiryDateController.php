<?php

namespace App\Http\Controllers;

use App\Models\ExpiryDate;
use App\Http\Requests\StoreExpiryDateRequest;
use App\Http\Requests\UpdateExpiryDateRequest;
use Illuminate\Support\Facades\Route;

class ExpiryDateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreExpiryDateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreExpiryDateRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ExpiryDate  $expiryDate
     * @return \Illuminate\Http\Response
     */
    public function show(ExpiryDate $expiryDate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ExpiryDate  $expiryDate
     * @return \Illuminate\Http\Response
     */
    public function edit(ExpiryDate $expiryDate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateExpiryDateRequest  $request
     * @param  \App\Models\ExpiryDate  $expiryDate
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateExpiryDateRequest $request, ExpiryDate $expiryDate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ExpiryDate  $expiryDate
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExpiryDate $expiryDate)
    {
        //
    }
}
