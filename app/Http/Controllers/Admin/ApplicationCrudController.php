<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ApplicationRequest;
use App\Models\ApplicationType;
use App\Models\User;
use App\Models\Employee;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Models\Traits\CrudTrait as TraitsCrudTrait;
use Backpack\CRUD\app\Traits\CrudTrait;

/**
 * Class ApplicationCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ApplicationCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use TraitsCrudTrait;
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Application::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/application');
        CRUD::setEntityNameStrings('application', 'applications');
        $this->setupPermission();
    }


    public function setupPermission()
    {
        $permission_base = 'application';
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
      
       // $this->crud->addClause('where', 'user_id', '=', backpack_user()->id);
    
        CRUD::column('user.employee.name')->label('Sender employee')->type('select')->entity('user.employee')->model(Employee::class);

        CRUD::column('application_type_id')->type('select')->label('Application type')->entity('applicationType')->model(ApplicationType::class)->attribute('name');
            CRUD::column('status')->label('Application status')->wrapper([
                'element' => 'span',
                'class' => function ($crud, $column, $entry) {
                    switch ($entry->status) {
                        case '1':
                            return 'badge badge-pill badge-danger';
                        case '0':
                            return 'badge badge-pill badge-success';
                        default:
                            return 'badge badge-pill badge-warning';
                    }
                }
            ]);
        CRUD::column('description');

        CRUD::column('created_at')->type('closure')->function(function ($entry) {
            return $entry-> getCreatedAtAttribute();
        })->label('Recieved at')->wrapper([
            'element' => 'span',
            'title' => 'Employee age in years',
            'class' => function ($crud, $column, $entry) {
                switch ($entry-> getCreatedAtAttribute()) {
                case '1':
                    return 'badge badge-pill badge-danger';
                case '0':
                    return 'badge badge-pill badge-success';
                default:
                    return 'badge badge-pill badge-info';
                }
            }
        ]);

        


        //$entry = $this->crud->entry;

        $this->crud->addFilter([
            'name'  => 'user_id',
            'type'  => 'select2_multiple',
            'label' => 'Filter by Employee Name'
        ], function () {
            return User::all()->pluck('name', 'id')->toArray();
        }, 
        function ($values) {
            $this->crud->addClause('where', 'user_id', json_decode($values));
        });
        CRUD::filter('genders')
        ->type('select2')->label('Filter by status')
        ->values(function () {
            return [
                '0' => 'Pending',
                '1' => 'Closed',

            ];
        })
        ->whenActive(function ($value) {
            CRUD::addClause('where', 'status', $value);
        });

        $this->crud->addFilter([
            'name'  => 'application_type_id',
            'type'  => 'select2_multiple',
            'label' => 'Filter by Application type'
        ], function () {
            return ApplicationType::all()->pluck('name', 'id')->toArray();
        }, function ($values) {
            $this->crud->addClause('where', 'application_type_id', json_decode($values));
        });

        $this->crud->addFilter(
            [
                'type'  => 'date_range',
                'name'  => 'created_at',
                'label' => 'By application date'
            ],
            false,
            function ($value) { 
                $dates = json_decode($value);
                $this->crud->addClause('whereBetween', 'created_at', [$dates->from, $dates->to]);
            }
        );


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
     


      //  if ($this->crud->getRequest()->method() === 'GET') {}

        CRUD::setValidation(ApplicationRequest::class);
        // CRUD::field('employee_id')->type('hidden')->value(backpack_user()->employee->id);
        CRUD::field('user_id')->type('hidden')->value(backpack_user()->id);

        CRUD::field('application_type_id')->type('select2')->entity('applicationType')->model(ApplicationType::class)->attribute('name')->label('Select application type');
     
    
        CRUD::field('description')->type('summernote')->label('Write your description below');
      //  CRUD::field('status')->type('checkbox')->default(false)->label('Application Status');


        $this->crud->addField([
            'name'        => 'status',
            'label'       => 'Application Status',
            'type'        => 'radio',
            'options'     => [
                0 => 'Pending',
                1 => 'Accepted'
            ]
        ]);

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
