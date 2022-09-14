<?php

namespace App\Http\Controllers\Admin;

use App\Constants;
use App\Http\Requests\EmployeeRequest;
use App\Models\Employee;
use App\Models\EmploymentStatus;
use App\Models\EmploymentType;
use App\Models\JobTitle;
use App\Models\MaritalStatus;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Prologue\Alerts\Facades\Alert;

/**
 * Class EmployeeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class EmployeeCrudController extends CrudController
{

    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    //use \Backpack\CRUD\app\Http\Controllers\Operations\BulkDeleteOperation;
   // use \Backpack\CRUD\app\Http\Controllers\Operations\CloneOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;

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
    }

    /**
     * Store a newly created resource in the database.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $this->crud->hasAccessOrFail('create');
        // execute the FormRequest authorization and validation, if one is required
        $request = $this->crud->validateRequest();
        $inputs = $this->crud->getStrippedSaveRequest();
        // insert item in the db
        // dd($request->input('photo'));
        //Upload Image
        $photoFile = UploadFileCrudController::uploadBase64($inputs['photo'], Constants::EMPLOYEE_PHOTO_UPLOAD_PATH);
        $inputs['photo'] = $photoFile->id;
        //CHecking driving license
        $drivingLicense = $inputs['driving_licence'];
        if ($drivingLicense != null) {
            $inputs['driving_licence'] = UploadFileCrudController::fileUpload($request->file('driving_licence'), Constants::EMPLOYEE_DRIVER_LICESNCE_UPLOAD_PATH)->id;
        }

        $item = $this->crud->create($inputs);
        $this->data['entry'] = $this->crud->entry = $item;

        // show a success message
        Alert::success(trans('backpack::crud.insert_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        return $this->crud->performSaveAction($item->getKey());
    }
    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        // CRUD::column('first_name');
        // CRUD::column('father_name');
        // CRUD::column('grand_father_name');
        CRUD::column('name')->type('closure')->function(function ($entry) {
            return $entry->first_name . ' ' . $entry->father_name . ' ' . $entry->grand_father_name;
        });
        // CRUD::column('first_name')->label('Name');

        // CRUD::column('gender');
        // CRUD::column('date_of_birth');
        // CRUD::column('photo');
        // CRUD::column('birth_city');
        // CRUD::column('passport');
        // CRUD::column('driving_licence');
        // CRUD::column('blood_group');
        // CRUD::column('eye_color');
        // CRUD::column('phone_number');
        // CRUD::column('alternate_email');
        // CRUD::column('rfid');
        CRUD::column('employment_identity')->label('Employee ID Number');
        // CRUD::column('marital_status_id');
        // CRUD::column('ethnicity_id');
        // CRUD::column('religion_id');
        // CRUD::column('unit_id');
        CRUD::column('employement_date')->type('date');
        // CRUD::column('salary_step');
        CRUD::column('job_title_id')->type('select')->entity('jobTitle')->model(JobTitle::class)->attribute('name')->size(4);
        // CRUD::column('employment_type_id');
        // CRUD::column('pention_number');
        // CRUD::column('employment_status_id');
        // CRUD::column('static_salary');
        // CRUD::column('uas_user_id');

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */



        $this->crud->addFilter([
            'type'  => 'date_range',
            'name'  => 'employement_date ',
            'label' => 'By hire date '
          ],
          false,
          function ($value) { // if the filter is active, apply these constraints
            $dates = json_decode($value);
            $this->crud->addClause('where', ' employement_date ', '>=', $dates->from);
            $this->crud->addClause('where', ' employement_date ', '<=', $dates->to . ' 23:59:59');
          });


        $this->crud->addFilter([
            'name'  => 'unit_id',
            'type'  => 'select2_multiple',
            'label' => 'Filter by office'

        ], function() {
            return \App\Models\Unit::all()->pluck('name', 'id')->toArray();
        }, function($values) {
            $this->crud->addClause('whereIn', 'unit_id', json_decode($values));
        });


        $this->crud->addFilter([
            'name'  => 'employment_type_id',
            'type'  => 'select2_multiple',
            'label' => 'Filter by type'

        ], function() {
            return \App\Models\EmploymentType::all()->pluck('name', 'id')->toArray();
        }, function($values) {
            $this->crud->addClause('whereIn', 'employment_type_id', json_decode($values));
        });

        $this->crud->addFilter([
            'name'  => 'job_title_id',
            'type'  => 'select2_multiple',
            'label' => 'By job title'

        ], function() {
            return \App\Models\JobTitle::all()->pluck('name', 'id')->toArray();
        }, function($values) {
            $this->crud->addClause('whereIn', 'job_title_id', json_decode($values));
        });






    $this->crud->addFilter([
    'name'       => 'static_salary ',
    'type'       => 'range',
    'label'      => 'By Gross salary',
    'label_from' => 'min value',
    'label_to'   => 'max value',
    'size' =>5
  ],
  false,
  function($value) { // if the filter is active
      $range = json_decode($value);
      if ($range->from) {
          $this->crud->addClause('where', 'static_salary ', '>=', (float) $range->from);
      }
      if ($range->to) {
          $this->crud->addClause('where', 'static_salary ', '<=', (float) $range->to);
      }
  });


        // $this->crud->addFilter([
        //     'name'  => 'problem_id',
        //     'type'  => 'select2_multiple',
        //     'label' => 'Filter by client request'

        // ], function() {
        //     return \App\Models\Problem::all()->pluck('name', 'id')->toArray();
        // }, function($values) {
        //     $this->crud->addClause('whereIn', 'problem_id', json_decode($values));
        // });
    }




    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(EmployeeRequest::class);
        $this->crud->setCreateContentClass('col-md-12');
        $this->crud;
        CRUD::field('photo')->type('image')->aspectRatio(1)->crop(true)->size(4);
        CRUD::field('first_name')->size(4);
        CRUD::field('father_name')->size(4);
        CRUD::field('grand_father_name')->size(4);
        CRUD::field('gender')->type('enum')->size(4);
        CRUD::field('date_of_birth')->size(4);
        CRUD::field('birth_city')->size(4);
        CRUD::field('passport')->size(4);
        CRUD::field('driving_licence')->size(4)->type('upload')->upload(true);
        CRUD::field('blood_group')->type('enum')->size(4);
        CRUD::field('eye_color')->type('enum')->size(4);
        CRUD::field('phone_number')->size(4);
        CRUD::field('alternate_email')->type('email')->size(4);
        CRUD::field('rfid')->size(4);
        CRUD::field('employment_identity')->label('Employee ID Number')->size(4);
        CRUD::field('marital_status_id')->type('select')->entity('maritalStatus')->model(MaritalStatus::class)->attribute('name')->size(4);
        CRUD::field('ethnicity_id')->size(4);
        CRUD::field('religion_id')->size(4);
        CRUD::field('unit_id')->size(4);
        CRUD::field('employement_date')->size(4);
        CRUD::field('salary_step')->type('enum')->size(4);
        CRUD::field('job_title_id')->type('select')->entity('jobTitle')->model(JobTitle::class)->attribute('name')->size(4);
        CRUD::field('employment_type_id')->type('select')->entity('employmentType')->model(EmploymentType::class)->attribute('name')->size(4);
        CRUD::field('pention_number')->size(4)->type('number');
        CRUD::field('employment_status_id')->type('select')->entity('employmentStatus')->model(EmploymentStatus::class)->attribute('name')->size(4);
        CRUD::field('static_salary')->size(4)->type('number');
        CRUD::field('uas_user_id')->size(4);


        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
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
    }
}
