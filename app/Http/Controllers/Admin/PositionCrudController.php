<?php

namespace App\Http\Controllers\Admin;

use App\Constants;
use App\Http\Requests\PositionRequest;
use App\Models\CollegePositionCode;
use App\Models\JobTitle;
use App\Models\Unit;
use App\Models\MinimumRequirement;
use App\Models\Position;
use App\Models\PositionCode;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Validation\ValidationException;
use Prologue\Alerts\Facades\Alert;
use Illuminate\Support\Facades\Route;
/**
 * Class PositionCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PositionCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\ReviseOperation\ReviseOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation {
        update as traitUpdate;
    } //IMPORTANT HERE
    //use \Backpack\CRUD\app\Http\Controllers\Operations\CloneOperation;
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(Position::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/position');
        CRUD::setEntityNameStrings('position', 'positions');
        CRUD::disablePersistentTable();
        CRUD::enableExportButtons();
        $this->crud->setShowView('position.show');
        $this->setupPermission();
    }

    public function setupPermission()
    {
        $permission_base = 'position';
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
            if ($explodedRoute[count($explodedRoute) - 1] == 'position' && !backpack_user()->can($permission_base . '.index')) {
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
        CRUD::column('unit.name')->label('Organizational unit');
        CRUD::column('job_title_id')->type('select')->entity('jobTitle')->model(JobTitle::class)->attribute('name')->size(4);
   
        CRUD::column('range')->label('Job Code Range')->type('model_function')->function_name('positionRange');
        CRUD::column('available_for_placement')->label('Open for candidates')->type('boolean');
        // CRUD::column('total_employees')->label('Total Positions')->type('model_function')->function_name('totalPositions')
        
        CRUD::column('total_employees')->type('closure')->function(function ($entry) {
            return $entry->totalPositions() ?? '-';
        })->label('Permitted Positions')->wrapper([
            'element' => 'span',
            'class' => function ($crud, $column, $entry) {
                switch ($entry->totalPositions()) {
                    case '0':
                        return 'badge badge-pill badge-danger';
                    case '1':
                        return 'badge badge-pill badge-warning';
                    default:
                        return 'badge badge-pill badge-info';

                }
            }
        ]);
        CRUD::column('occupied_positions')->type('closure')->function(function ($entry) {
            return $entry->totalOccupiedPositions() ?? '-';
        })->label('Occupied Positions')->wrapper([
            'element' => 'span',
            'class' => function ($crud, $column, $entry) {
                switch ($entry->totalOccupiedPositions()) {
                    case '0':
                        return 'badge badge-pill badge-info border';
                    case '1':
                        return 'badge badge-pill badge-info border';
                    default:
                        return 'badge badge-pill badge-info border';
                        

                }
            }
        ]);
            CRUD::column('free_positions')->type('closure')->function(function ($entry) {
                return $entry->totalFreePositions() ?? '-';
            })->label('Free Positions')->wrapper([


            'element' => 'span',
            'class' => function ($crud, $column, $entry) {
                switch ($entry->totalFreePositions()) {
                    case '0':
                        return 'badge badge-pill badge-danger  border';
                    case '1':
                        return 'badge badge-pill badge-warning border';
                    default:
                        return 'badge badge-pill badge-info border';

                }
            }
        ]);


        // CRUD::column('status')->label('Free Positions')->type('select_from_array')->options(Constants::POSITION_STATUS);

        $this->crud->addFilter([
            'name'  => 'unit_id',
            'type'  => 'select2',
            'label' => 'Filter by organizational unit'
        ], function () {
            return Unit::all()->pluck('name', 'id')->toArray();
        }, function ($value) {
            $this->crud->addClause('where', 'unit_id', $value);
        });
//////////////////////////////////////////////////////
       $this->crud->addFilter([
        'type'  => 'select2',
        'name'  => 'job_title_id',
        'label' => 'Fileter by Job title',
    ], function () {
        
        return jobTitle::pluck('name', 'id')->toArray();
    }, function ($value) {
       
        $this->crud->addClause('where', 'job_title_id', $value);
    });
//////////////////////////////////////////////////////////////
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
        CRUD::setValidation(PositionRequest::class);

        CRUD::field('unit_id')->label('Organizational unit')->size(6);
        CRUD::field('job_title_id')->type('select2')->entity('jobTitle')->model(JobTitle::class)->attribute('name')->size(6);

        CRUD::field('job_code_prefix')->size(3)->help('Help text');
        CRUD::field('job_code_starting_number')->size(3);
        CRUD::field('total_employees')->label('Total number of permitted positions')->size(3);
        CRUD::field('position_available_for_placement')->label('No of open positions for candidates')->size(3);
        CRUD::field('available_for_placement')->label('Available for placement')->value(true)->size(3);

        // CRUD::field('status')->type('select_from_array')->options(Constants::POSITION_STATUS)->size(6);

        /**
         * Fields can be d(efined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
    }


    public function store()
    {

    
        $this->crud->hasAccessOrFail('create');
        $request = $this->crud->validateRequest();
       // $this->crud->getRequest();
        $data = $this->crud->getStrippedSaveRequest();
        $jobCodePrefix = $data['job_code_prefix'];
        $jobCodeStartingNumber = $data['job_code_starting_number'];
        $jobTitle =  $data['job_title_id'];
        $unit =  $data['unit_id'];

        if($data['total_employees']==0){

            throw ValidationException::withMessages(['total_employees' => 'Empty position is not allowed to create! at least it should be one.']);

        }

        if(PositionCode::where('code', $jobCodePrefix . $jobCodeStartingNumber)->count()>0){
            throw ValidationException::withMessages(['job_code_prefix' => 'Duplicate position code found','job_code_starting_number' => 'Duplicate position code found']);
        }
    
        // unset($data['total_employees']);
        $item = $this->crud->create($data);
        $this->data['entry'] = $this->crud->entry = $item;
        $counter = $jobCodeStartingNumber;
        for($currentCodeNumber = $jobCodeStartingNumber;$currentCodeNumber<$jobCodeStartingNumber+$data['total_employees'];) {
            $code = $jobCodePrefix.$counter;
            $counter++;
            if(PositionCode::where('code',$code)->count()==0){
                $currentCodeNumber++;
                PositionCode::firstOrCreate(['code'=>$code],['position_id'=>$item->id,'code'=>$code]);
            }
        }
        Alert::success(trans('backpack::crud.insert_success'))->flash();
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
        // $this->setupCreateOperation();
        CRUD::field('unit_id')->label('Organizational unit')->size(6);
        CRUD::field('job_title_id')->type('select2')->entity('jobTitle')->model(JobTitle::class)->attribute('name')->size(6);
        CRUD::field('position_available_for_placement')->label('No of available for placement')->size(3);
        CRUD::field('available_for_placement')->value(true)->size(3);
        CRUD::field('job_code_prefix')->value(null)->size(3)->type('hidden');
        CRUD::field('job_code_starting_number')->value(0)->size(3)->type('hidden');
        CRUD::field('total_employees')->value(0)->label('No of vacant posts')->size(3)->type('hidden');
    }

    protected function setupShowOperation()
    {
        $position_id = $this->crud->getCurrentEntryId();
      
        $minimumRequirements = MinimumRequirement::where('position_id', $this->crud->getCurrentEntryId())->paginate(10);
        $this->data['minimumRequirements'] = $minimumRequirements;
        
        $positionCodes = PositionCode::where('position_id',  $position_id)->orderBy('id', 'desc')->paginate(20);
        $this->data['positionCodes'] = $positionCodes;

        $prefixes = CollegePositionCode::all();
        $this->data['prefixes'] = $prefixes;
    }
}


