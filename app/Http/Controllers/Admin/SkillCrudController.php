<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SkillRequest;
use App\Models\SkillType;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class SkillCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class SkillCrudController extends CrudController
{
    // use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
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
        CRUD::setModel(\App\Models\Skill::class);
        $employeeId = \Route::current()->parameter('employee');
        CRUD::setRoute(config('backpack.base.route_prefix') . '/'.$employeeId. '/skill');
        CRUD::setEntityNameStrings('skill', 'skills');
        $this->setupBreadcrumb($employeeId);
    }


    public function setupBreadcrumb($employeeId)
    {
        $breadcrumbs = [
            'Admin' => route('dashboard'),
            'Employees' => route('employee.index'),
            'Skills' => route('employee.show',['id'=>$employeeId]).'#employee_skill',
        ];
        // dd($this->crud->getRequest()->getRequestUri());
        if(in_array('show',explode('/',$this->crud->getRequest()->getRequestUri()))){
            $breadcrumbs['Preview'] = false;
        }
        if(in_array('edit',explode('/',$this->crud->getRequest()->getRequestUri()))){
            $breadcrumbs['Update'] = false;
        }
        if(in_array('create',explode('/',$this->crud->getRequest()->getRequestUri()))){
            $breadcrumbs['Add'] = false;
        }
        $this->data['breadcrumbs'] = $breadcrumbs;
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
        CRUD::column('skill_type_id');
        CRUD::column('name');
        CRUD::column('level');
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
        $employeeId = \Route::current()->parameter('employee');
        CRUD::setValidation(SkillRequest::class);
        CRUD::field('employee_id')->type('hidden')->value($employeeId);
        CRUD::field('skill_type_id')->type('select')->entity('skillType')->model(SkillType::class)->attribute('name');
        CRUD::field('name');
        CRUD::field('level');
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
        $employeeId = \Route::current()->parameter('employee');

        $this->setupCreateOperation();
    }
}
