<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Exports\ExportChoice;
use App\Models\EducationalLevel;
use App\Models\Employee;
use App\Models\Organization;
use App\Models\PlacementChoice;
use App\Models\PlacementRound;
use App\Models\Position;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Prologue\Alerts\Facades\Alert;

class PlacementChoiceController extends Controller
{
    public $unitsArray = [];

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
    public function store(PlacementRound $placementRound, Request $request)
    {
        $employee =  Employee::find($request->get('employee'));
        $first_choice = Position::find($request->get('first_choice'));
        $second_choice = Position::find($request->get('second_choice'));

        PlacementChoice::create(['placement_round_id' => $placementRound->id, 'employee_id' => $employee->id, 'choice_one_id' => $first_choice->id, 'choice_two_id' => $second_choice->id]);

        Alert::success('Placement choice added successfully')->flash();
        return redirect()->route('placement-choice.index', ['placement_round' => $placementRound->id]);
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
        foreach (EducationalLevel::where('weight', '<=', $employeeEducationLevel->weight)->get() as $key => $value) {
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
    public function paginate($items, $perPage = 10, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, ['path' => request()->url(), 'query' => request()->query()]);
    }
    public function listAll(PlacementRound $placementRound, Request $request)
    {
        set_time_limit(2000);
        $first_unit = Organization::first()->id;
        $onlypos = false;
        // $val = 'parent_unit_id';
        if ($request->get('filter')) {
            $allChecked = $request->get('all_checked');
            if ($request->get('unit') > 0) {
                $first_unit = $request->get('unit');
                if ($allChecked) {
                    $onlypos = true;
                }
            }
        }
        $unit = Unit::where('id', $first_unit)->first();
        if (!$unit) {
            $unit = Unit::find($first_unit);
        }
        $this->attachUnitToArray($unit, $onlypos);
        $route = route('placement_choice.list_all',['placement_round'=>$placementRound->id]);
        
        $allUnits = Unit::all();
        $units = $this->paginate($this->unitsArray);
        if ($request->get('choice_pdf')) {
            $type = 'choice';
            $pdf = $this->pdfDownload($this->unitsArray, $type);
            return $pdf->stream();
        }
        if ($request->get('result_pdf')) {
            $type = 'result';
            $pdf = $this->pdfDownload($this->unitsArray, $type);
            return $pdf->stream();
        }

        if ($request->get('choice_excel')) {
            $type = 'choice';
            $arr_data = $this->exportChoice($this->unitsArray, $type);
            return Excel::download(new ExportChoice($arr_data, ['Full name', 'Unit', 'Current position','First Choice','Second Choice']), 'ju_placement_choice.xlsx');
        }

        if ($request->get('result_excel')) {
            $type = 'result';
            $arr_data = $this->exportChoice($this->unitsArray, $type);
            return Excel::download(new ExportChoice($arr_data, ['Full name', 'Unit', 'Current position','First Choice','Second Choice']), 'ju_placement_choice.xlsx');
        }

        return view('placement_choice.index', compact('units', 'placementRound', 'allUnits'));
    }
    function attachUnitToArray($unit, $onlypos)
    {
        if ($onlypos) {
            array_push($this->unitsArray, $unit);
        }else{
            array_push($this->unitsArray, $unit);
            foreach ($unit->childs as $child) {
                $this->attachUnitToArray($child, false);
            }
        }
    }

    public function pdfDownload($units, $type)
    {
        $pdf = Pdf::loadView('placement_choice.pdf', compact('units', 'type'))->setPaper('a4', 'landscape');
        return $pdf;
    }

    public function exportChoice($units, $type)
    {
        // $unit_ids = collect($units)->pluck('id');
        $aa = [];
        foreach ($units as $key => $unit) {
            foreach ($type == 'choice' ? $unit->getPositionedChoice() : $unit->getPositionedResult() as $key => $placement) {
                array_push($aa, [$placement->employee?->getNameAttribute(), $unit->name, $placement->employee?->position?->name, $placement->choiceOne?->name, $placement->choiceTwo?->name]);
            }
        }
        return $aa;
    }   
}