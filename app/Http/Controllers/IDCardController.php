<?php

namespace App\Http\Controllers;

use App\Models\IDCard;
use App\Http\Requests\StoreIDCardRequest;
use App\Http\Requests\UpdateIDCardRequest;
use App\Models\Employee;
use App\Models\IdAttribute;
use App\Models\IDSignatures;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class IDCardController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!backpack_user()->canany(['id.index', 'id.icrud'])) {
            return abort(401);
        }
        $idcards = IDCard::all();
        return view('ID.index', compact('idcards'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        if (!backpack_user()->canany(['id.index', 'id.icrud'])) {
            return abort(401);
        }
        return view('ID.new');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreIDCardRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!backpack_user()->canany(['id.create', 'id.icrud'])) {
            return abort(401);
        }
        $path = 'idcard';
        $frontPage = $request->file('front');
        $backPage = $request->file('back');
        $signature = $request->file('signature');
        $seal = $request->file('seal');

        if ($seal) {
            $sealName = time() . '_' . $seal->getClientOriginalName();
            $sealPath = $seal->storeAs($path, $sealName, 'public');
        }
        if ($signature) {
            $signatureName = time() . '_' . $signature->getClientOriginalName();
            $signaturePath = $signature->storeAs($path, $signatureName, 'public');
        }
        if ($frontPage && $backPage) {
            $frontPageName = time() . '_' . $frontPage->getClientOriginalName();
            $frontPagePath = $frontPage->storeAs($path, $frontPageName, 'public');
            $backPageName = time() . '_' . $backPage->getClientOriginalName();
            $backPagePath = $backPage->storeAs($path, $backPageName, 'public');
            IDCard::create(['name' => $request->get('name'), 'front_page' => $frontPageName, 'back_page' => $backPageName, 'signature' => $signatureName, 'seal' => $sealName]);
            return redirect()->back()->with('success', 'Successfully Saved');
        }

        return redirect()->back()->with('error', 'Error Occured');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\IDCard  $iDCard
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!backpack_user()->canany(['id.show', 'id.icrud'])) {
            return abort(401);
        }
        $iDCard = IDCard::find($id);
        return view('ID.show', compact('iDCard'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\IDCard  $iDCard
     * @return \Illuminate\Http\Response
     */
    public function edit(IDCard $iDCard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateIDCardRequest  $request
     * @param  \App\Models\IDCard  $iDCard
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateIDCardRequest $request, IDCard $iDCard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\IDCard  $iDCard
     * @return \Illuminate\Http\Response
     */
    public function destroy(IDCard $iDCard)
    {
        //
    }

    public function design($id)
    {
        if (!backpack_user()->canany(['id.design.index', 'id.design.icrud'])) {
            return abort(401);
        }
        $idCard = IDCard::find($id);
        $attributes = IdAttribute::all();
        return view('ID.design', compact('idCard', 'attributes'));
    }

    public function saveDesign($id, Request $request)
    {
        if (!backpack_user()->canany(['id.design.store', 'id.design.icrud'])) {
            return abort(401);
        }
        $idCard = IDCard::find($id);
        $front_data = $request->get('front_data');
        $back_data = $request->get('back_data');
        $front_tab = $request->get('tab1_temp');
        $back_tab = $request->get('tab2_temp');
        $check = $idCard->update(['front_page_tab' => $front_tab, 'back_page_tab' => $back_tab, 'front_page_template' => $front_data, 'back_page_template' => $back_data]);
        return response()->json(['data' => $check]);
    }

    public function printList(Request $request)
    {
        $employees = Employee::paginate(10);
        return view('ID.emp_list', compact('employees'));
    }

    public function printID($emp_id)
    {
        $role_left = '';
        $employee = Employee::find($emp_id);
        // dd($employee);
        $a = strlen($employee->position->jobTitle->name);
        if ($a < 23) {
            $role_left = '0px';
        } else {
            $role_left = '35px';
        }
        if (count(explode('photo//', $employee->photo)) > 1) {
            $img = explode('photo//', $employee->photo)[1];
        } else {
            $img = 'profile.png';
        }
        $idsign = IDSignatures::latest()->first();
        // dd($img);
        // dd(public_path('storage/employee/photo/'.$img));
        $qrcode = $request->get('qrValue');
        $barcode = $request->get('barValue');
        // dd($idsign);
        $pdf = Pdf::loadView('ID.printID', compact('employee', 'qrcode', 'barcode', 'role_left', 'img'))->setPaper('a4', 'landscape');
        return $pdf->stream();

        // $employee = Employee::find($emp_id);
        // if (count(explode('photo//', $employee->photo)) > 1) {
        //     $img = explode('photo//', $employee->photo)[1];
        // } else {
        //     $img = 'profile.png';
        // }
        // $idsign = IDSignatures::latest()->first();
        // $pdf = Pdf::loadView('ID.id_print', compact('employee', 'img', 'idsign'))->setPaper('a4', 'landscape');
        // return $pdf->stream();
    }
}
