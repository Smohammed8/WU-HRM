<?php

namespace App\Http\Controllers\Admin;

use App\Constants;
use App\Http\Requests\PlacementChoiceRequest;
use App\Models\PlacementRound;
use App\Models\Position;
use App\Models\Unit;
use App\Models\Employee;
use App\Models\PlacementChoice;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Dotenv\Exception\ValidationException;
use Illuminate\Support\Facades\Redirect;
use Prologue\Alerts\Facades\Alert;
use App\Http\Requests\CreateTagRequest as StoreRequest;
use App\Http\Requests\UpdateTagRequest as UpdateRequest;
use App\Models\EvalutionCreteria;
use App\Models\JobTitle;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class PlacementChoiceCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PlacementChoiceCrudController extends CrudController
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
        CRUD::setModel(\App\Models\PlacementChoice::class);
        $placementRound = \Route::current()->parameter('placement_round');
        CRUD::setRoute(config('backpack.base.route_prefix') . '/placement-round/' . $placementRound . '/placement-choice');
        CRUD::setEntityNameStrings('placement choice', 'placement choices');
        $this->crud->setListView('placement_choice.show');

    }

   
     
    //  $positions = DB::table('positions')->where('unit_id',35)->count();
    

   public function result(){
          $units = Unit::where('id','=' ,35)->get();
         $positions = Position::all();  //35

         //  $positions = Position::where('unit_id','=' ,35)->get();

          $placements = DB::table('placement_choices')->count();
          $totalPositions = DB::table('positions')->count();
          
         // $placement_results = PlacementChoice::all()->paginate(10);
          $placement_results = PlacementChoice::all();
        
            return view('placement_result.index', compact('placement_results','units','positions','placements','totalPositions'));




               
   }


//    public function filter(Request $request){
  //  if ($request->has('filter')) {
//     $phone = $request->get('phone');
//     $woreda_id = $request->get('woreda_id');
//     $gpa = $request->get('gpa');
//     if (!empty($first_name)) {
//         $applicants = $applicants->where('first_name', 'like', '%' . $first_name . '%');
//     }
//     if (!empty($father_name)) {
//         $applicants = $applicants->where('father_name', 'like', '%' . $father_name . '%');
//     }
      //}

//    }

   public function details($new_position_id=null){


 
       $units = Unit::where('id','=' ,35)->get();
       $positions = Position::all();  //35
       $placements = DB::table('placement_choices')->count();
       $totalPositions = DB::table('positions')->count();


        $newPosition_id  = PlacementChoice::select('new_position')->where('new_position', '=', $new_position_id)->get()->first()->new_position;
        $jobtitle_id  = Position::select('job_title_id')->where('id', '=',$newPosition_id)->get()->first()->job_title_id;
        $new_position  = JobTitle::select('name')->where('id', '=',$jobtitle_id )->get()->first()->name;
       
       // dd( $new_position );
        $placement_results = PlacementChoice::select('*')->where('new_position', '=',$new_position_id)->get();

      // $placement_results = PlacementChoice::where('new_position','=',$new_position_id)->get();

       return view('placement_result.details', compact('placement_results','units','positions','placements','totalPositions','new_position'));

        }
    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->addFilter(
            [
                'name'  => 'choice_two_id',
                'type'  => 'select2_multiple',
                'label' => 'Who are apply for this postion?'
            ],
            function () {
                return \App\Models\Position::all()->pluck('name', 'id')->toArray();
            },
            function ($values) {

                $this->crud->addClause('whereIn', 'choice_two_id', json_decode($values));
            }
        );


        $placementRoundId = \Route::current()->parameter('placement_round');
        $placementRound = PlacementRound::find($placementRoundId);
        if ($placementRound->status == Constants::PLACEMENT_ROUND_STATUS_CLOSED) {
            $this->crud->removeAllButtons();
            //$this->crud->removeAllButtonsFromStack('line');
        }
        //$this->crud->removeAllButtonsFromStack('line');

        // if($this->crud->getCurrentEntry()){
        // }
        // CRUD::column('placementRound.round')->label('Round');
        CRUD::column('employee_id')->type('select')->entity('employee')->model(Employee::class)->attribute('name')->label('Employee');
        $this->crud->addColumn([
            'name'     => 'choiceOne.jobTitle.name',
            'label'    => 'Choice One',
            'type'     => 'closure',
            'function' => function ($entry) {
                return $entry->is_placement_choice_switched == true ? $entry->choiceTwo->name : $entry->choiceOne->name;
            }
        ]);
        $this->crud->addColumn([
            'name'     => 'choiceTwo.jobTitle.name',
            'label'    => 'Choice Two',
            'type'     => 'closure',
            'function' => function ($entry) {
                return $entry->is_placement_choice_switched == true ? $entry->choiceOne->name : $entry->choiceTwo->name;
            }
        ]);
        // CRUD::column('choiceOne.jobTitle.name')->label('Choice One');
        // CRUD::column('choiceTwo.jobTitle.name')->label('Choice Two');
        CRUD::column('choice_one_result')->label('Result One');
        CRUD::column('choice_two_result')->label('Result Two');
        CRUD::column('choice_one_rank')->label('Rank One');

        CRUD::column('choice_two_rank')->label('Rank Two');
        CRUD::column('new_position')->type('select')->model(Position::class)->entity('newPosition')->attribute('position_info')->label('New Position');
        $this->crud->denyAccess('show');

        // $this->crud->denyAccess('update');
        // $this->crud->denyAccess('delete');
        $placementRound = \Route::current()->parameter('placement_round');
        $this->data['placementRound'] = PlacementRound::find($placementRound);
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
        // $this->crud->setValidation(CreateRequest::class);

        $placementRound = \Route::current()->parameter('placement_round');
        CRUD::setValidation(PlacementChoiceRequest::class);
        CRUD::field('placement_round_id')->type('hidden')->value($placementRound);

        CRUD::field('employee_id')->type('select2')->entity('employee')->model(Employee::class)->attribute('name')->size(6);

        CRUD::field('choice_one_id')->type('select2')->model(Position::class)->entity('choiceOne')->attribute('position_info_for_placement')->size(6);
        CRUD::field('choice_two_id')->type('select2')->model(Position::class)->entity('choiceTwo')->attribute('position_info_for_placement')->size(6);
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
