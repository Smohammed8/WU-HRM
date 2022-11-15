<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class IDController extends Controller
{
    public function idDownload(Request $request)
    {
        $role_left = '';
        $employee = Employee::find($request->get('user_id'));
        $a = strlen($employee->jobTitle->name);
        if ($a < 23) {
            $role_left = '0px';
        } else {
            $role_left = '35px';
        }
        // dd(public_path('/storage/employee/photo/01f390d29edc0343c47291819ef511c9.jpg'));
        $img = explode('photo//', $employee->photo)[1];
        $qrcode = $request->get('qrValue');
        $barcode = $request->get('barValue');
        $pdf = Pdf::loadView('ID.printID', compact('employee', 'qrcode', 'barcode', 'role_left', 'img'))->setPaper('a4', 'landscape');
        return $pdf->stream();
    }
}
