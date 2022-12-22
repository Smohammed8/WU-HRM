<?php

namespace App\Http\Controllers\Admin;

use App\Constants;
use App\Http\Requests\VacancyRequest;
use App\Models\Position;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Carbon\Carbon;
use Faker\Core\DateTime;

/**
 * Class VacancyCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class VacancyCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Vacancy::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/vacancy');
        CRUD::setEntityNameStrings('vacancy', 'vacancies');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('type');
        CRUD::column('registration_start_date');
        CRUD::column('registration_end_date');
        CRUD::column('position_id')->label('Job Position')->type('select')->entity('position')->model(Position::class)->attribute('position_info')->size(6);
        CRUD::column('description');
        $this->crud->addButtonFromModelFunction('line', 'candidates', 'candidatesButtonView', 'beginning');

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
        CRUD::setValidation(VacancyRequest::class);

        CRUD::field('type')->type('enum')->size(6);
        CRUD::field('registration_start_date')->size(6);
        CRUD::field('registration_end_date')->size(6);
        // CRUD::field('position.jobTitle.name')->type('select2')->label('Position')->size(6);
        CRUD::field('position_id')->label('Job Position')->type('select2')->entity('position')->model(Position::class)->attribute('position_info')->size(6);
        CRUD::field('description')->size(12)->type('summernote');

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
