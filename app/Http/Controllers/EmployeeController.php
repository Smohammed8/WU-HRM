<?php

namespace App\Http\Controllers;


use App\Constants;
use App\Imports\EmployeesImport;
use App\Imports\NationalitiesImport;
use App\Imports\RegionsImport;
use App\Models\EducationalLevel;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\Employee;
use App\Models\Evaluation;
use App\Models\JobGrade;
use App\Models\PlacementChoice;
use App\Models\PlacementRound;
use App\Models\Position;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use NumberFormatter;
use Illuminate\Support\Facades\Route;

class EmployeeController extends Controller
{
    //

    public function home()
    {
        //$user = Auth::user();
        $user =  backpack_user();
        //dd($user->employee->id);
        $employee = Employee::where('user_id', $user->id)->get();

        if($user->employee == null){
            Auth::logout();
            return redirect()->route('login')->with('error', 'Please you have no employee profile contact admin.');
        }
        if ($employee->count() == 0 && !backpack_user()->hasRole('employee')) {

            Auth::logout();
            return redirect()->route('login')->with('error', 'Please you have no employee profile contact admin.');
        }
        $employee = $employee->first();
        $mark = Evaluation::select('total_mark')->where('employee_id', '=',$employee->id)->get()->first()?->total_mark;
      
        $level  =    Employee::where('id',$employee->id)->first()?->position?->jobTitle?->level_id;
        $startSalary  =    JobGrade::where('level_id', $level)->first()?->start_salary;
        $level_id  =    JobGrade::where('level_id', $level)->first()?->id;
        $step  =    Employee::where('id',  $employee->id)->first()?->horizontal_level;
      //////////////////// Warining: Don't change this code  //////////////////////////////////////
      if($step =='Start'){
        $startSalary = JobGrade::getSalarySheet($level_id, 'start_salary');
      }
      elseif($step =='1'){
          $startSalary = JobGrade::getSalarySheet($level_id, 'one');
      }
      elseif($step =='2'){
          $startSalary = JobGrade::getSalarySheet($level_id, 'two');
      }
      elseif($step =='3'){
          $startSalary = JobGrade::getSalarySheet($level_id, 'three');
      }
      elseif($step =='4'){
          $startSalary = JobGrade::getSalarySheet($level_id, 'four');
      }
      elseif($step =='5'){
          $startSalary = JobGrade::getSalarySheet($level_id, 'five');
      }
      elseif($step =='6'){
          $startSalary = JobGrade::getSalarySheet($level_id, 'six');
      }
      elseif($step =='7'){
          $startSalary = JobGrade::getSalarySheet($level_id, 'seven');
      }
      elseif($step =='8'){
          $startSalary = JobGrade::getSalarySheet($level_id, 'eight');
      }
      elseif($step =='9'){
          $startSalary = JobGrade::getSalarySheet($level_id, 'nine');
      }
      elseif($step =='Ceil'){
          $startSalary = JobGrade::getSalarySheet($level_id, 'ceil_salary');
      }
      else{
          $startSalar = JobGrade::getSalarySheet($level_id, 'start_salary');
      }

        $employee->totalExperiences();
        // $positions = Position::all();
        $placementRound = PlacementRound::where('is_open', true)->first();
        $edu_level = [];
        $positions = [];
        $employeeEducationLevel = $employee->educationLevel;
        foreach (EducationalLevel::where('weight', '<=', $employeeEducationLevel->weight)->get() as $key => $value) {
            array_push($edu_level, $value->id);
        }
        foreach (Position::all() as $key => $position) {
            if (in_array($position->jobTitle->educationalLevel->id, $edu_level)) {
                array_push($positions, $position);
            }
        }
        $placementChoice = PlacementChoice::where('employee_id',$employee->id)->where('placement_round_id',$placementRound->id)->first();
        return view('home', compact('user', 'employee','startSalary','mark','positions', 'placementRound','placementChoice'));
    }

    public function choiceStore(Request $request, PlacementRound $placementRound)
    {
        $data = $request->validate([
            'choice_one_id' => 'required',
            'choice_two_id' => 'required',
        ]);
        $user = Auth::user();
        $employee = Employee::where('uas_user_id', $user->username)->first();
        $placementChoice = PlacementChoice::firstOrCreate(['placement_round_id'=>$placementRound->id,'employee_id'=>$employee->id],[
            'placement_round_id',$placementRound->id,
            'employee_id',$employee->id,
            'choice_one_id' => $data['choice_one_id'],
            'choice_two_id' => $data['choice_two_id'],
        ]);
        $placementChoice->update([
            'choice_one_id' => $data['choice_one_id'],
            'choice_two_id' => $data['choice_two_id'],
        ]);
        return redirect()->back()->with(['message','Employee choice saved successfully']);
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
            $college = $request->get('college');
            Excel::import(new EmployeesImport($college), request()->file('file'));
        }
        // Excel::import(new EmployeesImport, "/abc.xl");
       // dd('IMPORT DONE');
    }
    public function calculate()
    {
        $placementChoice = PlacementChoice::first();
        $employee = $placementChoice->employee;
        $choiceOne = $placementChoice->choiceOne;
        $choiceTwo = $placementChoice->choiceTwo;
        $employee->calculateEducationalValue($choiceOne);
        $employee->calculateEducationalValue($choiceTwo);
    }



    public function findEmployeesWithDuplicatedPhoneNumbers()
{
    $duplicatedPhoneNumbers = Employee::select('phone_number')
        ->groupBy('phone_number')->havingRaw('COUNT(phone_number) > 1')->pluck('phone_number');

    $employeesWithDuplicatedPhoneNumbers = Employee::whereIn('phone_number', $duplicatedPhoneNumbers)->get();

    return view('employee.index', compact('employeesWithDuplicatedPhoneNumbers'));
}


    public function suspectedErrors(){


    $employees_employeds = Employee::where('employment_status_id', 1)->where('employement_date', '<', Carbon::now()->subYears(35))->union(Employee::whereBetween('employement_date', [Carbon::now()->subMonths(6), Carbon::now()]))->orderBy('id', 'DESC')->paginate(10);
    
    $employee_ages = Employee::where('employment_status_id', 1)->orderBy('id', 'DESC')->paginate(10); 

    $employees = Employee::whereNull('position_id')->orderBy('id', 'DESC')->paginate(10);
   // $employees = Employee::whereDoesntHave('position')->orderBy('id', 'DESC')->paginate(10);
  // $employees_internal = Employee::whereHas('internalExperiences')->get();
   $employees_internal = Employee::whereHas('internalExperiences')->paginate(10);
   $employees_external = Employee::whereHas('externalExperiences')->paginate(10);
    /////////////////////////////////////////////////////////
    $duplicatedPhoneNumbers = Employee::select('phone_number')->groupBy('phone_number')->havingRaw('COUNT(phone_number) > 1')
    ->pluck('phone_number');
    $employees_phone = Employee::whereIn('phone_number', $duplicatedPhoneNumbers)->paginate(10); 
   ////////////////////////////////////////////////////////////


  return view('employee.suspected_errors', compact('employees','employees_employeds','employees_phone','employees_internal', 'employee_ages','employees_external'));


    }
}
