<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\MisconductRequest;
use App\Models\Misconduct;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

use Illuminate\Http\Request;

/**
 * Class MisconductCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class MisconductCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Misconduct::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/misconduct');
        CRUD::setEntityNameStrings('misconduct', 'misconducts');
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
        CRUD::column('type_of_misconduct_id');
        CRUD::column('created_by_id');
        CRUD::column('attachement');
        CRUD::column('action_taken');
        CRUD::column('serverity');
        CRUD::column('description');
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
        CRUD::setValidation(MisconductRequest::class);

        CRUD::field('employee_id');
        CRUD::field('type_of_misconduct_id');
        CRUD::field('created_by_id');
        CRUD::field('attachement');
        CRUD::field('action_taken');
        CRUD::field('serverity');
        CRUD::field('description');
        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
    }


    public function create(Request $request){

        $misconduct_type         = $request->get('misconduct_type');
        $employee       = $request->get('employee');
        $severity        = $request->get('severity');
        $file            = $request->get('file');
        $comment            = $request->get('comment');
        $status = 'Leave out';


        Misconduct::create(['type_of_misconduct_id'=>$misconduct_type,
                           'employee_id'=>$employee,
                           'created_by_id'=>1,
                           'created_at '=>now(),
                           'attachement '=>$file,
                           'action_taken '=>null,
                           'serverity '=>$severity,
                           'description'=>$comment

                        ]);


     return redirect()->route('employee.show',$employee)->with('message', 'Misconduct added successfully!');
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
