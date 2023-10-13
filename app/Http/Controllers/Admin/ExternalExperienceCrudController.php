<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ExternalExperienceRequest;
use App\Models\JobTitle;
use App\Models\EmploymentType;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Validation\ValidationException;
use Prologue\Alerts\Facades\Alert;

/**
 * Class ExternalExperienceCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ExternalExperienceCrudController extends CrudController
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
        CRUD::setModel(\App\Models\ExternalExperience::class);
        $employeeId = \Route::current()->parameter('employee');

        CRUD::setRoute(config('backpack.base.route_prefix') .'/'.$employeeId. '/external-experience');
        CRUD::setEntityNameStrings('external experience', 'external experiences');
        $this->setupBreadcrumb();
    }


    public function setupBreadcrumb()
    {
        $employeeId = \Route::current()->parameter('employee');
        $breadcrumbs = [
            'Admin' => route('dashboard'),
            'Employees' => route('employee.index'),
            ucfirst($this->crud->entity_name_plural) => route('employee.show',['id'=>$employeeId]).'#employee_external_experience',
        ];
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

    // /**
    //  * Define what happens when the List operation is loaded.
    //  *
    //  * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
    //  * @return void
    //  */
    // protected function setupListOperation()
    // {
    //     CRUD::column('employee_id');
    //     CRUD::column('unit_id');
    //     CRUD::column('job_title');
    //     CRUD::column('company_name');
    //     CRUD::column('start_date');
    //     CRUD::column('end_date');
    //     CRUD::column('comment');

    //     /**
    //      * Columns can be defined using the fluent syntax or array syntax:
    //      * - CRUD::column('price')->type('number');
    //      * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
    //      */
    // }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        $employeeId = \Route::current()->parameter('employee');

        CRUD::setValidation(ExternalExperienceRequest::class);

        CRUD::field('employee_id')->type('hidden')->value($employeeId);
       
        // CRUD::field('job_title_id')->type('select2')->entity('jobTitle')->model(JobTitle::class)->attribute('name')->size(6);

        CRUD::field('job_title_id')->size(6);
        CRUD::field('company_name')->size(6);
        CRUD::field('employment_type_id')->type('select2')->entity('  employmentType')->model(EmploymentType::class)->attribute('name')->size(6);
        CRUD::field('start_date')->size(6);
        CRUD::field('end_date')->size(6);
        CRUD::field('comment');

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
    }


    public function store()
    {
        $this->crud->hasAccessOrFail('create');
        $request = $this->crud->validateRequest();
        $data = $this->crud->getStrippedSaveRequest();
         if ($data['start_date'] >= $data['end_date']) {
            throw ValidationException::withMessages(['start_date' => 'Start-date must be less than End-date!']);
        } 
        $item = $this->crud->create($data);
        $this->data['entry'] = $this->crud->entry = $item;
        Alert::success(trans('backpack::crud.insert_success'))->flash();
        $this->crud->setSaveAction();
        return $this->crud->performSaveAction($item->getKey());
    }

    public function update()
    {
        $this->crud->hasAccessOrFail('update');
    
        $request = $this->crud->validateRequest();
        $data = $this->crud->getStrippedSaveRequest();
      if ($data['start_date'] >= $data['end_date']) {
            throw ValidationException::withMessages(['start_date' => 'Start-date must be less than End-date!']);
        }
        $item = $this->crud->create($data);
        $this->data['entry'] = $this->crud->entry = $item;
        Alert::success(trans('backpack::crud.update_success'))->flash();
        $this->crud->setSaveAction();
        return $this->crud->performSaveAction($item->getKey());

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
