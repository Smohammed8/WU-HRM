<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\TrainingAndStudyRequest;
use App\Models\EducationalLevel;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class TrainingAndStudyCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class TrainingAndStudyCrudController extends CrudController
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
        CRUD::setModel(\App\Models\TrainingAndStudy::class);
        $employeeId = \Route::current()->parameter('employee');

        CRUD::setRoute(config('backpack.base.route_prefix') .'/'.$employeeId. '/training-and-study');
        CRUD::setEntityNameStrings('training and study', 'training and studies');
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
    //     CRUD::column('name');
    //     CRUD::column('nationality_id');
    //     CRUD::column('educational_level_id');
    //     CRUD::column('inistitution');
    //     CRUD::column('city');
    //     CRUD::column('is_contract');
    //     CRUD::column('date_of_leave');
    //     CRUD::column('end_of_study');

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
        CRUD::setValidation(TrainingAndStudyRequest::class);
        $employeeId = \Route::current()->parameter('employee');
        $this->data['breadcrumbs']=[
            trans('backpack::crud.admin') => backpack_url('dashboard'),
            'Employees' => route('employee.index'),
            'Preview' => route('employee.show',['id'=>$employeeId]),
            'Employee Address' => false,
        ];
        CRUD::field('employee_id')->type('hidden')->value($employeeId);
        CRUD::field('name')->size(6);
        CRUD::field('nationality_id')->size(6);
        CRUD::field('educational_level_id')->type('select2')->model(EducationalLevel::class)->attribute('name')->size(6);
        CRUD::field('inistitution')->size(6);
        CRUD::field('city')->size(6);
        CRUD::field('is_contract')->size(6);
        CRUD::field('date_of_leave')->size(6);
        CRUD::field('end_of_study')->size(6);

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
