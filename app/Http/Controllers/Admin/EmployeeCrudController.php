<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\EmployeeRequest;
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
        CRUD::column('first_name');
        CRUD::column('father_name');
        CRUD::column('grand_father_name');
        CRUD::column('gender');
        CRUD::column('date_of_birth');
        CRUD::column('photo');
        CRUD::column('birth_city');
        CRUD::column('passport');
        CRUD::column('driving_licence');
        CRUD::column('blood_group');
        CRUD::column('eye_color');
        CRUD::column('phone_number');
        CRUD::column('alternate_email');
        CRUD::column('rfid');
        CRUD::column('employment_identity');
        CRUD::column('marital_status_id');
        CRUD::column('ethnicity_id');
        CRUD::column('religion_id');
        CRUD::column('unit_id');
        CRUD::column('employement_date');
        CRUD::column('salary_step');
        CRUD::column('job_title_id');
        CRUD::column('employment_type_id');
        CRUD::column('pention_number');
        CRUD::column('employment_status_id');
        CRUD::column('static_salary');
        CRUD::column('uas_user_id');

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
        CRUD::setValidation(EmployeeRequest::class);

        CRUD::field('first_name');
        CRUD::field('father_name');
        CRUD::field('grand_father_name');
        CRUD::field('gender');
        CRUD::field('date_of_birth');
        CRUD::field('photo');
        CRUD::field('birth_city');
        CRUD::field('passport');
        CRUD::field('driving_licence');
        CRUD::field('blood_group');
        CRUD::field('eye_color');
        CRUD::field('phone_number');
        CRUD::field('alternate_email');
        CRUD::field('rfid');
        CRUD::field('employment_identity');
        CRUD::field('marital_status_id');
        CRUD::field('ethnicity_id');
        CRUD::field('religion_id');
        CRUD::field('unit_id');
        CRUD::field('employement_date');
        CRUD::field('salary_step');
        CRUD::field('job_title_id');
        CRUD::field('employment_type_id');
        CRUD::field('pention_number');
        CRUD::field('employment_status_id');
        CRUD::field('static_salary');
        CRUD::field('uas_user_id');

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
