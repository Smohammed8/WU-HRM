<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\ExpiryDate;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

class IDController extends Controller
{
    public function idDownload(Request $request)
    {
        $role_left = '';
        $employee = Employee::find($request->get('user_id'));
        if (!$employee->position) {
            return abort(405, 'Please make sure employee position specified');
        }
        if (!$employee->photo) {
            return abort(405, 'Please make sure employee photo specified');
        }
        // dd(explode('photo//', $employee->photo));
        $a = strlen($employee->position->jobTitle->name);
        if ($a < 23) {
            $role_left = '0px';
        } else {
            $role_left = '35px';
        }
        $img = explode('photo//', $employee->photo)[0];
        $qrcode = $request->get('qrValue');
        $barcode = $request->get('barValue');
        $expireDate = Carbon::now()->addYears($employee->employeeCategory->expir_date);
        $pdf = Pdf::loadView('ID.printID', compact('employee', 'qrcode', 'barcode', 'role_left', 'img','expireDate'))->setPaper('a4', 'landscape');
        return $pdf->stream();
    }
}
