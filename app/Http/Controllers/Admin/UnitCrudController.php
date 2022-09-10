<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UnitRequest;
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
        CRUD::column('acronym');
        CRUD::column('email');
        CRUD::column('telephone');
        CRUD::column('extension_line');
        CRUD::column('location');
        CRUD::column('seal');
        CRUD::column('teter');
        CRUD::column('vision');
        CRUD::column('mission');
        CRUD::column('objective');
        CRUD::column('building_number');
        CRUD::column('office_number');
        CRUD::column('motto');
        CRUD::column('value_list');
        CRUD::column('parent_unit_id');
        CRUD::column('reports_to_id');
        CRUD::column('organization_id');
        CRUD::column('chair_man_type_id');

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

        CRUD::field('name');
        CRUD::field('acronym');
        CRUD::field('email');
        CRUD::field('telephone');
        CRUD::field('extension_line');
        CRUD::field('location');
        CRUD::field('seal');
        CRUD::field('teter');
        CRUD::field('vision');
        CRUD::field('mission');
        CRUD::field('objective');
        CRUD::field('building_number');
        CRUD::field('office_number');
        CRUD::field('motto');
        CRUD::field('value_list');
        CRUD::field('parent_unit_id');
        CRUD::field('reports_to_id');
        CRUD::field('organization_id');
        CRUD::field('chair_man_type_id');

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
