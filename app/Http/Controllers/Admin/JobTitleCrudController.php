<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\JobTitleRequest;
use App\Models\EducationalLevel;
use App\Models\FieldOfStudy;
use App\Models\JobTitleCategory;
use App\Models\Level;
use App\Models\PositionType;
use App\Models\Unit;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class JobTitleCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class JobTitleCrudController extends CrudController
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
        CRUD::setModel(\App\Models\JobTitle::class);
        $jobTitleCategory = \Route::current()->parameter('job_title_category');
        CRUD::setRoute(config('backpack.base.route_prefix') . '/job-title-category/' . $jobTitleCategory . '/job-title');
        CRUD::setEntityNameStrings('job title', 'job titles');
        $this->setupPermission();
    }

    public function setupPermission()
    {
        $permission_base = 'job_title_category.job_title';
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
            if ($explodedRoute[count($explodedRoute) - 1] == 'job-title' && !backpack_user()->can($permission_base . '.index')) {
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

        $jobTitleCategoryId = \Route::current()->parameter('job_title_category');
        $this->crud->setHeading(JobTitleCategory::find($jobTitleCategoryId)->name.' Job titles');
        CRUD::column('name')->label('የስራ መደቡ መጠሪያ');
        // CRUD::column('job_code')->label('የመደብ መታወቂያ ቁጥር');
        CRUD::column('level_id')->type('select')->entity('level')->model(Level::class)->attribute('name')->label('Job level');
        // CRUD::column('job_title_category_id')->type('hidden')->value($jobTitleCategory);

        CRUD::column('educational_level_id')->type('select')->entity('educationalLevel')->model(EducationalLevel::class)->attribute('name')->label('Min.Educational Req.');
        CRUD::column('work_experience')->label('Min. Experience');
        $jobTitleCategory = JobTitleCategory::find($jobTitleCategoryId);
        //$this->crud->setHeading('Job titles on ' . $jobTitleCategory->name);
       $this->crud->addClause('where', 'job_title_category_id', '=',$jobTitleCategoryId);
       $this->crud->addButtonFromModelFunction('line', 'view_employee', 'viewEmployee', 'end');
        $breadcrumbs = [
            'Admin' => route('dashboard'),
            'Job Title Categories' => route('job-title-category.index'),
            'Job Titles' => false,
        ];
        $this->data['breadcrumbs'] = $breadcrumbs;
        $this->crud->addFilter([
            'name'  => 'job_title_category_id',
            'type'  => 'select2_multiple',
            'label' => 'By job catergory'
        ], function () {
            return \App\Models\JobTitleCategory::all()->pluck('name', 'id')->toArray();
        }, function ($values) {
            $this->crud->addClause('whereIn', 'job_title_category_id', json_decode($values));
        });
        $this->crud->addFilter([
            'name'  => 'unit_id',
            'type'  => 'select2_multiple',
            'label' => 'By organizational unit'

        ], function () {
            return \App\Models\Unit::all()->pluck('name', 'id')->toArray();
        }, function ($values) {
            $this->crud->addClause('whereIn', 'unit_id', json_decode($values));
        });
        $this->crud->addFilter([
            'name'  => 'educational_level_id',
            'type'  => 'select2_multiple',
            'label' => 'By educational level'

        ], function () {
            return \App\Models\EducationalLevel::all()->pluck('name', 'id')->toArray();
        }, function ($values) {
            $this->crud->addClause('whereIn', 'educational_level_id', json_decode($values));
        });



        $this->crud->addFilter([
            'name'  => 'field_of_study_id',
            'type'  => 'select2_multiple',
            'label' => 'By field of study'

        ], function () {
            return \App\Models\FieldOfStudy::all()->pluck('name', 'id')->toArray();
        }, function ($values) {
            $this->crud->addClause('whereIn', 'field_of_study_id', json_decode($values));
        });


        $this->crud->addFilter([
            'name'  => 'level_id',
            'type'  => 'select2_multiple',
            'label' => 'By job grade'

        ], function () {
            return \App\Models\Level::all()->pluck('name', 'id')->toArray();
        }, function ($values) {
            $this->crud->addClause('whereIn', 'level_id', json_decode($values));
        });





        // $this->crud->addFilter(
        //     [
        //         'name'       => 'static_salary ',
        //         'type'       => 'range',
        //         'label'      => 'By Gross salary',
        //         'label_from' => 'min value',
        //         'label_to'   => 'max value',
        //         'size' => 5
        //     ],
        //     false,
        //     function ($value) { // if the filter is active
        //         $range = json_decode($value);
        //         if ($range->from) {
        //             $this->crud->addClause('where', 'static_salary ', '>=', (float) $range->from);
        //         }
        //         if ($range->to) {
        //             $this->crud->addClause('where', 'static_salary ', '<=', (float) $range->to);
        //         }
        //     }
        // );


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
        CRUD::setValidation(JobTitleRequest::class);
        $jobTitleCategoryId = \Route::current()->parameter('job_title_category');
        $breadcrumbs = [
            'Admin' => route('dashboard'),
            'Job Title Categories' => route('job-title-category.index'),
            JobTitleCategory::find($jobTitleCategoryId)->name => route('job-title-category/{job_title_category}/job-title.index', ['job_title_category' => $jobTitleCategoryId]),
            'Add' => false,
        ];
        $this->data['breadcrumbs'] = $breadcrumbs;
        $this->crud->setHeading('Add Job title in');
        $this->crud->setSubHeading(JobTitleCategory::find($jobTitleCategoryId)->name);
        CRUD::field('name')->label('Job title')->label('የስራመደቡ መጠሪያ')->size(6);
        CRUD::field('work_experience')->label(' Relevant minimum work experience')->size(3);
        CRUD::field('total_minimum_work_experience')->label('Total Relevant minimum work experience')->size(3);
        // CRUD::field('job_code')->label('የመደብ መታወቂያ ቁጥር')->size(6);
        CRUD::field('job_title_category_id')->type('hidden')->value($jobTitleCategoryId);
        // CRUD::field('job_title_category_id')->type('select2')->entity('jobTitleCategory')->model(JobTitleCategory::class)->attribute('name')->size(4);
        CRUD::field('position_type_id')->label('Position Type')->type('select2')->model(PositionType::class)->size(4)->attribute('title');
        CRUD::field('level_id')->label('Job grade')->type('select2')->entity('level')->model(Level::class)->attribute('name')->size(4);
        CRUD::field('educational_level_id')->type('select2')->entity('educationalLevel')->model(EducationalLevel::class)->attribute('name')->size(4);

        // CRUD::field('unit_id')->label('የስራ መደቡ የሚገኝበት የሥራክፍል')->type('select2')->entity('unit')->model(Unit::class)->attribute('name')->size(6);
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
