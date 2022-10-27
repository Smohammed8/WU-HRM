<?php

namespace App\Http\Controllers;


use App\Constants;
use App\Imports\EmployeesImport;
use App\Imports\NationalitiesImport;
use App\Imports\RegionsImport;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    //

    public function home()
    {
        $user = Auth::user();
        $employee = Employee::where('uas_user_id', $user->id);
        if ($employee->count() == 0) {
            return abort(405, 'Please you have no employee profile contact admin');
        }
        $employee = $employee->first();
        return view('home', compact('user', 'employee'));
    }
    public function importPage()
    {
        $colleges = Constants::COLLEGES;
        return view('employee.import', compact('colleges'));
    }

    public function import(Request $request)
    {
        if ($request->get('type') == 'country') {
            Excel::import(new NationalitiesImport, request()->file('file'));
        }

        if ($request->get('type') == 'region') {
            Excel::import(new RegionsImport, request()->file('file'));
        }
        if ($request->get('type') == 'employee') {
            Excel::import(new EmployeesImport, request()->file('file'));
        }
        // Excel::import(new EmployeesImport, "/abc.xl");
        dd('IMPORT DONE');
    }
}
