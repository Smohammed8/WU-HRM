<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\DemotionRequest;
use App\Models\Demotion;
use App\Models\Unit;
use App\Models\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\Request;

/**
 * Class DemotionCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class DemotionCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Demotion::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/demotion');
        CRUD::setEntityNameStrings('demotion', 'demotions');
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
        CRUD::column('old_unit_id');
        CRUD::column('new_unit_id');
        CRUD::column('old_job_title_id');
        CRUD::column('new_job_title_id');
        CRUD::column('created_by_id');
        CRUD::column('reason_of_demotion');
        $this->crud->denyAccess('create');
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
        CRUD::setValidation(DemotionRequest::class);

        CRUD::field('employee_id')->type('select2')->size(6);
        CRUD::field('old_unit_id')->size(6);
        CRUD::field('new_unit_id')->type('select2')->entity('unit')->model(Unit::class)->attribute('name')->size(6);

        CRUD::field('new_job_title_id')->size(6);
        CRUD::field('old_job_title_id')->type('select2')->entity('jobTitle')->model(JobTitle::class)->attribute('name')->size(6);

        CRUD::field('created_by_id')->type('select2')->entity('user')->model(User::class)->attribute('name')->size(6);
        CRUD::field('reason_of_demotion');

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
    }


    public function create(Request $request){

        $old_unit      = $request->get('old_uint');
        $old_job        = $request->get('old_job');
        $employee       = $request->get('employee');
        $new_unit       = $request->get('new_unit');
        $new_job        = $request->get('new_job');
        $comment         = $request->get('comment');

          Demotion::create(['old_unit_id'=>$old_unit,
                           'new_unit_id'=>$new_unit,
                           'employee_id'=>$employee,
                           'old_job_title_id'=>$old_job,
                           'new_job_title_id '=>$new_job,
                           'crteated_by_id'=>1,
                           'reason_of_demotion'=>$comment

                        ]);


     return redirect()->route('employee.show',$employee)->with('message', 'Demotion added successfully!');
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
