<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UnitRequest;
use App\Models\ChairManType;
use App\Models\Employee;
use App\Models\HrBranch;
use App\Models\Organization;
use App\Models\User;
use App\Models\Unit;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
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
    use \Backpack\ReviseOperation\ReviseOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation {
        update as traitUpdate;
    } //IMPORTANT HERE
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(Unit::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/unit');
        CRUD::setEntityNameStrings('unit', 'units');
        CRUD::disablePersistentTable();
        CRUD::enableExportButtons(); // check this if the page is not loading
        $this->setupPermission();
    }
    public function setupPermission()
    {
        $permission_base = 'unit';
        if (!backpack_user()->can($permission_base . '.icrud')) {
            $explodedRoute = explode('/', $this->crud->getRequest()->getRequestUri());
            if (in_array('show', $explodedRoute)) {
                if (!backpack_user()->can($permission_base . '.show')) {
                    return abort(401);
                }
            }
            if (in_array('create', $explodedRoute)) {
                if (!backpack_user()->can($permission_base . '.create')) {
                    return abort(401);
                }
            }
            if (in_array('edit', $explodedRoute)) {
                if (!backpack_user()->can($permission_base . '.edit')) {
                    return abort(401);
                }
            }
            if (in_array('delete', $explodedRoute)) {
                if (!backpack_user()->can($permission_base . '.delete')) {
                    return abort(401);
                }
            }
            if ($explodedRoute[count($explodedRoute) - 1] == $this->crud->entity_name && !backpack_user()->can($permission_base . '.index')) {
                return abort(401);
            }
            if (!backpack_user()->can($permission_base . '.create')) {
                $this->crud->denyAccess('create');
            }

            if (!backpack_user()->can($permission_base . '.show')) {
                $this->crud->denyAccess('show');
            }

            if (!backpack_user()->can($permission_base . '.edit')) {
                $this->crud->denyAccess('update');
            }
            if (!backpack_user()->can($permission_base . '.delete')) {
                $this->crud->denyAccess('delete');
            }
        }
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {

        $this->crud->addFilter([
            'name'  => 'hr_branch_id',
            'type'  => 'select2',
            'label' => 'Filter by HR Branch'
        ], function () {
            return HrBranch::all()->pluck('name', 'id')->toArray();
        }, function ($values) {
            $this->crud->addClause('where', 'hr_branch_id', json_decode($values));
        });

        $this->crud->addFilter([
            'name'  => 'parent_unit_id',
            'type'  => 'select2',
            'label' => 'Filter  Sub-units'
        ], function () {
            return Unit::all()->pluck('name', 'id')->toArray();
        }, function ($values) {
            $this->crud->addClause('where', 'parent_unit_id', json_decode($values));
        });

        $this->crud->addFilter([
            'name'  => 'chair_man_type_id',
            'type'  => 'select2',
            'label' => 'Filter by Chairman'
        ], function () {
            return Employee::all()->pluck('name', 'id')->toArray();
        }, function ($values) {
            $this->crud->addClause('where', 'chair_man_type_id', json_decode($values));
        });


               /////////////////////////////////////////////////////////////
               CRUD::filter('status')
               ->type('select2')->label('Filter by office status')
               ->values(function () {
                   return [
                       '1' => 'Active unit',
                       '0' => 'Closed unit',
   
                   ];
               })
               ->whenActive(function ($value) {
                   CRUD::addClause('where', 'is_active', $value);
               });
   
           ////////////////////////////////////////////////////////


       // $this->crud->denyAccess('delete');
        $this->crud->denyAccess('show');

        $this->crud->addButtonFromModelFunction('line', 'view_office', 'viewOffice', 'end');
        $this->crud->addButtonFromModelFunction('line', 'view_employee', 'viewEmployee', 'end');

        CRUD::column('name')->label('Organizational unit');
      //  CRUD::column('level');
        CRUD::column('name')->label('Organizational unit');
        CRUD::column('parentUnit.name')->label('Accountable to');
        CRUD::column('chairManType.name')->label('Officee Leader');

        CRUD::column('hr_branch_id')->type('select')->label('HR Branch')->entity('hrBranch')->model(HrBranch::class)->attribute('name')->size(4);

        CRUD::column('is_active')->label('Is active?');
        

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
         CRUD::field('name')->label('Orignization unit')->size(6);
      

        // CRUD::field('level')->size(6);
         CRUD::field('parent_unit_id')->label('Accountable to')->size(6)->type('select2')->entity('unit')->model(Unit::class)->attribute('name');
        CRUD::field('chair_man_type_id')->size(6)->label('Office leader')->type('select2')->entity('employee')->model(Employee::class)->attribute('name');

        CRUD::field('hr_branch_id')->size(6)->label('HR Branch')->type('select2')->entity('hrBranch')->model(HrBranch::class)->attribute('name');
        CRUD::field('subordinate')->label('Is it subordinate?')->size(4)->default(false);
        CRUD::field('is_active')->label('Is active?')->size(4)->default(true);

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

     protected function setupReorderOperation()
     {
         // define which model attribute will be shown on draggable elements
         CRUD::set('reorder.label', 'name');
         // define how deep the admin is allowed to nest the items
         // for infinite levels, set it to 0
         CRUD::set('reorder.max_level', 2);
     }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
