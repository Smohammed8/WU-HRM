<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Constants;
use App\Models\EducationalLevel;
use App\Models\Employee;
use App\Models\EmployeeCategory;
use App\Models\Evaluation;
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
    
       ////////////////////////////////////////////////////
     $year =  $this->getEtYear(Carbon::now());
     $month =  $this->getEtMonth(Carbon::now());
    $gyear = Carbon::now()->year;


        $freepositions = PositionCode::where('employee_id', null)->count();
        $ocuupiedpositions = PositionCode::where('employee_id', '!=', null)->count();

        $probations = Employee::whereBetween('employement_date', [Carbon::now()->subyears(6), Carbon::now()])->count();
        $non_permanets = Employee::whereNotIn('employment_type_id', [1])->where('employment_type_id','!=', null)->count();
/////////////////////////////////////////////////////////////////



$employeeData = [];


for ($i = 0; $i < 12; $i++) {
    $firstHalfTotalMarks = 0;
    $firstHalfEmployeeCount = 0;
    $secondHalfTotalMarks = 0;
    $secondHalfEmployeeCount = 0;

    $emps = Employee::all();

    foreach ($emps as $employee) {
        foreach ($employee->evaluations as $evaluation) {

            $startMonth = $evaluation->quarter->start_date->month;
            $endMonth = $evaluation->quarter->end_date->month;

            $evaluationYear = Carbon::parse($evaluation->created_at)->year;
            $evaluationMonth = Carbon::parse($evaluation->created_at)->month;

            if ($evaluationYear == ($gyear + $i)) {
                             // First half
                if ($evaluationMonth >=  4 && $evaluationMonth <=11) {
                    $firstHalfTotalMarks += $evaluation->total_mark;
                    $firstHalfEmployeeCount++;

                } 
                             // second half
                elseif ($evaluationMonth >=  $startMonth && $evaluationMonth <= $endMonth ) {
                    $secondHalfTotalMarks += $evaluation->total_mark;
                    $secondHalfEmployeeCount++;
                }
            }
        }
    }
    $firstHalfAverage = $firstHalfEmployeeCount > 0 ? $firstHalfTotalMarks / $firstHalfEmployeeCount : 0;
    $secondHalfAverage = $secondHalfEmployeeCount > 0 ? $secondHalfTotalMarks / $secondHalfEmployeeCount : 0;

    $employeeData[] = [
        'year' => $year + $i,
        'value' => ($firstHalfAverage + $secondHalfAverage),
    ];
}
   
    ///////////////////////////////////////////////////////////////
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

 
   ///////////////////////////////////////////////////////////////////////// 
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
    //////////////////////////////////////////////////////////////////////

    $hrBranches = HrBranch::withCount(['employees as male_count' => function ($query) {
        $query->where('gender', 'Male');
    }])->withCount(['employees as female_count' => function ($query) {
        $query->where('gender', 'Female');
    }])->get();

    /////////////////////////////////////////////////////////////////////
    $educationalLevels = EducationalLevel::withCount('employees')->get();

    /////////////////////////////////////////////////////////////////////
            return view('dashboard', compact('users','permanets', 'freepositions','active_leaves', 'offices','units', 'percentage','educationalLevels','employees','totalEmployeeCount','totalCount', 'year','non_permanets','employeeTypes', 'hrBranches','males','employeeData','bycollege','females','retired','probations'));
       
}




public function getEtYear($year)
{
    return Constants::getYearEt($year);
}
public function getEtMonth($date)
{
    return Constants::getEtMonth($date);
}
public function notice()
{
    return view('notice');
}

}