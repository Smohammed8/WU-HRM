<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\EmployeeFamilyRequest;
use App\Models\FamilyRelationship;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
/**
 * Class EmployeeFamilyCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class EmployeeFamilyCrudController extends CrudController
{
    // use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
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
        CRUD::setModel(\App\Models\EmployeeFamily::class);
        $employeeId = \Route::current()->parameter('employee');
        CRUD::setRoute(config('backpack.base.route_prefix') . '/'.$employeeId. '/employee-family');
        CRUD::setEntityNameStrings('employee family', 'employee families');
        $this->setupBreadcrumb();

    }


    public function setupBreadcrumb()
    {
        $employeeId = \Route::current()->parameter('employee');
        $breadcrumbs = [
            'Admin' => route('dashboard'),
            'Employees' => route('employee.index'),
            ucfirst($this->crud->entity_name_plural) => route('employee.show',['id'=>$employeeId]).'#employee_family',
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

    // /**
    //  * Define what happens when the List operation is loaded.
    //  *
    //  * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
    //  * @return void
    //  */
    // protected function setupListOperation()
    // {
    //     CRUD::column('employee_id');
    //     CRUD::column('family_relationship_id');
    //     CRUD::column('first_name');
    //     CRUD::column('father_name');
    //     CRUD::column('grand_father_name');
    //     CRUD::column('gender');
    //     CRUD::column('dob');

    //     /**
    //      * Columns can be defined using the fluent syntax or array syntax:
    //      * - CRUD::column('price')->type('number');
    //      * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
    //      */
    // }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        $employeeId = \Route::current()->parameter('employee');
        CRUD::field('employee_id')->type('hidden')->value($employeeId);
        CRUD::setValidation(EmployeeFamilyRequest::class);
        CRUD::field('family_relationship_id')->type('select')->entity('familyRelationship')->model(FamilyRelationship::class)->attribute('name')->size(6);
        CRUD::field('first_name')->size(6);
        CRUD::field('father_name')->size(6);
        CRUD::field('grand_father_name')->size(6);
        CRUD::field('gender')->type('enum')->size(6);
        CRUD::field('dob')->size(6);
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
