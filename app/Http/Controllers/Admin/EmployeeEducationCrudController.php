<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\EmployeeEducationRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\Employee;
use App\Models\FieldOfStudy;
use App\Models\EducationalLevel;
use App\Models\EmployeeEducation;
use Illuminate\Support\Facades\Route;
/**
 * Class EmployeeEducationCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class EmployeeEducationCrudController extends CrudController
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
        CRUD::setModel(EmployeeEducation::class);
      // CRUD::setRoute(config('backpack.base.route_prefix') . '/employee-education');
        $employeeId = Route::current()->parameter('employee');
        CRUD::setRoute(config('backpack.base.route_prefix') . '/'.$employeeId.'/employee-education');
        CRUD::setEntityNameStrings('employee education', 'employee educations');
        $this->setupBreadcrumb($employeeId);
    }

    public function setupBreadcrumb($employeeId)
    {
        $breadcrumbs = [
            'Admin' => route('dashboard'),
            'Employees' => route('employee.index'),
            'Employee Education' => route('employee.show',
            ['id'=>$employeeId]).'#employee_education',
        ];
        if(in_array('show',explode('/',$this->crud->getRequest()->getRequestUri()))){
            $breadcrumbs['Preview'] = false;
        }
        if(in_array('edit',explode('/',$this->crud->getRequest()->getRequestUri()))){
            $breadcrumbs['Update'] = false;
        }
        if(in_array('create',explode('/',$this->crud->getRequest()->getRequestUri()))){
            $breadcrumbs['Add'] = false;
        }
        $this->data['breadcrumbs'] = $breadcrumbs;
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
       // CRUD::column('employee_id');
        CRUD::column('institution');
        CRUD::column('field_of_study_id');
        CRUD::column('educational_level_id');
        CRUD::column('training_start_date');
        CRUD::column('training_end_date');
        CRUD::column('upload');

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
       $employeeId = Route::current()->parameter('employee');

        CRUD::setValidation(EmployeeEducationRequest::class);
      //  CRUD::field('employee_id') ->size(6);
        CRUD::field('employee_id')->type('hidden')->value($employeeId);
        //CRUD::field('employee_id')->type('hidden')->value($employeeId);
        CRUD::field('institution')->size(6);
        CRUD::field('field_of_study_id')->label('Field of Study')->type('select2')->entity('fieldOfStudy')->model(FieldOfStudy::class)->attribute('name')->size(6);
        CRUD::field('educational_level_id')->label('Education Level')->type('select2')->entity('educationalLevel')->model(EducationalLevel::class)->attribute('name')->size(6);
        CRUD::field('training_start_date')->size(6);
        CRUD::field('training_end_date')->size(6);
        CRUD::field('upload')->type('upload')->upload(true)->size(6);
        //CRUD::field('avatar')->type('upload')->withFiles();
        //CRUD::field('avatar')->type('upload')->withFiles(['disk' => 'public', 'path' => 'uploads']);
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

     protected function setupDeleteOperation()
{
      CRUD::field('upload')->type('upload')->withFiles();

    // Alternatively, if you are not doing much more than defining fields in your create operation:
    // $this->setupCreateOperation();
}

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
