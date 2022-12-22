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
        $this->setupPermission();
    }


    public function setupPermission()
    {
        $permission_base = 'job_grade';
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
            if ($explodedRoute[count($explodedRoute) - 1] == 'job-grade' && !backpack_user()->can($permission_base . '.index')) {
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
        $this->crud->denyAccess('show');
        $this->crud->enableExportButtons();
        $this->crud->ajax_table = false;

        $this->crud->denyAccess('delete');
        $this->crud->setDefaultPageLength(22);
        CRUD::column('level_id')->type('select')->entity('level')->model(Level::class)->attribute('name')->size(6);
        //  CRUD::column('start_salary')->label('Start');
        $this->crud->addColumn([
            'name'  => 'start_salary', // The db column name
            'label' => 'Start', // Table column heading
            'type'  => 'number',
            'dec_point'     => ','

        ]);


        CRUD::column('one')->label('1st');
        CRUD::column('two')->label('2th');
        CRUD::column('three')->label('3th');
        CRUD::column('four')->label('4th');
        CRUD::column('five')->label('5th');
        CRUD::column('six')->label('6th');
        CRUD::column('seven')->label('7th');
        CRUD::column('eight')->label('8th');
        CRUD::column('nine')->label('9th');
        // CRUD::column('ceil_salary')->label('Ceil');

        $this->crud->addColumn([
            'name'  => 'ceil_salary', // The db column name
            'label' => 'Ceil', // Table column heading
            'type'  => 'number',
            // 'prefix'        => 'ETB',
            //'suffix'        => ' EUR',
            // 'decimals'      => 2,
            'dec_point'     => ',',
            //  'thousands_sep' => '.',
            //  decimals, dec_point and thousands_sep are used to format the number;
            //  for details on how they work check out PHP's number_format() method, they're passed directly to it;
            //  https://www.php.net/manual/en/function.number-format.php
        ]);


        // $this->crud->addColumn([
        //     'name'    => 'ceil_salary',
        //     'label'   => 'ceil_salary',
        //     'type'    => 'boolean',
        //     'options' => [0 => 'No', 1 => 'Yes'], // optional
        //     'wrapper' => [
        //         'element' => 'span',
        //         'class' => function ($crud, $column, $entry, $related_key) {
        //             if ($column['text'] == 'Yes') {
        //                 return 'badge badge-success';
        //             }

        //             return 'badge badge-default';
        //         },
        //     ],
        // ]);


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
