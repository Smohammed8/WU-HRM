<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PlacementChoiceRequest;
use App\Models\PlacementRound;
use App\Models\Position;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PlacementChoiceCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PlacementChoiceCrudController extends CrudController
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
        CRUD::setModel(\App\Models\PlacementChoice::class);
        $placementRound = \Route::current()->parameter('placement_round');
        CRUD::setRoute(config('backpack.base.route_prefix').'/placement-round/' .$placementRound. '/placement-choice');
        CRUD::setEntityNameStrings('placement choice', 'placement choices');
        $this->crud->setListView('placement_choice.show');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        // CRUD::column('placementRound.round')->label('Round');
        CRUD::column('employee_id');
        CRUD::column('choiceOne.jobTitle.name')->label('Choice One');
        CRUD::column('choiceTwo.jobTitle.name')->label('Choice Two');
        CRUD::column('choice_one_result')->label('Result One');
        CRUD::column('choice_two_result')->label('Result Two');
        CRUD::column('choice_one_rank')->label('Rank One');
        CRUD::column('choice_two_rank')->label('Rank Two');
        $this->crud->denyAccess('show');
        $this->crud->denyAccess('update');
        $this->crud->denyAccess('delete');
        $placementRound = \Route::current()->parameter('placement_round');
        $this->data['placementRound'] = PlacementRound::find($placementRound);
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
        $placementRound = \Route::current()->parameter('placement_round');
        CRUD::setValidation(PlacementChoiceRequest::class);
        CRUD::field('placement_round_id')->type('hidden')->value($placementRound);
        CRUD::field('employee_id');
        CRUD::field('choice_one_id')->type('select')->model(Position::class)->entity('choiceOne')->attribute('position_info');
        CRUD::field('choice_two_id')->type('select')->model(Position::class)->entity('choiceTwo')->attribute('position_info');

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
