<?php

namespace App\Http\Controllers;

use App\Events\RecordInsertionProgress;
use PDOException;
use App\Models\Unit;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Prologue\Alerts\Facades\Alert;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Route;

class SyncController extends Controller
{

  


    public function index()
    {
        $employees = Employee::all();
        return response()->json($employees);
    }
    ///// This method is for making a third-party API request.
    public function apiRequest()
    {
        $apiToken = config('app.API_TOKEN');
        $response = Http::get('https://hrm.ju.edu.et/api/employees', [
            'api_token' => $apiToken,
        ]);
        $employeeData = $response->json();

        if ($response->successful()) {

            return view('employee', ['employeeData' => $employeeData]);
        } else {

            return response()->json(['error' => 'Failed to retrieve employee data'], 500);
        }
    }

    # Address : https://hrm.ju.edu.et/api/employees  and   Token="NtksaZqkSwS77ilG1L8uxvnH9lK39yZCJQy38O2A"

    public function srsData(Request $request)
    {
        if ($request->input('syncdata')) {
            $this->employee();
            session()->flash('success', 'SRS Data Successfully Synchronized');
        }
        if ($request->input('syncphoto')) {
            shell_exec(config('photo_sync_script'));
            session()->flash('success', 'SRS Data Successfully Synchronized');
        }
        if ($request->input('syncStudent')) {
            $this->unit();
            session()->flash('success', 'SRS Data Successfully Synchronized' . $this->student());
        }

        $data = [];
        $data['campus'] = DB::table('campuses')->count();
        $data['religion'] = DB::table('religions')->count();
        $data['program'] = DB::table('programs')->count();
        $data['programLevel'] = DB::table('program_levels')->count();
        $data['programType'] = DB::table('program_types')->count();
        $data['enrollmentType'] = DB::table('enrollment_types')->count();
        $data['college'] = DB::table('colleges')->count();
        $data['department'] = DB::table('departments')->count();

        return view('srs_data.dashboard', compact('data'));
    }

    public function insert()
    {

        $hrm = DB::connection('mysql'); 
       
        $fields = ['id', 'first_name', 'father_name', 'grand_father_name', 'gender', 'date_of_birth', 'birth_city', 'phone_number', 'email', 'employmeent_identity', 'employee_title_id', 'educational_level_id', 'marital_status_id', 'religion_id', 'field_of_study_id', 'employement_date', 'position_id', 'employment_type_id', 'pention_number', 'employee_category_id'];
        $query = "SELECT " . implode(', ', $fields) . " FROM employees";
        $data = DB::connection('mysql')->select($query);

        // $totalRecords = count($data);
        // $currentRecord = 0;

        $targetTable = 'employees'; 
        foreach ($data as $value) {
            // Convert the result object to an associative array
            $value = (array) $value;
            try {
                $moh = DB::connection('mysql_MoH');
                $result = $moh->table($targetTable)->updateOrInsert(
                    ['employee_id' => $value['id']],
                    [
                        'first_name' => $value['first_name'],
                        'father_name' => $value['father_name'],
                        'grand_father_name' => $value['grand_father_name'],
                        'gender' => $value['gender'],
                        'date_of_birth' => $value['date_of_birth'],
                        'birth_city' => $value['birth_city'],
                        'phone_number' => $value['phone_number'],
                        'email' => $value['email'],
                        'employmeent_identity' => $value['employmeent_identity'],
                        'employee_title_id' => $value['employee_title_id'],
                        'educational_level_id' => $value['educational_level_id'],
                        'marital_status_id' => $value['marital_status_id'],
                        'religion_id' => $value['religion_id'],
                        'field_of_study_id' => $value['field_of_study_id'],
                        'employement_date' => $value['employement_date'],
                        'position_id' => $value['position_id'],
                        'employment_type_id' => $value['employment_type_id'],
                        'pention_number' => $value['pention_number'],
                        'employee_category_id' => $value['employee_category_id']
                    ]
                );

                // $currentRecord++;
                // // Calculate and send the progress percentage
                // $progress = ($currentRecord / $totalRecords) * 100;
                // event(new RecordInsertionProgress($progress));

            } catch (\Throwable $th) {
                dd($th->getMessage());
            }
        }
        if ($result) {
            Alert::success(trans('backpack::crud.insert_success'))->flash();
        }

        return redirect()->back();


    }
 
}
