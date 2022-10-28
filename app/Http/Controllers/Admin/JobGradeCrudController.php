<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\JobGradeRequest;
use App\Models\Level;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class JobGradeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class JobGradeCrudController extends CrudController
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
        CRUD::setModel(\App\Models\JobGrade::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/job-grade');
        CRUD::setEntityNameStrings('job grade', 'job grades');
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
        $this->crud->denyAccess('delete');
        $this->crud->setDefaultPageLength(22);
        CRUD::column('level_id')->type('select')->entity('level')->model(Level::class)->attribute('name')->size(6);
        CRUD::column('start_salary')->label('Start');
        CRUD::column('one')->label('1st');
        CRUD::column('two')->label('2th');
        CRUD::column('three')->label('3th');
        CRUD::column('four')->label('4th');
        CRUD::column('five')->label('5th');
        CRUD::column('six')->label('6th');
        CRUD::column('seven')->label('7th');
        CRUD::column('eight')->label('8th');
        CRUD::column('nine')->label('9th');
        CRUD::column('ceil_salary')->label('Ceil');

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
        CRUD::setValidation(JobGradeRequest::class);


        CRUD::field('level_id')->size(3);
        CRUD::field('start_salary')->size(3)->type('number');
        CRUD::field('one')->size(3)->type('number');
        CRUD::field('two')->size(3)->type('number');
        CRUD::field('three')->size(3)->type('number');
        CRUD::field('four')->size(3)->type('number');
        CRUD::field('five')->size(3)->type('number');
        CRUD::field('six')->size(3)->type('number');
        CRUD::field('seven')->size(3)->type('number');
        CRUD::field('eight')->size(3)->type('number');
        CRUD::field('nine')->size(3)->type('number');
        CRUD::field('ceil_salary')->size(3)->type('number');

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
