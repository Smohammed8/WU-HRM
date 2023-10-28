<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PositionCodeRequest;
use App\Models\CollegePositionCode;
use App\Models\PositionCode;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use GuzzleHttp\Psr7\Request;
use Illuminate\Validation\ValidationException;
use Prologue\Alerts\Facades\Alert;
use Illuminate\Support\Facades\Route;

/**
 * Class PositionCodeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PositionCodeCrudController extends CrudController
{
    // use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CloneOperation;
    use \Backpack\ReviseOperation\ReviseOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation {
        update as traitUpdate;
    } //IMPORTANT HERE

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(PositionCode::class);
        $position_id= Route::current()->parameter('position_id');
        CRUD::setRoute(config('backpack.base.route_prefix').'/position/'.$position_id. '/position-code');
        CRUD::setEntityNameStrings('position code', 'position codes');

        CRUD::disablePersistentTable();
        CRUD::enableExportButtons();
    

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
        CRUD::column('position_id');
        CRUD::column('code');

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
        CRUD::setValidation(PositionCodeRequest::class);

        CRUD::field('employee_id');
        CRUD::field('position_id');
        CRUD::field('code');

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
    }


    public function store()
    {
       
        $this->crud->hasAccessOrFail('create');
       
       // $this->crud->validateRequest(); 
        $this->crud->getRequest();
        $jobCodePrefix =  request()->job_code_prefix;
        $jobCodeStartingNumber = request()->job_code_starting_number;
        $position_id = request()->position_id;
        $total = request()->total_codes;

        if($total < 1 ){
                throw ValidationException::withMessages(['total_codes' => 'No of position should be at leeast one!']);
            }
        if($total > 700 ){
                throw ValidationException::withMessages(['total_codes' => 'Not permitted more than 700 at once!']);
        }

        if($total==1){
        if(PositionCode::where('code', $jobCodePrefix.$jobCodeStartingNumber)->count() >0){
            return redirect()->back()->withErrors(['job_code_starting_number' => 'Duplicated position code found!','job_code_prefix'=>'Duplicated position code found!']);
        }}

        $counter = $jobCodeStartingNumber;
       for($i = $jobCodeStartingNumber; $i < $jobCodeStartingNumber + $total;) {
            $code = $jobCodePrefix.$counter;
            $counter++;
            if (PositionCode::where('code', $code)->count()==0) {
                $i++;
                PositionCode::firstOrCreate(['code' => $code], ['position_id' =>$position_id, 'code' => $code]);
            }
           else {
               
                throw ValidationException::withMessages(['job_code_starting_number' => $jobCodePrefix.$i.' has been taken!']);
                break;
            }
       }
        Alert::success(trans('backpack::crud.insert_success'))->flash();
        $this->crud->setSaveAction();
        return redirect()->back();
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

    protected function setupShowOperation()
    {
        $prefixes = CollegePositionCode::all();
        $this->data['prefixes'] = $prefixes;
    }

    public function update()
    {
        $this->crud->hasAccessOrFail('update');

        // execute the FormRequest authorization and validation, if one is required
        $request = $this->crud->validateRequest();
        // update the row in the db
        if(PositionCode::where('code',$this->crud->getStrippedSaveRequest()['code'])->count()>0){
            throw ValidationException::withMessages(['code' => 'Please code should be unique','old_job_code'=>$this->crud->getCurrentEntry()->code]);
        }
        $this->crud->getCurrentEntry()->update(['code' => $this->crud->getStrippedSaveRequest()['code']]);
        // $item = $this->crud->update($this->crud->getCurrentEntry()->id,
        //                     [$this->crud->getStrippedSaveRequest()]);
        // $this->data['entry'] = $this->crud->entry = $item;

        // show a success message
        Alert::success(trans('backpack::crud.update_success'))->flash();
         $this->crud->setSaveAction();
        return redirect()->back();

        //return $this->crud->performSaveAction($item->getKey());
    }
}


