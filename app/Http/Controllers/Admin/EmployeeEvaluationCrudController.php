<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\EmployeeEvaluationRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\EvaluationLevel;
use App\Models\EvalutionCreteria;
use App\Models\Unit;

/**
 * Class EmployeeEvaluationCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class EmployeeEvaluationCrudController extends CrudController
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
        CRUD::setModel(\App\Models\EmployeeEvaluation::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/employee-evaluation');
        CRUD::setEntityNameStrings('employee evaluation', 'employee evaluations');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('employee_id');
        CRUD::column('evalution_creteria_id');
        CRUD::column('evaluation_level_id');
        CRUD::field('obtained_mark');



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
        CRUD::setValidation(EmployeeEvaluationRequest::class);

        CRUD::field('employee_id')->type('select2')->size(6);

        CRUD::field('evaluation_level_id')->type('select2')->entity('evaluationLevel')->model(EvaluationLevel::class)->attribute('name')->size(6);
        CRUD::field('evalution_creteria_id')->type('select2')->entity('evalutionCreteria')->model(EvalutionCreteria::class)->attribute('name')->size(6);

      //  CRUD::field('obtained_mark')->size(6);

        $this->crud->addField([
            'name'        => 'obtained_mark',
            'label'       => 'Obtained mark[5]',
            'type'        => 'radio',
            'default'      => 0,
            'options'     => [
                             4 => " Excellent[4]",
                             3 => "Very good[3]",
                             2 => "Good [2]",
                             1 => "Poor [1]"
                             ],
                             'inline' => true,
                             'label' => 'Questions',

        ]);

        CRUD::field('unit_id')->type('select2')->entity('unit')->model(Unit::class)->attribute('name')->size(6);
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
