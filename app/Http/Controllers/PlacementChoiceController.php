<?php

namespace App\Http\Controllers;

use App\Models\EducationalLevel;
use App\Models\Employee;
use App\Models\PlacementChoice;
use App\Models\PlacementRound;
use App\Models\Position;
use Illuminate\Http\Request;

class PlacementChoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PlacementRound $placementRound)
    {
        $placementChoices = PlacementChoice::paginate(10);
        return view('placement_choice.index', compact('placementChoices', 'placementRound'));   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(PlacementRound $placementRound)
    {
        $employees = Employee::all();
        $positions = Position::all();
        return view('placement_choice.create', compact('placementRound', 'positions', 'employees'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PlacementRound $placementRound , Request $request)
    {
        $employee =  Employee::find($request->get('employee'));
        $first_choice = Position::find($request->get('first_choice'));
        $second_choice = Position::find($request->get('second_choice'));

        PlacementChoice::create(['placement_round_id'=>$placementRound->id, 'employee_id'=>$employee->id, 'choice_one_id'=>$first_choice->id, 'choice_two_id'=>$second_choice->id]);
        
        \Alert::success('Placement choice added successfully')->flash();
        return redirect()->route('placement-choice.index', ['placement_round'=>$placementRound->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function choiceBasedEmployee(Request $request)
    {
        $edu_level = [];
        $positions = [];
        $employee = Employee::find($request->employee_id);
        $employeeEducationLevel = $employee->educationLevel;
        foreach (EducationalLevel::where('weight','<=', $employeeEducationLevel->weight)->get() as $key => $value) {
            array_push($edu_level, $value->id);
        }

        foreach (Position::all() as $key => $position) {
            if (in_array($position->jobTitle->educationalLevel->id, $edu_level)) {
                array_push($positions, $position);
            }
        }
        return response()->json(['positions' => $positions]);
    }

    public function removeChoosedPosition(Request $request)
    {
        $positions = Position::where('id', '!=', $request->position_id)->get();

        return response()->json(['positions' => $positions]);
    }
}