<?php

namespace App\Http\Controllers\Admin;
use App\Models\Employee;
use App\Http\Requests\ComplaintRequest;
use App\Models\PlacementRound;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ComplaintCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ComplaintCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Complaint::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/complaint');
        CRUD::setEntityNameStrings('complaint', 'complaints');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
       // CRUD::column('employee_id')->label('Employee Name');

        CRUD::column('round.year')->label('Placement round')->size(6);
        CRUD::column('employee_id')->label('Select employee')->type('select')->entity('employee')->model(Employee::class)->attribute('name')->size(6);
        CRUD::column('unit_id')->label('Working unit');
        CRUD::column('phone');
        CRUD::column('complian_message');
        CRUD::column('isReviewed')->label('Is it reveied by the committe?');

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
        CRUD::setValidation(ComplaintRequest::class);

        CRUD::field('round_id')->label('Placement round')->size(6);
       // CRUD::field('round_id')->label('Placement round')->type('select2')->entity('placementRound')->model(PlacementRound::class)->attribute('year')->size(6);

        CRUD::field('employee_id')->label('Employee Name')->type('select2')->entity('employee')->model(Employee::class)->attribute('name')->size(6);
        CRUD::field('unit_id')->label('Working unit')->size(6);
        CRUD::field('phone')->label('Contact phone')->size(6);
        CRUD::field('complian_message');
        CRUD::field('isReviewed')->label('Is it reveied by the committe?');

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
