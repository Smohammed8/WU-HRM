<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\EmployeeRequest;
use App\Models\Employee;
use App\Models\EmploymentStatus;
use App\Models\EmploymentType;
use App\Models\JobTitle;
use App\Models\MaritalStatus;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

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
        CRUD::column('name')->type('closure')->function(function($entry){
            return $entry->first_name.' '.$entry->father_name.' '.$entry->grand_father_name;
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
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        $this->crud->setCreateContentClass('col-md-12');
        $this->crud;
        CRUD::field('photo')->type('image')->aspectRatio(1)->crop(true)->size(4);
        CRUD::setValidation(EmployeeRequest::class);
        CRUD::field('first_name')->size(4);
        CRUD::field('father_name')->size(4);
        CRUD::field('grand_father_name')->size(4);
        CRUD::field('gender')->type('enum')->size(4);
        CRUD::field('date_of_birth')->size(4);
        CRUD::field('birth_city')->size(4);
        CRUD::field('passport')->size(4);
        CRUD::field('driving_licence')->size(4)->type('upload');
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
        CRUD::field('pention_number')->size(4);
        CRUD::field('employment_status_id')->type('select')->entity('employmentStatus')->model(EmploymentStatus::class)->attribute('name')->size(4);
        CRUD::field('static_salary')->size(4);
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
