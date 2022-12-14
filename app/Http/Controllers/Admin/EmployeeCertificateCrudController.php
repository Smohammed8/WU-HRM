<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\EmployeeCertificateRequest;
use App\Models\SkillType;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class EmployeeCertificateCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class EmployeeCertificateCrudController extends CrudController
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
        CRUD::setModel(\App\Models\EmployeeCertificate::class);
        $employeeId = \Route::current()->parameter('employee');
        CRUD::setRoute(config('backpack.base.route_prefix') . '/'.$employeeId. '/employee-certificate');
        CRUD::setEntityNameStrings('employee certificate', 'employee certificates');
        $this->setupBreadcrumb($employeeId);
    }
    public function setupBreadcrumb($employeeId)
    {
        $breadcrumbs = [
            'Admin' => route('dashboard'),
            'Employees' => route('employee.index'),
            'Certificates' => route('employee.show',['id'=>$employeeId]).'#employee_certificate',
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
    //     CRUD::column('skill_type_id');
    //     CRUD::column('name');
    //     CRUD::column('address');
    //     CRUD::column('certificate_date');
    //     CRUD::column('duration');
    //     CRUD::column('comment');

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
        CRUD::setValidation(EmployeeCertificateRequest::class);
        $employeeId = \Route::current()->parameter('employee');

        CRUD::field('employee_id')->type('hidden')->value($employeeId);

        CRUD::field('skill_type_id')->type('select')->entity('skillType')->model(SkillType::class)->attribute('name')->size(6);
        CRUD::field('name')->size(6);
        CRUD::field('address')->size(6);
        CRUD::field('certificate_date')->size(6);
        // CRUD::field('duration');
        CRUD::field('comment');

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
