<?php

namespace App\Http\Controllers\Admin;

use App\Constants;
use App\Http\Requests\EmployeeAddressRequest;
use App\Http\Requests\EmployeeRequest;
use App\Models\Demotion;
use App\Models\EducationalLevel;
use App\Models\Employee;
use App\Models\EmployeeAddress;
use App\Models\EmployeeCategory;
use App\Models\EmployeeCertificate;
use App\Models\EmployeeContact;
use App\Models\EmployeeEvaluation;
use App\Models\EvaluationCategory;
use App\Models\EvaluationLevel;
use App\Models\TypeOfLeave;
use App\Models\EmployeeFamily;
use App\Models\EmployeeLanguage;
use App\Models\EmployeeTitle;
use App\Models\EmploymentStatus;
use App\Models\EmploymentType;
use App\Models\Evaluation;
use App\Models\EvaluationPeriod;
use App\Models\EvalutionCreteria;
use App\Models\Quarter;
use App\Models\ExternalExperience;
use App\Models\FieldOfStudy;
use App\Models\FormStyle;
use App\Models\InternalExperience;
use App\Models\JobGrade;
use App\Models\JobTitle;
use App\Models\Template;
//use PDF;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Models\Leave;
use App\Models\Level;
use App\Models\License;
use App\Models\LicenseType;
use App\Models\MaritalStatus;
use App\Models\EmployementStatus;
use App\Models\Misconduct;
use App\Models\Nationality;
use App\Models\Pension;
use App\Models\Position;
use App\Models\PositionCode;
use App\Models\EducationLevel;
use App\Models\Promotion;
use App\Models\SalaryIncreament;
use App\Models\Skill;
use App\Models\TemplateType;
use App\Models\TrainingAndStudy;
use App\Models\TypeOfMisconduct;
use Illuminate\Http\Request;

use App\Models\Unit;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Prologue\Alerts\Facades\Alert;
use \Onkbear\NestedCrud\app\Http\Controllers\Operations\NestedListOperation;
use \Onkbear\NestedCrud\app\Http\Controllers\Operations\NestedCreateOperation;
use \Onkbear\NestedCrud\app\Http\Controllers\Operations\NestedUpdateOperation;
use \Onkbear\NestedCrud\app\Http\Controllers\Operations\NestedDeleteOperation;
use \Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;
use DateTime;
use NumberFormatter;
use Illuminate\Support\Facades\DB;
use \Maatwebsite\Excel\Facades\Excel;
use App\Exports\EmployeeExport;
use App\Models\EmployeeEducation;
use App\Models\HrBranch;

/**
 * Class EmployeeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class EmployeeCrudController extends CrudController
{
    use \Backpack\ReviseOperation\ReviseOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;


    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\InlineCreateOperation;
    

    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation {
        update as traitUpdate;
    } //IMPORTANT HERE
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use FetchOperation;
   // use \Backpack\CRUD\app\Http\Controllers\Operations\BulkDeleteOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(Employee::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/employee');
        CRUD::setEntityNameStrings('employee', 'employees');

        CRUD::disablePersistentTable();
        CRUD::enableExportButtons();
        //CRUD::setDefaultPageLength(10); // No of paginatings

        $this->crud->setShowView('employee.show');
        // $this->crud->enableAjaxTable()  ;
        $this->crud->enableDetailsRow();
        $this->setupPermission();


       
    }
    public function setupPermission()
    {
        $permission_base = 'employee';
        if (!backpack_user()->can($permission_base . '.icrud')) {
            $explodedRoute = explode('/', $this->crud->getRequest()->getRequestUri());
            if (in_array('show', $explodedRoute)) {
                if (!backpack_user()->can($permission_base . '.show')) {
                    return abort(401);
                }
            }
            if (in_array('create', $explodedRoute)) {
                if (!backpack_user()->can($permission_base . '.create')) {
                    return abort(401);
                }
            }
            if (in_array('edit', $explodedRoute)) {
                if (!backpack_user()->can($permission_base . '.edit')) {
                    return abort(401);
                }
            }
            if (in_array('delete', $explodedRoute)) {
                if (!backpack_user()->can($permission_base . '.delete')) {
                    return abort(401);
                }
            }
            if ($explodedRoute[count($explodedRoute) - 1] == $this->crud->entity_name && !backpack_user()->can($permission_base . '.index')) {
                return abort(401);
            }
            if (!backpack_user()->can($permission_base . '.create')) {
                $this->crud->denyAccess('create');
            }

            if (!backpack_user()->can($permission_base . '.show')) {
                $this->crud->denyAccess('show');
            }

            if (!backpack_user()->can($permission_base . '.edit')) {
                $this->crud->denyAccess('update');
            }

            if (!backpack_user()->can($permission_base . '.delete')) {
                $this->crud->denyAccess('delete');
            }
        }
    }

    public function getEffiency($employe_id)
    {
        $efficnecies = Evaluation::select('total_mark')->where('employee_id', $employe_id)->where('quarter_id', 1)->pluck('total_mark')->toArray();
        $sum = array_sum($efficnecies);
        if ($sum  == null) {
            $result = 0;
        } else {
            $result = $sum;
        }
        return $result;
    }
    
    
    public function showDetailsRow($id)
    {
        $this->crud->hasAccessOrFail('details_row');
        $id = $this->crud->getCurrentEntryId() ?? $id;
        $this->data['entry'] = $this->crud->getEntry($id);
        $this->data['crud'] = $this->crud;
        // return view($this->crud->getDetailsRowView(), $this->data);
        return view('crud::details_row', $this->data);
    }

    //////////////////////////////////// get Last 3 average effiency /////////////////
    //$efficnecies = Evaluation::where('employee_id' ,$employe_id)->where('quarter_id','=',1)->get()->toArray();
 
    ////////////////////////////////////////////////////////////////////////
    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->enableDetailsRow();
        //$this->crud->allowAccess('details_row');
        $this->crud->setDetailsRowView('details_row');
        $this->crud->disablePersistentTable();
       // $this->crud->setOperationSetting('persistentTableDuration', 60); //for 1 hours persistency.
       // $this->crud->denyAccess('delete');
        //   $this->crud->addButtonFromModelFunction('line', 'print_id', 'printID', 'end');


        CRUD::column('photo')->type('image')->label('Photo');
    
          $this->crud->addColumn([
            'name'        => 'name',
            'label'       => 'FirstName',
            'searchLogic' => function ($query, $column, $searchTerm) {
                $query->orWhere('first_name', 'like', '%' . $searchTerm . '%');
                $query->orWhere('father_name', 'like', '%' . $searchTerm . '%');
                $query->orWhere('grand_father_name', 'like', '%' . $searchTerm . '%');
                $query->orWhere('email', 'like', '%' .$searchTerm. '%');
                $query->orWhere('pention_number', 'like', '%' . $searchTerm . '%');
              
                $query->orWhere('position_id', 'like', '%' . $searchTerm . '%');
                $query->orWhere('date_of_birth', 'like', '%' . $searchTerm . '%');
                $query->orWhere(DB::raw("CONCAT_WS(' ', first_name, father_name, grand_father_name)"), 'like', '%' .$searchTerm. '%');
                if (is_numeric($searchTerm) && $searchTerm <= 70 && $searchTerm >= 18) {
                    $currentYear = date('Y');
                    $birthYear = $currentYear - (int)$searchTerm;
                    $sql = "YEAR(date_of_birth) = ?";
                    \Log::info("Generated SQL: $sql with parameter $birthYear");
                    $query->orWhereRaw($sql, [$birthYear]);
                }
                else{
                    $query->orWhere('phone_number', 'like', '%' . $searchTerm . '%');
                }
            }
        ]);



        
      
        CRUD::column('name')->label('የሰራተኛዉ ሙሉ ስም')->type('closure')->function(function ($entry) {
            return $entry->first_name . ' ' . $entry->father_name . ' ' . $entry->grand_father_name;
        });
      
        
        CRUD::column('position.name')->label('የስራ መደብ')->type('select')->entity('position')->model(Position::class);
        CRUD::column('position.unit.name')->label('የስራ ክፍል')->type('select')->entity('position.unit')->model(Unit::class);
        CRUD::column('hr_branch_id')->type('select')->label('ኮሌጅ/ኢንስቲዩት')->entity('hrBranch')->model(HrBranch::class)->attribute('name')->size(4);
        CRUD::column('phone_number')->label('ስልክ ቁጥር');

        CRUD::column('employee_category_id')->type('select')->label('የሰራተኛው አይነት')->entity('employeeCategory')->model(EmployeeCategory::class)->attribute('name')->size(4);
        // ->wrapper([
        //     'element' => 'span',
        //     'class' => function ($crud, $column, $entry) {
        //         switch ($entry->employee_category_id) {
        //             case '1':
        //                 return 'badge badge-pill badge-info';
        //             case '2':
        //                 return 'badge badge-pill badge-success';
        //             case '3':
        //                 return ' badge badge-pill badge-warning';
                
        //             default:
        //                 return 'badge badge-pill badge-defualt';
                      
        //         }
        //     }
        // ]);



        CRUD::column('date_of_birth')->type('closure')->function(function($entry){
            return $entry->age()?? '-';})->label('ዕድሜ')->wrapper([
                'element' => 'span',
                'title'=>'Employee age in years',
                'class' => function ($crud, $column, $entry) {
                    switch ($entry->age()) {
                        case '61':
                            return 'badge badge-pill badge-success border';
                        case '60':
                            return 'badge badge-pill badge-danger border';
                        case '59':
                            return ' badge badge-pill badge-warning border';
                        case '58':
                            return ' badge badge-pill badge-warning border';
    
                        default:
                            return 'badge badge-pill badge-defualt border';
                          
                    }
                }
            ]);
            
        CRUD::column('position_id')->label('የስራ መደቡ መለያ')->type('select')->entity('PositionCode')->model(PositionCode::class)->attribute('code');
       

        CRUD::column('birth_city')->label('Place of birth');
        CRUD::column('employmeent_identity')->label('Employee ID');
       // CRUD::column('employee_title_id')->label('Title');



        CRUD::column('educational_level_id')->type('select')->label('Educational Level')->entity('educationLevel')->model(EducationalLevel::class)->attribute('name');
      
        CRUD::column('marital_status_id')->type('select')->label('Marital Status')->entity('maritalStatus')->model(MaritalStatus::class)->attribute('name');

        CRUD::column('ethnicity_id')->label('Ethnicity');
        CRUD::column('religion_id')->label('Religion');
    

        CRUD::column('field_of_study_id')->type('select')->label('Field of study')->entity('fieldOfStudy')->model(FieldOfStudy::class)->attribute('name');



        CRUD::column('employement_date')->label('Employment date')->display(function($date) {
            return Carbon::parse($date)->format('Y-m-d');
        });

   
        CRUD::column('employment_type_id')->type('select')->label('Employment type')->entity('employmentType')->model(EmploymentType::class)->attribute('name');

        CRUD::column('pention_number')->label('Pension number');
       // CRUD::column('hr_branch_id')->label('College/Institue');
       
        CRUD::column('employment_status_id')->type('select')->label('Current status')->entity('employmentStatus')->model(EmploymentStatus::class)->attribute('name');

        CRUD::column('nationality_id')->label('Nationality');
        CRUD::column('gender')->label('Gender');
        CRUD::column('email')->label('Email'); 
        CRUD::column('national_id')->label('National ID');
        CRUD::column('cbe_account')->label('CBE Account');
      
        
        $this->crud->addFilter(
            [
                'type'  => 'select2',
                'name'  => 'employee_category_id',
                'label' => 'By Employee Type'
            ],
            function () {
                return EmployeeCategory::all()->pluck('name', 'id')->toArray();
            },
            function ($value) { 
                $this->crud->addClause('where', 'employee_category_id', $value);
              
            }
        );

        $this->crud->addFilter([
            'name'  => 'hr_branch_id',
            'type'  => 'select2',
            'label' => 'Filter by College/Institue'
        ], function () {
            return HrBranch::all()->pluck('name', 'id')->toArray();

        }, function ($values) {
            $this->crud->addClause('where', 'hr_branch_id', json_decode($values));
        });



        $this->crud->addFilter(
            [
                'type' => 'select2',
                'name' => 'job_title_id',
                'label' => 'Filtter by Job title'
            ],
            function () {
                return JobTitle::all()->pluck('name', 'id')->toArray();
            },
            function ($value) { // if the filter is active, apply these constraints
                $jobTitle = JobTitle::find($value);
                $positions = Position::where('job_title_id', $jobTitle->id)->pluck('id');
                $this->crud->addClause('whereIn', 'position_id', $positions);
            }
        );


        $this->crud->addFilter([
            'name'  => 'employment_type_id',
            'type'  => 'select2_multiple',
            'label' => 'Filter by Employment type'
        ], function () {
            return EmploymentType::all()->pluck('name', 'id')->toArray();
        }, function ($values) {
            $this->crud->addClause('where', 'employment_type_id', json_decode($values));
        });

  /////////////////////////////////////////////////////////////
        CRUD::filter('genders')
        ->type('select2')->label('Filter by Gender')
        ->values(function () {
          return [
            'Male' => 'Male',
            'Female' => 'Female',
        
          ];
        })
        ->whenActive(function($value) {
           CRUD::addClause('where', 'gender', $value);
        });

////////////////////////////////////////////////////////

        $this->crud->addFilter(
            [
                'type'  => 'date_range',
                'name'  => 'employement_date',
                'label' => 'By hire date '
            ],
            false,
            function ($value) { // if the filter is active, apply these constraints
                $dates = json_decode($value);
                $this->crud->addClause('whereBetween', 'employement_date', [$dates->from, $dates->to]);
            }
        );
    }



    public function exportEmployees(Request $request)
    {
        $category = $request->input('category');
        $office = $request->input('office');
    
        $query = Employee::query();
        if ($category) {
            $query->where('employee_category_id', $category);
        }
        if ($office) {
            $query->where('hr_branch_id', $office);
        }
    
        $employees = $query->get();
    
        return Excel::download(new \EmployeeExport($employees), 'employees.xlsx');
    }
  

public function showExportForm()
{
    return view('export');
}

    public function getEmployee($hr_branch_id)
    {
         $employees = Employee::where('hr_branch_id', '=', $hr_branch_id)->paginate(15);
      //  $name = DB::table('hr_branches')->where('id', $hr_branch_id)->pluck('name');
         $name = DB::table('hr_branches')->where('id', $hr_branch_id)->select('name')->first()->name;



            $categories = EmployeeCategory::withCount([
            'employees as male_category_count' => function ($query) use ($hr_branch_id) { $query->where('gender', 'Male')->where('hr_branch_id',  $hr_branch_id);
             },
            'employees as female_category_count' => function ($query) use ($hr_branch_id) { $query->where('gender', 'Female')->where('hr_branch_id', $hr_branch_id);},

           ])->get();


           $employmentStatuses = EmploymentStatus::withCount([
            'employees as male_status_count' => function ($query) use ($hr_branch_id) { $query->where('gender', 'Male')->where('hr_branch_id',  $hr_branch_id);
             },
            'employees as female_status_count' => function ($query) use ($hr_branch_id) { $query->where('gender', 'Female')->where('hr_branch_id', $hr_branch_id);},

           ])->get();




           $branches = HrBranch::withCount([
            'employees as male_hr_count' => function ($query) {
                $query->where('gender', 'Male');
            },
            'employees as female_hr_count' => function ($query) {
                $query->where('gender', 'Female');
            },
        ])->get();
        



            $employements = EmploymentType::withCount([
            'employees as type_male_count' => function ($query) use ($hr_branch_id) { $query->where('gender', 'Male')->where('hr_branch_id',  $hr_branch_id);
             },
            'employees as type_female_count' => function ($query) use ($hr_branch_id) { $query->where('gender', 'Female')->where('hr_branch_id', $hr_branch_id);},

           ])->get();


            $educations = EducationalLevel::withCount([
         
            'employees as male_count' => function ($query) use ($hr_branch_id) { $query->where('gender', 'Male')->where('hr_branch_id', $hr_branch_id);
            },
            'employees as female_count' => function ($query) use ($hr_branch_id) { $query->where('gender', 'Female')->where('hr_branch_id', $hr_branch_id);},

        
       

            'employees as female_left_count' => function ($query) use ($hr_branch_id) {
                $query->where('gender', 'Female')
                      ->where(function ($query) {
                          $query->where('employment_type_id', 11)
                                ->orWhere('employment_type_id', 7)
                                ->orWhere('employment_type_id', 6); // Add more conditions as needed
                      })
                      ->where('hr_branch_id', $hr_branch_id);
            },


            'employees as male_left_count' => function ($query) use ($hr_branch_id) {
                $query->where('gender', 'Male')
                      ->where(function ($query) {
                          $query->where('employment_type_id', 11)
                                ->orWhere('employment_type_id', 7)
                                ->orWhere('employment_type_id', 6); // Add more conditions as needed
                      })
                      ->where('hr_branch_id', $hr_branch_id);
            },



            ])->get();
          $males    = Employee::where('gender','=', 'Male')->where('hr_branch_id', '=', $hr_branch_id)->count();
          $females  = Employee::where('gender','=', 'Female')->where('hr_branch_id', '=', $hr_branch_id)->count();

         $total = Employee::where('hr_branch_id', '=', $hr_branch_id)->count();
      

        return view('employee.employee_list', compact(['employees','educations',
        'employmentStatuses','categories','employements','branches','total','females','males'],'name'));
    }

    public function  getEmployeeID()
    {
        $uniqueNumber = rand(10000, 99999);
        $currentYear = date('Y');
        $srudentID = $uniqueNumber . '' . $currentYear;

        return  $srudentID;
    }

    /**
     *
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(EmployeeRequest::class);
        $this->crud->setCreateContentClass('col-md-12');
        $this->crud->enableTabs();
        //$this->crud->enableVerticalTabs();
        $this->crud->enableHorizontalTabs();
        ////////////////////// Tabs //////////////////////
        $pi       = '[1] Personal Information';
        $ci       = '[4] Contact Information';
        $bio      = '[3] Bio Information';
        $address  = '[4] Address Information';
        $job      = '[2] Job Information';
        $edu      = '[6] Employee Credentials';
        $other    = '[7] Other Information';

        ////////////////////////////////////////////////
        CRUD::field('photo')->label('Employee photo(4x4)')->size(8)->type('image')->aspect_ratio(1)->crop(true)->upload(true)->tab($pi);
        CRUD::field('first_name')->size(6)->tab($pi)->ajax(true);
        CRUD::field('father_name')->size(6)->tab($pi)->ajax(true);
        CRUD::field('grand_father_name')->size(6)->tab($pi)->ajax(true);
        CRUD::field('first_name_am')->label('የመጀመሪያ ስም')->size(6)->tab($pi);
        CRUD::field('father_name_am')->label('የአባት ስም')->size(6)->tab($pi);
        CRUD::field('grand_father_name_am')->label('የአያት ስም')->size(6)->tab($pi);
        CRUD::field('gender')->type('enum')->size(6)->tab($pi);
        CRUD::field('religion_id')->size(6)->tab($pi);
        CRUD::field('employee_title_id')->label('Employee title')->type('select2')->entity('employeeTitle')->model(EmployeeTitle::class)->attribute('title')->size(6)->tab($pi);
        CRUD::field('position_id')->label('Job Position')->type('select2')->entity('position')->model(Position::class)->attribute('position_info')->size(6)->tab($job);

        CRUD::field('employment_type_id')->type('select2')->entity('employmentType')->model(EmploymentType::class)->attribute('name')->size(6)->tab($job);
        CRUD::field('educational_level_id')->type('select2')->entity('educationalLevel')->model(EducationalLevel::class)->attribute('name')->size(6)->tab($job);

        CRUD::field('employmeent_identity')->type('hidden')->value($this->getEmployeeID());
        CRUD::field('employment_type_id')->type('select2')->entity('employmentType')->model(EmploymentType::class)->attribute('name')->size(6)->tab($job);
        CRUD::field('field_of_study_id')->type('select2')->label('Field od study')->entity('fieldOfStudy')->model(FieldOfStudy::class)->attribute('name')->size(6)->tab($job);
        CRUD::field('birth_city')->size(6)->label('Place of birth')->tab($bio);
        CRUD::field('date_of_birth')->size(6)->tab($bio);
        CRUD::field('blood_group')->type('enum')->size(6)->tab($bio);
        CRUD::field('eye_color')->type('enum')->size(6)->tab($bio);
        CRUD::field('marital_status_id')->type('select2')->entity('maritalStatus')->model(MaritalStatus::class)->attribute('name')->size(6)->tab($bio);
         CRUD::field('ethnicity_id')->size(6)->tab($bio);
         CRUD::field('email')->type('email')->label('Email Address')->size(6)->tab($ci);
         CRUD::field('phone_number')->size(6)->tab($ci);
         CRUD::field('national_id')->label('National ID')->size(6)->tab($ci);
         CRUD::field('cbe_account')->label('CBE Account')->size(6)->tab($ci);
        
        //CRUD::field('uas_user_id')->tab($ci)->size(3);
         CRUD::field('employment_status_id')->label('Current status')->size(6)->tab($job);
         CRUD::field('horizontal_level')->type('enum')->label('Horizontal Level')->size(6)->tab($job);
         CRUD::field('employment_status_id')->type('select2')->label('Current status')->entity('employmentStatus')->model(EmploymentStatus::class)->attribute('name')->size(6)->tab($job);
         CRUD::field('employement_date')->size(6)->tab($job);
         CRUD::field('pention_number')->label('Pension number')->size(6)->tab($job);
         CRUD::field('nationality_id')->type('select2')->label('Nationality')->entity('nationality')->model(Nationality::class)->attribute('nation')->size(6)->tab($bio);
        // CRUD::field('rfid')->size(4)->type('number')->tab($other);
        CRUD::field('hr_branch_id')->type('select2')->label('HR Office')->entity('hrBranch')->model(HrBranch::class)->attribute('name')->size(6)->tab($job);
        // CRUD::field('rfid')->size(4)->type('number')->tab($other);
        // CRUD::field('pention_number')->type('number')->size(6)->tab($other);

        CRUD::field('employee_category_id')->type('select2')->entity('employmentCategory')->model(EmployeeCategory::class)->attribute('name')->size(6)->tab($job);
        // CRUD::field('rfid')->size(4)->type('number')->tab($other);
        // CRUD::field('pention_number')->type('number')->size(6)->tab($other);
    
    }

    //sCRUD::field('price')->type('number')->label('Price')->prefix('$')->suffix('.00');

    public function store()
    {
        $this->crud->hasAccessOrFail('create');

        // execute the FormRequest authorization and validation, if one is required
        $request = $this->crud->validateRequest();
        $data = $this->crud->getStrippedSaveRequest();
        if (PositionCode::where('position_id', $data['position_id'])->where('employee_id', null)->count() == 0) {
            throw ValidationException::withMessages(['position_id' => 'No available place on this position!']);
        }
        // insert item in the db
        $item = $this->crud->create($data);
        $this->data['entry'] = $this->crud->entry = $item;
        PositionCode::where('position_id', $data['position_id'])->where('employee_id', null)->first()->update(['employee_id' => $item->id]);
        // show a success message
        \Alert::success(trans('backpack::crud.insert_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();
        return $this->crud->performSaveAction($item->getKey());
    }
    public function createPDF(Employee $employee_id)
    {
        $body1  = Template::select('body')->where('template_type_id', '=', TemplateType::where('name', Constants::PROBATION_HIRE_LETTER)->first()?->id)->first()->body;

        $level_id  =    Employee::where('id', $employee_id->id)->first()->position->jobTitle->level_id;

        $body2  = str_replace("\xc2\xa0", ' ', $body1);
        $position =   $employee_id->position->name;
        $unit =     $employee_id->position->unit->name;
        $edate =    $employee_id->employement_date->format('l, d F, Y');
        $etype =    $employee_id->employment_type;
        $vdate =    date('d F, Y');
        $exdate =   date('d F, Y');
        $intDate =   date('d F, Y');
        $tmark =    '0';
        $digit = new NumberFormatter("am", NumberFormatter::SPELLOUT);
        $startSalary = JobGrade::where('level_id',  $level_id)->first()?->start_salary;
        $levelname =   $employee_id->position->jobTitle->level->name;
        $code =   PositionCode::where('id', $employee_id->position->id)->first()?->code;
        $old   = ["%unit%", "%posotion%", "%employementType%", "%vacancyDate%", "%examDate%", "%interviewDate%", "%totalmark%", "%employementType%", "%jobLevel%", "%jobCode%", "%position%", "%salary%", "%hireDate%", "%salary_text%"];
        $new   = [$unit, $position, $etype, $vdate, $exdate, $intDate, $tmark, $etype, $levelname, $code, $position, $startSalary, $edate, $digit->format($startSalary)];

        $body  =   str_replace($old, $new, $body2);
        $employee = Employee::where('id', $employee_id->id)->get()?->first();
        if ($employee) {

            $pdf = PDF::loadView('employee.hire_pdf', compact('body', 'employee'))->setPaper('A4', 'portrait');
            return $pdf->stream('hire' . $employee_id->firt_name . ' ' . $employee_id->father_name . '.pdf');
        } else {
            return redirect()->route('employee.index')->with('message', 'Sorry unable to print');
        }
    }

///////////////////////////////////////////////////////////////////////
    public function checkProbation()
    {
    
         $males = DB::table('employees')->where('gender','Male')->count();
         $females = DB::table('employees')->where('gender','Female')->count();

         $permanets = DB::table('employees')->where('employment_type_id',1)->count();
         $contracts = DB::table('employees')->where('employment_type_id',2)->count();

          $employees = Employee::where('employment_type_id', 3)->orderBy('id', 'desc')->Paginate(10);


        return view('employee.probation', compact('employees','females','males','permanets','contracts'));


    }


//      public function ageToDay(){


     
//         $bday = new DateTime('11.4. 1987');
//       // Your date of birth 
//         $today = new Datetime(date('m.d.y')); 
//         $diff = $today->diff($bday);
//         printf(' Your age : %d years, %d month, %d days', 
//         $diff->y, $diff->m, $diff->d);
      
// }

    public function checkRetirment()
    {

         $now =  Carbon::now();
         $notify = Pension::where('id',  1)->first()->notify;
         $males = DB::table('employees')->where('gender','Male')->count();
         $females = DB::table('employees')->where('gender','Female')->count();
         $permanets = DB::table('employees')->where('employment_type_id',1)->count();
         $contracts = DB::table('employees')->where('employment_type_id',2)->count();
         $emps = Employee::all();

         foreach ($emps  as $employee ) {
             $diff_ind_days =  $now->diff($employee->date_of_birth);

            if ($diff_ind_days->d <= $notify ){

            $employees = Employee::where('id', $employee->id)->orderBy('id', 'desc')->Paginate(10);
          //  dd($employees);

        }
    }
   
        return view('employee.retirment', compact('employees','females','males','permanets','contracts'));
    
}

public function importEmployee(Request $request){


    $file = $request->input('file');
    // dd($request);
   
    Excel::import(new EmployeesImport, $request->file('file')->store('files'));
    return redirect()->back();

   // return back()->with('success', 'Your CSV file has been uploaded');

}
// public function exportUsers(Request $request){
//     return Excel::download(new EmployeesExport, 'employees.xlsx');
// }
   /////////////////////////////////////////////////////////////////////////////// 
    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupReorderOperation()
    {
        // define which model attribute will be shown on draggable elements
        CRUD::set('reorder.label', 'name');
        // define how deep the admin is allowed to nest the items
        // for infinite levels, set it to 0
        CRUD::set('reorder.max_level', 2);
    }

     protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
        // unique:employees,phone_number,
        //     $this->crud->enableTabs();
        //     // $this->crud->enableVerticalTabs();
        //     $this->crud->enableHorizontalTabs();
        //     $pi      = 'Personal Information';
        //     $ci      = 'Contact Information';
        //     $bio     = 'Bio Information';
        //     $address = 'Address Information';
        //     $job     = 'Job Information';
        //     $edu     = 'Employee Credentials';
        //     CRUD::field('photo')->label('Employee photo(4x4)')->size(6)->type('image')->aspect_ratio(1)->crop(true)->upload(true)->tab($pi);
        //     CRUD::field('first_name')->size(6)->tab($pi);
        //     CRUD::field('father_name')->size(6)->tab($pi);
        //     CRUD::field('grand_father_name')->size(6)->tab($pi);
        //     CRUD::field('first_name_am')->label('የመጀመሪያ ስም')->size(6)->tab($pi);
        //     CRUD::field('father_name_am')->label('የአባት ስም')->size(6)->tab($pi);
        //     CRUD::field('grand_father_name_am')->label('የአያት ስም')->size(6)->tab($pi);
        //     CRUD::field('gender')->type('enum')->size(6)->tab($pi);
        //     CRUD::field('date_of_birth')->size(6)->tab($pi);
        //     CRUD::field('birth_city')->size(6)->label('Place of birth')->tab($pi);
        //     CRUD::field('passport')->size(6)->type('upload')->upload(true)->tab($edu);
        //     CRUD::field('driving_licence')->size(6)->type('upload')->upload(true)->tab($edu);
        // CRUD::field('uas_user_id')->tab($edu)->size(3);
        //     CRUD::field('blood_group')->type('enum')->size(6)->tab($bio);
        //     CRUD::field('eye_color')->type('enum')->size(6)->tab($bio);
        //     CRUD::field('marital_status_id')->type('select2')->entity('maritalStatus')->model(MaritalStatus::class)->attribute('name')->size(6)->tab($bio);
        //     CRUD::field('ethnicity_id')->size(6)->tab($bio);
        //     CRUD::field('phone_number')->size(6)->tab($ci);
        //     CRUD::field('email')->type('email')->size(6)->tab($ci);
        //     // CRUD::field('rfid')->size(4);
        //     CRUD::field('employment_identity')->label('Employee ID Number')->size(6)->tab($ci);
        //     CRUD::field('religion_id')->size(6)->tab($address);
        //   //  CRUD::field('religion_id')->type('select2')->label('religion')->entity('')->model(FieldOfStudy::class)->attribute('name')->size(6)->tab($address);
        //     CRUD::field('field_of_study_id')->type('select2')->label('Field od study')->entity('fieldOfStudy')->model(FieldOfStudy::class)->attribute('name')->size(6)->tab($job);
        //     CRUD::field('employement_date')->size(6)->tab($job);

        //     CRUD::field('employee_category_id')->type('select2')->entity('employeeCategory')->model(EmployeeCategory::class)->attribute('name')->size(6)->tab($job);
        //     CRUD::field('nationality_id')->type('select2')->label('Nationality')->entity('nationality')->model(Nationality::class)->attribute('nation')->size(6)->tab($address);
        //     CRUD::field('level_id')->type('select2')->label('Job grade')->entity('level')->model(Level::class)->attribute('name')->size(6)->tab($job);
        //    // CRUD::field('job_title_id')->type('select2')->entity('jobTitle')->model(JobTitle::class)->attribute('name')->size(6)->tab($job);
        //     CRUD::field('position_id')->label('Job Position')->type('select2')->entity('position')->model(Position::class)->attribute('position_info')->size(6)->tab($job);
        //     CRUD::field('employment_type_id')->type('select2')->entity('employmentType')->model(EmploymentType::class)->attribute('name')->size(6)->tab($job);


    }

    public function update()
    {
        $items = collect(json_decode(request('employeeAddresses'), true));
        // $employeeAddressRequest = new EmployeeAddressRequest();
        // $employeeAddressRules = $employeeAddressRequest->rules();
        $response = $this->traitUpdate();
        $employee_id = $this->crud->entry->id;
        $created_ids = [];
        $currentPosition = $this->crud->getCurrentEntry()->position;
        $newPosition = Position::where('id', request()->position_id)->first();
        $employee = $this->crud->getCurrentEntry();
        if ($newPosition !== null) {
        if ($currentPosition->id == $newPosition->id ) {
            if (PositionCode::where('position_id', request()->position_id)->where('employee_id', $employee->id)->count() == 0) {
                PositionCode::where('employee_id', $employee->id)->first()?->update(['employee_id' => null]);

                if (PositionCode::where('position_id', request()->position_id)->where('employee_id', null)->count() == 0) {
                    throw ValidationException::withMessages(['position_id' => 'No available place on this position!']);
                } 
                else {
                    PositionCode::where('position_id', request()->position_id)->where('employee_id', null)->first()->update(['employee_id' => $employee->id]);
                }
            }
        } 
    

        else {


            if (PositionCode::where('position_id', request()->position_id)->where('employee_id', null)->count() == 0) {
                throw ValidationException::withMessages(['position_id' => 'No available place on this position!']);
            }
            PositionCode::where('employee_id', $this->crud->getCurrentEntry()->id)->first()->update(['employee_id' => null]);

            PositionCode::where('position_id', request()->position_id)->where('employee_id', null)->first()->update(['employee_id' => $employee->id]);
        }
    }  // the end of null check if null of new position
       
        $items->each(function ($item, $key) use ($employee_id, &$created_ids) {
            $item['employee_id'] = $employee_id;
            if ($item['id']) {
                $comment = EmployeeAddress::find($item['id']);
                $comment->update($item);
            } else {

                $created_ids[] = EmployeeAddress::create($item)->id;
            }
        });
        $related_items_in_request = collect(array_merge($items->where('id', '!=', '')->pluck('id')->toArray(), $created_ids));
        $related_items_in_db = $this->crud->entry->addresses;

        $related_items_in_db?->each(function ($item, $key) use ($related_items_in_request) {
            if (!$related_items_in_request->contains($item['id'])) {
                $item->delete();
            }
        });

        return $response;
    }

    protected function setupShowOperation()
    {
        $employeeId = $this->crud->getCurrentEntryId();
        $licenses = License::where('employee_id', $this->crud->getCurrentEntryId())->paginate(10);
        $this->data['employeeLicenses'] = $licenses;
        $employeeAddresses = EmployeeAddress::where('employee_id', $this->crud->getCurrentEntryId())->paginate(10);
        $this->data['employeeAddresses'] = $employeeAddresses;
        $employeeCertificates = EmployeeCertificate::where('employee_id', $employeeId)->orderBy('id', 'desc')->Paginate(10);
        $this->data['employeeCertificates'] = $employeeCertificates;

        $employeeContacts = EmployeeContact::where('employee_id', $employeeId)->orderBy('id', 'desc')->Paginate(10);
        $this->data['employeeContacts'] = $employeeContacts;

        $employeeLanguages = EmployeeLanguage::where('employee_id', $employeeId)->orderBy('id', 'desc')->Paginate(10);
        $this->data['employeeLanguages'] = $employeeLanguages;
        $employeeFamilies = EmployeeFamily::where('employee_id', $employeeId)->orderBy('id', 'desc')->Paginate(10);
        $this->data['employeeFamilies'] = $employeeFamilies;
        $internalExperiences = InternalExperience::where('employee_id', $employeeId)->orderBy('id', 'desc')->Paginate(10);
        $this->data['internalExperiences'] = $internalExperiences;

        $employeeEducations = EmployeeEducation::where('employee_id', $employeeId)->orderBy('id', 'desc')->Paginate(10);
        $this->data['employeeEducations'] = $employeeEducations;


        $evaluations = Evaluation::where('employee_id', $employeeId)->orderBy('id', 'desc')->Paginate(10);
        $this->data['evaluations'] = $evaluations;


        $externalExperiences = ExternalExperience::where('employee_id', $employeeId)->orderBy('id', 'desc')->Paginate(10);
        $this->data['externalExperiences'] = $externalExperiences;
        
        $trainingAndStudies = TrainingAndStudy::where('employee_id', $employeeId)->orderBy('id', 'desc')->Paginate(10);
        $this->data['trainingAndStudies'] = $trainingAndStudies;

        $employeeSkills = Skill::where('employee_id', $employeeId)->paginate(10);
        $this->data['employeeSkills'] = $employeeSkills;
        $evalutionCreterias =  EvalutionCreteria::orderBy('id', 'desc')->Paginate(30);
        $this->data['evalutionCreterias'] = $evalutionCreterias;


        $mark  = Evaluation::select('total_mark')->where('employee_id', '=', $employeeId)->get()->first()?->total_mark;
        $this->data['mark'] = $mark;

        $evaluation_levels =  EvaluationLevel::orderBy('id', 'desc')->Paginate(10);
        $this->data['evaluation_levels'] = $evaluation_levels;


        $leaves =  Leave::where('employee_id', $employeeId)->orderBy('id', 'desc')->Paginate(1);
        $this->data['leaves'] = $leaves;

     

        $type_of_leaves =    TypeOfLeave::orderBy('id', 'desc')->Paginate(10);
        $this->data['type_of_leaves'] = $type_of_leaves;
        $this->data['employee.leave'] = $type_of_leaves;

        $misconducts =    Misconduct::where('employee_id', $employeeId)->orderBy('id', 'desc')->Paginate(10);
        $this->data['misconducts'] = $misconducts;

        $demotions =    Demotion::where('employee_id', $employeeId)->orderBy('id', 'desc')->Paginate(10);
        $this->data['demotions'] = $demotions;

        $promotions =    Promotion::where('employee_id', $employeeId)->orderBy('id', 'desc')->Paginate(10);
        $this->data['promotions'] = $promotions;

        $demotions =    Demotion::where('employee_id', $employeeId)->orderBy('id', 'desc')->Paginate(10);
        $this->data['demotions'] = $demotions;




        $dob  = Employee::select('date_of_birth')->where('id', '=', $employeeId)->get()->first()->date_of_birth;
        $dob_ex = explode("-", $dob);
        $age_diff = date_diff(date_create($dob), date_create('today'))->y;
        $year_of_retire = 68 - $age_diff;
        $end = date('Y', strtotime('+' . $year_of_retire . 'years'));
        $date_of_retire = $end . "-" . $dob_ex[1] . "-" . $dob_ex[2];
        if ($year_of_retire > 0) {
            $d = new DateTime($date_of_retire);
            $date_of_retire2 = $d->format('F d, Y H:i:s');
            $this->data['date_of_retire2'] = $date_of_retire2;
        }

        $edate   = Employee::select('employement_date')->where('id', '=', $employeeId)->get()->first()->employement_date;

        $end = date('Y-m-d', strtotime($edate . ' + 6 months'));

        if ($end >= new DateTime('now')) {

            $this->data['status'] = 'Yes';
        } else {
            $this->data['status'] = 'No';
        }


        $type_of_misconducts =    TypeOfMisconduct::orderBy('id', 'desc')->Paginate(10);
        $this->data['type_of_misconducts'] = $type_of_misconducts;

        $jobe_titles =    JobTitle::orderBy('id', 'desc')->Paginate(10);
        $this->data['jobe_titles'] = $jobe_titles;

        $units =    Unit::orderBy('id', 'desc')->Paginate(10);
        $this->data['units'] = $units;
        $quarters =    Quarter::orderBy('id', 'desc')->Paginate(4);
        $this->data['quarters'] = $quarters;
        ////////////////////////////////////////////////////////////////////
        $this->data['last_effiency'] =  $this->getEffiency($this->crud->getCurrentEntryId());


        ////////////////////////////////////////////////////////////////////

        $employeeEvaluations = EmployeeEvaluation::where('employee_id', $employeeId)->orderBy('id', 'desc')->Paginate(10);

        // $employeeEvaluations = EmployeeEvaluation::where('employee_id', $this->crud->getCurrentEntryId())->orderBy('id', 'desc')->Paginate(10);


        $this->data['employeeEvaluations'] = $employeeEvaluations;


        $evaluations = Evaluation::where('employee_id', $this->crud->getCurrentEntryId())->orderBy('id', 'desc')->Paginate(4);

        $this->data['evaluations'] = $evaluations;

        $si = SalaryIncreament::select('percentage')->get()->first()->percentage ?? 0;
        $this->data['si'] = $si;

        $style = FormStyle::select('name')->get()->first()->name ?? null;
        $this->data['style'] = $style;

        $ep = EvaluationPeriod::select('name')->get()->first()->name ?? '-';
        $this->data['ep'] = $ep;

        $ep = EvaluationPeriod::select('name')->get()->first()->name ?? '-';
        $this->data['ep'] = $ep;
        // $this->data['entry'] = $this->crud->getEntry($id);

        $levels =    Level::orderBy('id', 'asc')->Paginate(22);
        $this->data['levels'] = $levels;



// $columnName = DB::table('JobGrade')
//     ->where('your_column', $valueToSearch)->select(DB::raw('your_column AS column_name'))->value('column_name');

// if ($columnName) {
  
//     echo "Column name: " . $columnName;
// } else {
    
//     echo "Value not found in any column.";
// }


    $level  =    Employee::where('id', $employeeId)->first()?->position?->jobTitle?->level_id;
        //  dd($level);

          $startSalary  =    JobGrade::where('level_id', $level)->first()?->start_salary;
          $level_id  =    JobGrade::where('level_id', $level)->first()?->id;
        //  dd(  $level_id );
        $step  =    Employee::where('id', $employeeId)->first()?->horizontal_level;
      
        if($step =='Start')
            $this->data['startSalary'] = JobGrade::getValueByIdAndColumn($level_id, 'start_salary');
        elseif($step ==1) 
            $this->data['startSalary'] = JobGrade::getValueByIdAndColumn($level_id , 'one');
        elseif($step ==2)
            $this->data['startSalary'] = JobGrade::getValueByIdAndColumn($level_id , 'two');
        elseif($step ==3)
            $this->data['startSalary'] = JobGrade::getValueByIdAndColumn($level_id , 'three');
        elseif($step ==4)
            $this->data['startSalary'] = JobGrade::getValueByIdAndColumn($level_id , 'four');
        elseif($step ==5)
            $this->data['startSalary'] = JobGrade::getValueByIdAndColumn($level_id , 'five');
        elseif($step ==6)
            $this->data['startSalary'] = JobGrade::getValueByIdAndColumn($level_id , 'six');
        elseif($step ==7)
            $this->data['startSalary'] = JobGrade::getValueByIdAndColumn($level_id , 'seven');
        elseif($step ==8)
            $this->data['startSalary'] = JobGrade::getValueByIdAndColumn($level_id , 'eight');
        elseif($step ==9)
            $this->data['startSalary'] = JobGrade::getValueByIdAndColumn($level_id , 'nine'); 
        elseif($step ==null)
            $this->data['startSalary'] = JobGrade::getValueByIdAndColumn($level_id , 'start_salary'); 
        else
            $this->data['startSalary'] = JobGrade::getValueByIdAndColumn($level_id, 'ceil_salary');

        
        /////////// Laraevl count ////////////////////////
        //   $employee = Employee::where('id', '<=', 100)->get();
        //   $totalEmployee = $employee->count();

        //  $totalRows  = $this->crud->count();
        // $evs = Evaluation::where('employee_id',$this->crud->getCurrentEntryId())->limit(3)->get();
        // $evaluations = Evaluation::orderBy('id', 'desc')->limit(3)->get();
        // $this->data['evs'] = $evs;

        // Note: if you HAVEN'T set show.setFromDb to false, the removeColumn() calls won't work
        // because setFromDb() is called AFTER setupShowOperation(); we know this is not intuitive at all
        // and we plan to change behaviour in the next version; see this Github issue for more details
        // https://github.com/Laravel-Backpack/CRUD/issues/3108
    }
}
