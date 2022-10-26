<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UnitRequest;
use App\Models\Employee;
use App\Models\Organization;
use App\Models\User;
use App\Models\Unit;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class UnitCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class UnitCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Unit::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/unit');
        CRUD::setEntityNameStrings('unit', 'units');
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
       // CRUD::column('acronym');
        CRUD::column('email');
        CRUD::column('telephone');
        // CRUD::column('extension_line');
        // CRUD::column('location');
        // CRUD::column('seal');
        // CRUD::column('teter');
        // CRUD::column('vision');
        // CRUD::column('mission');
        // CRUD::column('objective');
        // CRUD::column('building_number');
        // CRUD::column('office_number');
        // CRUD::column('motto');
        // CRUD::column('value_list');
        //CRUD::column('parent_unit_id')->type('select')->entity('unit')->model(Unit::class)->attribute('name');
       // CRUD::column('reports_to_id')->type('select')->entity('unit')->model(Unit::class)->attribute('name');
         CRUD::column('organization_id')->type('select')->entity('organization')->model(Organization::class)->attribute('name');
        // CRUD::column('chair_man_type')->type('select')->entity('employee')->model(Employee::class)->attribute('name');

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
        CRUD::setValidation(UnitRequest::class);

        CRUD::field('name')->size(6);
      //  CRUD::field('acronym')->size(6);
        CRUD::field('email')->size(6);
        CRUD::field('telephone')->size(6);
        // CRUD::field('extension_line')->size(6);
        // CRUD::field('location')->size(6);
        // CRUD::field('seal')->size(6);
        // CRUD::field('teter')->size(6);
        // CRUD::field('vision')->size(6);
        // CRUD::field('mission')->size(6);
        // CRUD::field('objective')->size(6);
        // CRUD::field('building_number')->size(6);
        // CRUD::field('office_number')->size(6);
        // CRUD::field('motto')->size(6);
        // CRUD::field('value_list')->size(6);
       // CRUD::field('parent_unit_id')->size(6);

        CRUD::field('parent_unit_id')->size(6)->type('select2')->entity('unit')->model(Unit::class)->attribute('name');
        CRUD::field('reports_to_id')->size(6)->type('select2')->entity('unit')->model(Unit::class)->attribute('name');
        CRUD::field('organization_id')->size(6)->type('select2')->entity('organization')->model(Organization::class)->attribute('name');
        CRUD::field('chair_man_type_id')->size(6)->label('Office leader')->type('select2')->entity('employee')->model(Employee::class)->attribute('name');





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
