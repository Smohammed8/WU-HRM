<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Employee;
use App\Models\EmployeeCategory;
use App\Models\HrBranch;
use App\Models\Position;
use App\Models\PositionCode;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

//use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

//     public function countEmployeesAbove60()
// {
//     $count = Employee::whereRaw('TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) >= 60')->count();

//     return $count;
// }

    
    public function index(){
        $users = DB::table('users')->count();
        $employees = DB::table('employees')->count();
        $employeeTypes = EmployeeCategory::all();
        $males    = Employee::where('gender', 'Male')->count();
        $females  = Employee::where('gender', 'Female')->count();
        $units    = Unit::count();
        $offices = HrBranch::all();
       // $positions = Position::count();
        $active_leaves = Employee::where('employment_status_id','!=',  1)->count();
        $retired       = Employee::whereRaw('TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) >= 60')->count();
        $permanets = DB::table('employees')->where('employment_type_id', 1)->count();
       // $contracts = DB::table('employees')->where('employment_type_id', 2)->count();

        $freepositions = PositionCode::where('employee_id', null)->count();
        $ocuupiedpositions = PositionCode::where('employee_id', '!=', null)->count();

        $probations = Employee::whereBetween('employement_date', [Carbon::now()->subyears(6), Carbon::now()])->count();
        $non_permanets = Employee::whereNotIn('employment_type_id', [1])->where('employment_type_id','!=', null)->count();

        $employeeData = [
            ['year' => 2016, 'value' => 77.9],
            ['year' => 2017, 'value' => 28],
            ['year' => 2018, 'value' => 65.5],
            ['year' => 2019, 'value' => 28],
            ['year' => 2020, 'value' => 0],
            ['year' => 2021, 'value' => 100],
            ['year' => 2022, 'value' => 0],
            ['year' => 2023, 'value' => 0],
            ['year' => 2024, 'value' => 0],
            ['year' => 2025, 'value' => 0],
            ['year' => 2026, 'value' => 0],
            ['year' => 2027, 'value' => 0]
        ];
    
    $employeeCategories = EmployeeCategory::all();
    $percentage = [];
    $totalEmployeeCount = 0;
    foreach ($employeeCategories as $category) {
        $employeeCount = Employee::where('employee_category_id','=', $category->id)->count();
        $percentage[] = [
            'category' => $category->name,
            'value' => $employeeCount,
        ];
        $totalEmployeeCount += $employeeCount;
    }
    foreach ($percentage as &$dataPoint) {
        $dataPoint['percentage'] = ($dataPoint['value'] / $totalEmployeeCount)*100;
     
    }
    
    
        $colleges = HrBranch::all();
    $bycollege = [];
    $totalEmployeeCounts = 0;
    foreach ($colleges as $hr) {
        $totalCount = Employee::where('hr_branch_id','=', $hr->id)->count();
        $bycollege [] = ['college' => $hr->name,'value' =>$totalCount];
        $totalEmployeeCounts += $totalCount;
    }
        foreach ($bycollege as &$dataPoint) {
            $dataPoint['bycollege'] = ($dataPoint['value'] / $totalEmployeeCounts)*100;
        
    
        }

            return view('dashboard', compact('users','permanets', 'freepositions','active_leaves', 'offices','units', 'percentage','employees','totalEmployeeCount','totalCount' ,'non_permanets','employeeTypes', 'males','employeeData','bycollege','females','retired','probations'));
       
}




public function notice()
{
    return view('notice');
}

}