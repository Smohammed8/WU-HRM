<?php

namespace App\Http\Controllers;


use App\Constants;
use App\Imports\EmployeesImport;
use App\Imports\NationalitiesImport;
use App\Imports\RegionsImport;
use App\Models\EducationalLevel;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\Employee;
use App\Models\PlacementChoice;
use App\Models\PlacementRound;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use NumberFormatter;

class EmployeeController extends Controller
{
    //

    public function home()
    {
        if ((!backpack_user()->can('employee.home') && backpack_user()->can('dashboard.content')) || backpack_user()->hasRole(Constants::USER_TYPE_SUPER_ADMIN)) {
            return redirect(route('dashboard'));
        }

        if (!Auth::user()->can('employee.home')) {
            return abort(401);
        }
        $user = Auth::user();
        $employee = Employee::where('uas_user_id', $user->username)->get();
        if ($employee->count() == 0 && backpack_user()->hasRole('employee')) {
            Auth::logout();
            return abort(401, 'Please you have no employee profile contact admin');
        }
        if ($employee->count() == 0 && !backpack_user()->hasRole('employee')) {
            return redirect()->back();
        }
        $employee = $employee->first();
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
        return view('home', compact('user', 'employee', 'positions', 'placementRound','placementChoice'));
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
        dd('IMPORT DONE');
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
}
