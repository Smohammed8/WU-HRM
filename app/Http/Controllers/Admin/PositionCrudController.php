<?php

namespace App\Http\Controllers\Admin;

use App\Constants;
use App\Http\Requests\PositionRequest;
use App\Models\JobTitle;
use App\Models\MinimumRequirement;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PositionCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PositionCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Position::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/position');
        CRUD::setEntityNameStrings('position', 'positions');
        $this->crud->setShowView('position.show');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('unit.name')->label('Unit');
        CRUD::column('job_title_id')->type('select')->entity('jobTitle')->model(JobTitle::class)->attribute('name')->size(4);
        CRUD::column('total_employees');
        CRUD::column('available_for_placement')->type('boolean');
        CRUD::column('status')->type('select_from_array')->options(Constants::POSITION_STATUS);

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
        CRUD::setValidation(PositionRequest::class);

        CRUD::field('unit_id');
        CRUD::field('job_title_id')->type('select')->entity('jobTitle')->model(JobTitle::class)->attribute('name');
        CRUD::field('total_employees');
        CRUD::field('available_for_placement');
        CRUD::field('status')->type('select_from_array')->options(Constants::POSITION_STATUS);

        /**
         * Fields can be d(efined using the fluent syntax or array syntax:
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

        $minimumRequirements = MinimumRequirement::where('position_id', $this->crud->getCurrentEntryId())->paginate(10);
        $this->data['minimumRequirements'] = $minimumRequirements;
    }
}
