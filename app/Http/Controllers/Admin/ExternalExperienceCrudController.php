<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ExternalExperienceRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ExternalExperienceCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ExternalExperienceCrudController extends CrudController
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
        CRUD::setModel(\App\Models\ExternalExperience::class);
        $employeeId = \Route::current()->parameter('employee');

        CRUD::setRoute(config('backpack.base.route_prefix') .'/'.$employeeId. '/external-experience');
        CRUD::setEntityNameStrings('external experience', 'external experiences');
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
    //     CRUD::column('unit_id');
    //     CRUD::column('job_title');
    //     CRUD::column('company_name');
    //     CRUD::column('start_date');
    //     CRUD::column('end_date');
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
        $employeeId = \Route::current()->parameter('employee');
        $this->data['breadcrumbs']=[
            trans('backpack::crud.admin') => backpack_url('dashboard'),
            'Employees' => route('employee.index'),
            'Preview' => route('employee.show',['id'=>$employeeId]),
            'Employee Address' => false,
        ];

        CRUD::setValidation(ExternalExperienceRequest::class);

        CRUD::field('employee_id')->type('hidden')->value($employeeId);
        CRUD::field('unit_id')->size(6);
        CRUD::field('job_title')->size(6);
        CRUD::field('company_name')->size(6);
        CRUD::field('start_date')->size(6);
        CRUD::field('end_date')->size(6);
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
