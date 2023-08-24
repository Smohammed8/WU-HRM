<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Employee;
use App\Models\EmployeeCategory;
use App\Models\HrBranch;
use App\Models\Position;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Facades\Auth;

//use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    
    public function index(){
        $users = DB::table('users')->count();
        $employees = DB::table('employees')->count();
        $employeeTypes = EmployeeCategory::all();
        $males    = Employee::where('gender', 'Male')->count();
        $females  = Employee::where('gender', 'Female')->count();
        $units    = Unit::count();
        $offices = HrBranch::all();
        $positions = Position::count();
        $probation = Employee::where('employment_type_id', 3)->count();
        dd($offices[2]->employees->count());
        return view('dashboard', compact('positions','users', 'offices','units', 'employees', 'employeeTypes', 'males', 'females','probation'));

       
}
}