<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Employee;
use App\Models\EmployeeCategory;
use App\Models\Position;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Facades\Auth;

//use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

   

      
//         $cdate = new DateTime('now');


// $retir = Employee::where('date_of_birth', '<=', $correctedComparisons)->get();
// $retirment  = $$retir->count();



        
        $users = DB::table('users')->count();
        $employees = DB::table('employees')->count();
        $employeeTypes = EmployeeCategory::all();
        $males = Employee::where('gender', 'Male')->count();
        $females = Employee::where('gender', 'Female')->count();
        $units = Unit::count();
        $positions = Position::count();
        $probation = Employee::where('employment_type_id', 3)->count();

        return view('dashboard', compact('positions','users',
                                           'units', 
                                           'employees', 
                                           'employeeTypes', 
                                           'males', 
                                           'females','probation'));
    }
}
