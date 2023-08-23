<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\jobTitlePrerequestsRequest;
use App\Models\JobTitle;
use App\Models\JobTitleCategory;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class jobTitlePrerequestsCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class jobTitlePrerequestsCrudController extends CrudController
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
        CRUD::setModel(\App\Models\jobTitlePrerequests::class);
        $jobTitle= \Route::current()->parameter('job_title');
       // CRUD::setRoute(config('backpack.base.route_prefix') . '/job-title-prerequests');
        CRUD::setRoute(config('backpack.base.route_prefix') . '/job-title/' . $jobTitle. '/job-title-prerequest');
     
        CRUD::setEntityNameStrings('job title prerequests', 'job title prerequests');
        $this->setupPermission();
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */

        protected function setupListOperation()
        {

       
            $jobTitleId = \Route::current()->parameter('job_title');
            $this->crud->setHeading('List of field of study in');
            $this->crud->setSubHeading(JobTitle::find($jobTitleId)->name);
            CRUD::column('job_title.name')->label("Experince");
            $this->crud->addClause('where', 'job_title_id', '=',$jobTitleId);
            $breadcrumbs = [
                'Admin' => route('dashboard'),
                'Job Title' => route('job-title.index'),
                'Related fields' => false,
            ];
            $this->data['breadcrumbs'] = $breadcrumbs;
    
            /**
             * Columns can be defined using the fluent syntax or array syntax:
             * - CRUD::column('price')->type('number');
             * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
             */
        }

     //   CRUD::setFromDb(); // columns

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
    

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    // protected function setupCreateOperation()
    // {
    //     CRUD::setValidation(jobTitlePrerequestsRequest::class);

    //     CRUD::setFromDb(); // fields

    //     /**
    //      * Fields can be defined using the fluent syntax or array syntax:
    //      * - CRUD::field('price')->type('number');
    //      * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
    //      */
    // }


    protected function setupCreateOperation()
    {
        $jobTitleId = \Route::current()->parameter('job_title');
        $breadcrumbs = [
            'Admin' => route('dashboard'),
            'Job Title' => route('job-title.index'),
            'Job title prerequests' => route('job-title/{job_title}/job_title_prerequest.index',['job_title'=>$jobTitleId]),
            'Add' => false,
        ];
        $this->data['breadcrumbs'] = $breadcrumbs;

        CRUD::setValidation(RelatedWorkRequest::class);

        CRUD::field('job_title_id ')->type('hidden')->value($jobTitleId);
        CRUD::field('job_prerequest_id')->type('select2')->entity('jobTitle')->model(JobTitle::class)->attribute('name');
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
