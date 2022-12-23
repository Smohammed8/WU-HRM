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
        if (!$employee->position) {
            return abort(405, 'Please make sure employee position specified');
        }
        if (!$employee->photo) {
            return abort(405, 'Please make sure employee photo specified');
        }
        $a = strlen($employee->position->jobTitle->name);
        if ($a < 23) {
            $role_left = '0px';
        } else {
            $role_left = '35px';
        }
        if (in_array('profile.jpg', explode('/', $employee->photo)) && in_array('image', explode('/', $employee->photo)))
            $img = $employee->photo;
        else
            $img = '/storage/employee/photo/' . (explode('photo//', $employee->photo)[1]);
        $qrcode = $request->get('qrValue');
        $barcode = $request->get('barValue');
        $pdf = Pdf::loadView('ID.printID', compact('employee', 'qrcode', 'barcode', 'role_left', 'img'))->setPaper('a4', 'landscape');
        return $pdf->stream();
    }
}
