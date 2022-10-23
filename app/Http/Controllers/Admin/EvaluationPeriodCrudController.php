<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\EvaluationPeriodRequest;
use App\Models\EvaluationPeriod;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

/**
 * Class EvaluationPeriodCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class EvaluationPeriodCrudController extends CrudController
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
        CRUD::setModel(\App\Models\EvaluationPeriod::class);
       // CRUD::setModel(\App\Models\EvaluationPeriod::orderBy('id', 'desc')->Paginate(1);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/evaluation-period');
        CRUD::setEntityNameStrings('evaluation period', 'evaluation periods');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('name');
        //CRUD::column('created_by_id')->type('select')->entity('user')->model(User::class)->attribute('name')->size(6);
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
        CRUD::setValidation(EvaluationPeriodRequest::class);

        CRUD::field('name')->type('enum')->size(6);
       //Auth::user()->id
        CRUD::field('created_by_id')->type('hidden')->value(backpack_user()->id);




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



    protected function setupShowOperation()
    {

        $evaluation_periods =  EvaluationPeriod::orderBy('id', 'desc')->Paginate(1);
        $this->data['evaluation_periods'] = $evaluation_periods;


    }

}
