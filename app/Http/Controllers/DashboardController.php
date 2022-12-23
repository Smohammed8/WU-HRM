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
        $users = DB::table('users')->count();
        $employees = DB::table('employees')->count();
        $employeeTypes = EmployeeCategory::all();
        $males = Employee::where('gender', 'Male')->count();
        $females = Employee::where('gender', 'Female')->count();
        $units = Unit::count();
        $positions = Position::count();
        return view('dashboard', compact('positions','users','units', 'employees', 'employeeTypes', 'males', 'females'));
    }
}
