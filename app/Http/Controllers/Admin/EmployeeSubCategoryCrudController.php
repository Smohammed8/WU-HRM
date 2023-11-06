<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\EmployeeSubCategoryRequest;
use App\Models\EmployeeSubCategory;
use App\Models\EmployeeCategory;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class EmployeeSubCategoryCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class EmployeeSubCategoryCrudController extends CrudController
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
        CRUD::setModel(EmployeeSubCategory::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/employee-sub-category');
        CRUD::setEntityNameStrings('employee sub category', 'employee sub categories');
        $this->setupPermission();
    }

    public function setupPermission()
    {
        $permission_base = 'employee_sub_category';
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
                $this->crud->denyAccess(['create']);
            }

            if (!backpack_user()->can($permission_base . '.show')) {
                $this->crud->denyAccess(['show']);
            }

            if (!backpack_user()->can($permission_base . '.edit')) {
                $this->crud->denyAccess(['update']);
            }

            if (!backpack_user()->can($permission_base . '.delete')) {
                $this->crud->denyAccess(['delete']);
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
        CRUD::column('name')->label('Sub-category');
  
        CRUD::column('employee_category_id')->type('select')->label('Category')->entity('employeeCategory')->model(EmployeeSubCategory::class)->attribute('name');

        CRUD::column('description');

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
        CRUD::setValidation(EmployeeSubCategoryRequest::class);

        CRUD::field('name')->size(6)->label('Sub-Category');
        CRUD::field('employee_category_id')->type('select2')->label('Employment Puper category')->entity('employeeCategory')->model(EmployeeCategory::class)->attribute('name')->size(6)->size(6);

        CRUD::field('description');

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
