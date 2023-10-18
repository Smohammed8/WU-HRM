<?php

namespace App\Http\Controllers;

use App\Models\IDSignatures;
use App\Http\Requests\StoreIDSignaturesRequest;
use App\Http\Requests\UpdateIDSignaturesRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class IDSignaturesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $idSignatures = IDSignatures::paginate(10);
        return view('signature.index', compact('idSignatures'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('signature.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreIDSignaturesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $path = 'signature';
        $signature = $request->file('signature');
        $seal = $request->file('seal');
        $titter = $request->file('titter');

        $sealName = time() . '_' . $seal->getClientOriginalName();
        $sealPath = $seal->storeAs($path, $sealName, 'public');

        $signatureName = time() . '_' . $signature->getClientOriginalName();
        $signaturePath = $signature->storeAs($path, $signatureName, 'public');

        $titterName = time() . '_' . $titter->getClientOriginalName();
        $titterPath = $signature->storeAs($path, $titterName, 'public');

        $user_id = Auth::user()->id;

        IDSignatures::create(['user_id'=>$user_id, 'seal'=>$sealName, 'signature'=>$signatureName, 'titter'=>$titterName]);

        return redirect()->back()->with('success', 'Successfully Saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\IDSignatures  $iDSignatures
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $iDSignature = IDSignatures::find($id);
        return view('signature.show', compact('iDSignature'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\IDSignatures  $iDSignatures
     * @return \Illuminate\Http\Response
     */
    public function edit(IDSignatures $iDSignatures)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateIDSignaturesRequest  $request
     * @param  \App\Models\IDSignatures  $iDSignatures
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateIDSignaturesRequest $request, IDSignatures $iDSignatures)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\IDSignatures  $iDSignatures
     * @return \Illuminate\Http\Response
     */
    public function destroy(IDSignatures $iDSignatures)
    {
        //
    }
}
