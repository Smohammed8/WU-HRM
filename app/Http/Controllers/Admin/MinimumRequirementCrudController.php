<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\MinimumRequirementRequest;
use App\Models\EducationalLevel;
use App\Models\JobTitle;
use App\Models\MinimumRequirement;
use App\Models\RelatedWork;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class MinimumRequirementCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class MinimumRequirementCrudController extends CrudController
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
        CRUD::setModel(\App\Models\MinimumRequirement::class);
        $positionId = \Route::current()->parameter('position');
        CRUD::setRoute(config('backpack.base.route_prefix') . '/' . $positionId . '/minimum-requirement');
        CRUD::setEntityNameStrings('minimum requirement', 'minimum requirements');
        $this->crud->setEditView('minimum_requirement.edit');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('Job Title')->type('model_function')->function_name('getPositionJobTitleName');
        CRUD::column('Unit ')->type('model_function')->function_name('getPositionUnitName');
        CRUD::column('experience');
        CRUD::column('educational_level_id')->type('select')->entity('educationalLevel')->model(EducationalLevel::class)->attribute('name');
        // CRUD::column('minimum_efficeny');
        CRUD::column('minimum_employee_profile_value');

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
        $positionId = \Route::current()->parameter('position');
        CRUD::setValidation(MinimumRequirementRequest::class);
        CRUD::field('position_id')->type('hidden')->value($positionId);
        CRUD::field('experience');
        CRUD::field('educational_level_id')->type('select2')->entity('educationalLevel')->model(EducationalLevel::class)->attribute('name');
        CRUD::field('minimum_efficeny');
        CRUD::field('minimum_employee_profile_value');
        CRUD::field('related_jobs')->type('select2_multiple')->entity('relatedJobs')->model(JobTitle::class)->attribute('name');
        $this->data['breadcrumbs'] = [
            trans('backpack::crud.admin') => backpack_url('dashboard'),
            'Positions' => route('position.index'),
            'Preview' => route('position.show', ['id' => $positionId]),
            'Minimum Requirements' => false,
        ];
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

    /**
     * Store a newly created resource in the database.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {

        $this->crud->hasAccessOrFail('create');

        // execute the FormRequest authorization and validation, if one is required
        $request = $this->crud->validateRequest();

        // insert item in the db
        $item = $this->crud->create($this->crud->getStrippedSaveRequest());
        $relatedJobs = $this->crud->getStrippedSaveRequest()['related_jobs'];
        foreach ($relatedJobs as $relatedJob) {
            RelatedWork::create([
                'minimum_requirement_id' => $item->id,
                'job_title_id' => $relatedJob,
            ]);
        }
        $this->data['entry'] = $this->crud->entry = $item;

        // show a success message
        \Alert::success(trans('backpack::crud.insert_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        return $this->crud->performSaveAction($item->getKey());
    }
    /**
     * Update the specified resource in the database.
     *
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        $this->crud->hasAccessOrFail('update');

        // execute the FormRequest authorization and validation, if one is required
        $request = $this->crud->validateRequest();
        // update the row in the db
        $item = $this->crud->update(
            $request->get($this->crud->model->getKeyName()),
            $this->crud->getStrippedSaveRequest()
        );
        $this->data['entry'] = $this->crud->entry = $item;
        if (array_key_exists('related_jobs', $this->crud->getStrippedSaveRequest())) {
            $relatedJobs = $this->crud->getStrippedSaveRequest()['related_jobs'];

            foreach ($relatedJobs as $relatedJob) {
                if (RelatedWork::where('minimum_requirement_id', $this->crud->entry->id)->where('job_title_id', $relatedJob)->count() == 0)
                    RelatedWork::create([
                        'minimum_requirement_id' => $item->id,
                        'job_title_id' => $relatedJob,
                    ]);
            }
        }
        // show a success message
        \Alert::success(trans('backpack::crud.update_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        return $this->crud->performSaveAction($item->getKey());
    }
}
