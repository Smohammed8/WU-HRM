<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PlacementRoundRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PlacementRoundCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PlacementRoundCrudController extends CrudController
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
        CRUD::setModel(\App\Models\PlacementRound::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/placement-round');
        CRUD::setEntityNameStrings('placement round', 'placement rounds');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */

    protected function setupListOperation()
    {
        $this->crud->denyAccess('show');
        CRUD::column('round');
        CRUD::column('year');
        CRUD::column('is_open')->label('Open')->type('boolean');
        $this->crud->addButtonFromModelFunction('line', 'placementChoices', 'placementChoicesButtonView', 'beginning');
        $this->crud->addButtonFromModelFunction('line', 'placementResult', 'placementResultButtonView', 'end');

       
        $this->crud->addButtonFromModelFunction('line', 'committee', 'committeeButtonView', 'end');
        $this->crud->addButtonFromModelFunction('line', 'complain', 'complainButtonView', 'end');


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
        CRUD::setValidation(PlacementRoundRequest::class);

        CRUD::field('round');
        CRUD::field('year');
        CRUD::field('is_open')->type('boolean');
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
