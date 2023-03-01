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
use App\Models\Leave;
use App\Models\Level;
use App\Models\License;
use App\Models\LicenseType;
use App\Models\MaritalStatus;
use App\Models\Misconduct;
use App\Models\Nationality;
use App\Models\Position;
use App\Models\PositionCode;
use App\Models\Promotion;
use App\Models\SalaryIncreament;
use App\Models\Skill;
use App\Models\TrainingAndStudy;
use App\Models\TypeOfMisconduct;
use App\Models\Unit;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\Request;
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
    use \Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation {
        update as traitUpdate;
    } //IMPORTANT HERE
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;


    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Employee::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/employee');
        CRUD::setEntityNameStrings('employee', 'employees');
        $this->crud->setShowView('employee.show');
        // $this->crud->enableAjaxTable();
        $this->crud->enableDetailsRow();
        $this->setupPermission();
      //  $this->crud->enableExportButtons();
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
        $this->crud->allowAccess('details_row');
        $this->crud->setDetailsRowView('details_row');
        $this->crud->setOperationSetting('persistentTableDuration', 120); //for 2 hours persistency.
    //    $this->crud->denyAccess('delete');
        //   $this->crud->addButtonFromModelFunction('line', 'print_id', 'printID', 'end');

        CRUD::column('name')->label('Full Name')->type('closure')->function(function ($entry) {
            return $entry->first_name . ' ' . $entry->father_name . ' ' . $entry->grand_father_name;
        });
        CRUD::column('employment_identity')->label('ID Number');
        CRUD::column('position.name')->label('Job Title')->type('select')->entity('position')->model(Position::class);
        CRUD::column('position.unit.name')->label('Origanizational unit')->type('select')->entity('position.unit')->model(Unit::class);
        CRUD::column('employement_date')->type('date');
        $this->crud->addFilter(
            [
                'type'  => 'select2',
                'name'  => 'employee_category_id',
                'label' => 'By employee category '
            ],
            function () {
                return \App\Models\EmployeeCategory::all()->pluck('name', 'id')->toArray();
            },
            function ($value) { // if the filter is active, apply these constraints
                // $dates = json_decode($value);
                $this->crud->addClause('where', 'employee_category_id', $value);
                // $this->crud->addClause('where', ' employement_date ', '>=', $dates->from);
                // $this->crud->addClause('where', ' employement_date ', '<=', $dates->to . ' 23:59:59');
            }
        );
        $this->crud->addFilter(
            [
                'type' => 'select2',
                'name' => 'job_title_id',
                'label' => 'Job title '
            ],
            function () {
                return \App\Models\JobTitle::all()->pluck('name', 'id')->toArray();
            },
            function ($value) { // if the filter is active, apply these constraints
                $jobTitle = JobTitle::find($value);
                $positions = Position::where('job_title_id', $jobTitle->id)->pluck('id');
                $this->crud->addClause('whereIn', 'position_id', $positions);
            }
        );
        $this->crud->addFilter([
            'name' => 'unit_id',
            'type' => 'select2',
            'label' => 'Filter by office'
        ], function () {
            return \App\Models\Unit::all()->pluck('name', 'id')->toArray();
        }, function ($value) {
            $positions = Position::where('unit_id', $value)->pluck('id')->toArray();
            $this->crud->addClause('whereIn', 'position_id', ($positions));
        });
        $this->crud->addFilter([
            'name'  => 'employment_type_id',
            'type'  => 'select2_multiple',
            'label' => 'Filter by type'
        ], function () {
            return \App\Models\EmploymentType::all()->pluck('name', 'id')->toArray();
        }, function ($values) {
            $this->crud->addClause('whereIn', 'employment_type_id', json_decode($values));
        });
        $this->crud->addFilter([
            'name'  => 'position_id',
            'type'  => 'select2_multiple',
            'label' => 'By job position'
        ], function () {
            return \App\Models\Position::all()->pluck('name', 'id')->toArray();
        }, function ($values) {
            $this->crud->addClause('whereIn', 'position_id', json_decode($values));
        });
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


    public function  getEmployeeID(){
        $uniqueNumber= rand(10000,99999);
        $currentYear = date('Y');
        $srudentID = $uniqueNumber.''.$currentYear ;

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
        $pi       = 'Personal Information';
        $ci       = 'Contact Information';
        $bio      = 'Bio Information';
        $address  = 'Address Information';
        $job      = 'Job Information';
        $edu      = 'Employee Credentials';
        $other    = 'Other Information';

        ////////////////////////////////////////////////
        CRUD::field('photo')->label('Employee photo(4x4)')->size(8)->type('image')->aspect_ratio(1)->crop(true)->upload(true)->tab($pi);

        CRUD::field('first_name')->size(6)->tab($pi);
        CRUD::field('father_name')->size(6)->tab($pi);
        CRUD::field('grand_father_name')->size(6)->tab($pi);

        CRUD::field('first_name_am')->label('የመጀመሪያ ስም')->size(6)->tab($pi);
        CRUD::field('father_name_am')->label('የአባት ስም')->size(6)->tab($pi);
        CRUD::field('grand_father_name_am')->label('የአያት ስም')->size(6)->tab($pi);

        CRUD::field('gender')->type('enum')->size(6)->tab($pi);
        CRUD::field('religion_id')->size(6)->tab($pi);

        CRUD::field('employee_title_id')->label('Employee title')->type('select2')->entity('employeeTitle')->model(EmployeeTitle::class)->attribute('title')->size(6)->tab($pi);

        CRUD::field('position_id')->label('Job Position')->type('select2')->entity('position')->model(Position::class)->attribute('position_info')->size(6)->tab($job);
        // CRUD::field('level_id')->type('select2')->label('Job grade')->entity('level')->model(Level::class)->attribute('name')->size(6)->tab($job);
        // CRUD::field('job_title_id')->label('Job Position')->type('select2')->entity('jobTitle')->model(JobTitle::class)->attribute('name')->size(6)->tab($job);
        CRUD::field('employment_type_id')->type('select2')->entity('employmentType')->model(EmploymentType::class)->attribute('name')->size(6)->tab($job);
        CRUD::field('educational_level_id')->type('select2')->entity('educationalLevel')->model(EducationalLevel::class)->attribute('name')->size(6)->tab($job);

        CRUD::field('employment_identity')->type('hidden')->value($this->getEmployeeID());

        CRUD::field('employment_type_id')->type('select2')->entity('employmentType')->model(EmploymentType::class)->attribute('name')->size(6)->tab($job);
        CRUD::field('field_of_study_id')->type('select2')->label('Field od study')->entity('fieldOfStudy')->model(FieldOfStudy::class)->attribute('name')->size(6)->tab($job);
        CRUD::field('birth_city')->size(6)->label('Place of birth')->tab($bio);
        CRUD::field('date_of_birth')->size(6)->tab($bio);
        CRUD::field('blood_group')->type('enum')->size(6)->tab($bio);
        CRUD::field('eye_color')->type('enum')->size(6)->tab($bio);
        CRUD::field('marital_status_id')->type('select2')->entity('maritalStatus')->model(MaritalStatus::class)->attribute('name')->size(6)->tab($bio);
        CRUD::field('ethnicity_id')->size(6)->tab($bio);
        CRUD::field('email')->type('email')->size(6)->tab($ci);
        CRUD::field('phone_number')->size(6)->tab($ci);

        // CRUD::field('unit_id')->label('Organizational unit')->size(6)->tab($address);
        CRUD::field('employement_date')->size(6)->tab($job);
        CRUD::field('pention_number')->label('Pension number')->size(6)->tab($job);
        CRUD::field('nationality_id')->type('select2')->label('Nationality')->entity('nationality')->model(Nationality::class)->attribute('nation')->size(6)->tab($bio);
        // CRUD::field('rfid')->size(4)->type('number')->tab($other);
        // CRUD::field('pention_number')->type('number')->size(6)->tab($other);

        CRUD::field('employee_category_id')->type('select2')->entity('employmentCategory')->model(EmployeeCategory::class)->attribute('name')->size(6)->tab($job);
        // CRUD::field('rfid')->size(4)->type('number')->tab($other);
        // CRUD::field('pention_number')->type('number')->size(6)->tab($other);

    }
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

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
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
        //     CRUD::field('uas_user_id')->tab($edu)->size(3);
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
        $newPosition = Position::where('id',request()->position_id)->first();
        $employee = $this->crud->getCurrentEntry();
        if ($currentPosition->id == $newPosition->id) {
            if (PositionCode::where('position_id', request()->position_id)->where('employee_id', $employee->id)->count() == 0) {
                PositionCode::where('employee_id', $employee->id)->first()?->update(['employee_id' => null]);
                
                if (PositionCode::where('position_id', request()->position_id)->where('employee_id', null)->count() == 0) {
                    throw ValidationException::withMessages(['position_id' => 'No available place on this position!']);
                }else{
                    PositionCode::where('position_id', request()->position_id)->where('employee_id', null)->first()->update(['employee_id' => $employee->id]);
                }
            }
        }else{
            if (PositionCode::where('position_id', request()->position_id)->where('employee_id', null)->count() == 0) {
                throw ValidationException::withMessages(['position_id' => 'No available place on this position!']);
            }
            PositionCode::where('employee_id', $this->crud->getCurrentEntry()->id)->first()->update(['employee_id' => null]);
            PositionCode::where('position_id', request()->position_id)->where('employee_id', null)->first()->update(['employee_id' => $employee->id]);
        }
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
        $externalExperiences = ExternalExperience::where('employee_id', $employeeId)->orderBy('id', 'desc')->Paginate(10);
        $this->data['externalExperiences'] = $externalExperiences;
        $trainingAndStudies = TrainingAndStudy::where('employee_id', $employeeId)->orderBy('id', 'desc')->Paginate(10);
        $this->data['trainingAndStudies'] = $trainingAndStudies;

        $employeeSkills = Skill::where('employee_id', $employeeId)->paginate(10);
        $this->data['employeeSkills'] = $employeeSkills;
        $evalutionCreterias =  EvalutionCreteria::orderBy('id', 'desc')->Paginate(10);
        $this->data['evalutionCreterias'] = $evalutionCreterias;


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




        $level  =    Employee::where('id', $employeeId)->first()?->position->jobTitle->level_id;
      //  dd($level);
        $startSalary  =    JobGrade::where('level_id', $level)->first()?->start_salary;
        $this->data['startSalary'] = $startSalary;

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
