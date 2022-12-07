<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\RelatedWorkRequest;
use App\Models\FieldOfStudy;
use App\Models\JobTitle;
use App\Models\MinimumRequirement;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class RelatedWorkCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class RelatedWorkCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\RelatedWork::class);
        $jobTitleCategoryId = \Route::current()->parameter('job_title_category');
        CRUD::setRoute(config('backpack.base.route_prefix').'/job-title-category/'.$jobTitleCategoryId . '/related-work');
        CRUD::setEntityNameStrings('related field', 'related fields');
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
        CRUD::column('fieldOfStudy.name')->label("Field of study");
        $this->crud->addClause('where', 'job_title_categorie_id', '=',$jobTitleCategoryId);
        $breadcrumbs = [
            'Admin' => route('dashboard'),
            'Job Title Categories' => route('job-title-category.index'),
            'Related fields' => false,
        ];
        $this->data['breadcrumbs'] = $breadcrumbs;

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
        $jobTitleCategoryId = \Route::current()->parameter('job_title_category');
        $breadcrumbs = [
            'Admin' => route('dashboard'),
            'Job Title Categories' => route('job-title-category.index'),
            'Related fields' => route('job-title-category/{job_title_category}/related-work.index',['job_title_category'=>$jobTitleCategoryId]),
            'Add' => false,
        ];
        $this->data['breadcrumbs'] = $breadcrumbs;

        CRUD::setValidation(RelatedWorkRequest::class);

        CRUD::field('job_title_categorie_id')->type('hidden')->value($jobTitleCategoryId);
        CRUD::field('field_of_studie_id')->type('select2')->entity('fieldOfStudy')->model(FieldOfStudy::class)->attribute('name');
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
