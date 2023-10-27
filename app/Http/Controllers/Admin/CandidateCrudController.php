<?php

namespace App\Http\Controllers\Admin;

use App\Constants;
use App\Http\Requests\CandidateRequest;
use App\Models\EducationalLevel;
use App\Models\FieldOfStudy;
use App\Models\Vacancy;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Prologue\Alerts\Facades\Alert;
use Illuminate\Support\Facades\Route;

/**
 * Class CandidateCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CandidateCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    public $vacancy;
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {


        CRUD::setModel(\App\Models\Candidate::class);
        $this->vacancy = Vacancy::find(Route::current()->parameter('vacancy'));
        CRUD::setRoute(config('backpack.base.route_prefix') . '/vacancy/' . $this->vacancy?->id . '/candidate');
        CRUD::setEntityNameStrings('candidate', 'candidates');
        $this->setupBreadcrumb();
        if (Carbon::createFromDate(Constants::etToGc($this->crud->getCurrentEntry()->vacancy->registration_end_date))->lessThan(Carbon::now())) {
            $this->crud->denyAccess('delete');
            $this->crud->denyAccess('update');
            $this->crud->denyAccess('create');
            $this->crud->addButtonFromModelFunction('top', 'screen', 'screen', 'end');
        } else {
            $this->crud->addButtonFromModelFunction('line', 'add_mark', 'addMark', 'beginning');
        }
    }
    public function setupBreadcrumb()
    {
        $breadcrumbs = [
            'Admin' => route('dashboard'),
            'Vacancies' => route('vacancy.index'),
            'Candidates' => route('vacancy/{vacancy}/candidate.index', ['vacancy' => $this->vacancy->id]) . '#employee_address',
        ];
        $text = $this->vacancy->position->jobTitle->name . ' Vacancy Candidates';
        if (in_array('show', explode('/', $this->crud->getRequest()->getRequestUri()))) {
            $breadcrumbs['Preview'] = false;
        }
        if (in_array('edit', explode('/', $this->crud->getRequest()->getRequestUri()))) {
            $breadcrumbs['Update'] = false;
        }
        if (in_array('create', explode('/', $this->crud->getRequest()->getRequestUri()))) {
            // $text .= ' Add';
            $breadcrumbs['Add'] = false;
        }
        $this->crud->setHeading($text);
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
        $vacancy = $this->vacancy;
        if ($this->vacancy->type == "Internal") {
            CRUD::column('full_name')->type('closure')->function(function ($entry) use ($vacancy) {
                $employee = $entry?->employee;
                if (!$employee) {
                    abort(404, 'Incorrect data found');
                }
                return $employee?->name;
            });
            CRUD::column('dob')->label('Date of birth')->type('closure')->function(function ($entry) use ($vacancy) {
                $employee = $entry->employee;
                if (!$employee) {
                    abort(404, 'Incorrect data found');
                }
                return $employee?->date_of_birth;
            });
            CRUD::column('disablity_status')->type('boolean');

            CRUD::column('educational_level_id')->type('closure')->function(function ($entry) use ($vacancy) {
                $employee = $entry->employee;
                if (!$employee) {
                    abort(404, 'Incorrect data found');
                }
                return $employee?->educationLevel?->name;
            });
        } else {
            CRUD::column('full_name')->type('closure')->function(function ($entry) use ($vacancy) {
                return 'asd';
            });
            CRUD::column('dob');
            CRUD::column('fieldOfStudy')->label('Field of study')->type('select')->entity('fieldOfStudy')->model(FieldOfStudy::class)->attribute('name');
            CRUD::column('educationalLevel');
        }
        CRUD::column('mark');

        if (Carbon::createFromDate(Constants::etToGc($this->crud->getCurrentEntry()->vacancy->registration_end_date))->lessThan(Carbon::now())) {
            $this->crud->denyAccess('delete');
            $this->crud->denyAccess('update');
            $this->crud->denyAccess('create');
            $this->crud->addButtonFromModelFunction('top', 'screen', 'screen', 'end');
        } else {
            $this->crud->addButtonFromModelFunction('line', 'add_mark', 'addMark', 'beginning');
        }
        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    protected function addMark(Request $request)
    {
        $request->validate([
            'mark' => 'required',
        ]);
        $this->crud->getCurrentEntry()->update(['mark' => $request->get('mark')]);
        Alert::add('success', 'Mark added successfully');
        return redirect()->back();
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(CandidateRequest::class);
        CRUD::field('vacancy_id')->type('hidden')->value($this->vacancy->id);
        if ($this->vacancy->type == 'Internal') {
            CRUD::field('employee_id')->type('select2')->attribute('name')->size(6);
        } else {
            CRUD::field('first_name')->size(6);
            CRUD::field('father_name')->size(6);
            CRUD::field('grand_father_name')->size(6);
            // CRUD::field('')->type->size(6);
            CRUD::field('field_of_study_id')->size(6)->type('select2')->entity('fieldOfStudy')->model(FieldOfStudy::class)->attribute('name');
            CRUD::field('educational_level_id')->size(6)->type('select2')->entity('educationalLevel')->model(EducationalLevel::class)->attribute('name');
            CRUD::field('dob')->size(6);
            CRUD::field('gpa')->size(6);
            CRUD::field('gender')->type('enum')->size(6);
            CRUD::field('email')->size(6);
            CRUD::field('phone')->size(6);
            CRUD::field('year_of_graduation')->size(6);
            CRUD::field('nationality_id')->size(6);
            CRUD::field('total_experience')->size(6)->min(0);
            CRUD::field('job_position_experience')->size(6)->min(0);
        }
        CRUD::field('disablity_status')->type('boolean')->size(6);

        //  CRUD::field('mark')->size(6);

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
