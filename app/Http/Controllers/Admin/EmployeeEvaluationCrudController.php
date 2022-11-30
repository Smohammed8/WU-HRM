<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\EmployeeEvaluationRequest;
use App\Models\EmployeeEvaluation;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\EvaluationLevel;
use App\Models\EvalutionCreteria;
use App\Models\Unit;
use App\Models\Evaluation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Database\DatabaseManager as DB;

/**
 * Class EmployeeEvaluationCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class EmployeeEvaluationCrudController extends CrudController
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
        CRUD::setModel(\App\Models\EmployeeEvaluation::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/employee-evaluation');
        CRUD::setEntityNameStrings('employee evaluation', 'employee evaluations');
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
        CRUD::column('evalution_creteria_id');
        CRUD::column('evaluation_level_id');
        CRUD::field('obtained_mark');



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


   public function create(Request $request){

   // dd(Auth::guard('backpack')->user()->id);
    $quarter            = $request->get('quarter');
    $year               = $request->get('year');
    $criterai           = $request->get('criteria');
    $employee           = $request->get('employee');
    $level              = $request->get('level');

    $evalution =  Evaluation::create([
        'quarter_id' =>$quarter,
        'employee_id'=>$employee,
        'total_mark' =>0,
      //  'created_by_id'=>Auth::user()->id
        'created_by_id'=>backpack_user()->id
         ]);
if($evalution->id){
foreach ($criterai as $key => $id) {
    $evluation_id =  $evalution->id;
     EmployeeEvaluation::create([
                'employee_id'=>$employee,
                'evalution_creteria_id'=>$id,
                'evaluation_level_id'=>$request->get('level'.$id)[0],
                'evaluation_id'=>$evluation_id,
          ]);
  }

}

 return redirect()->route('employee.show',$employee)->with('message', 'Employee efficiency added successfully!');
}

public function evaluation_show($evaluation_id){


   // $payroll=  EmployeeEvaluation::findOrFail($evaluation_id);
    // $training_centers = TraininingCenter::all();
    // $training_sessions = TrainingSession::all();
     $employeeEvaluations = EmployeeEvaluation::select('*')->where('evaluation_id', '=',$evaluation_id)->paginate(10);

     return view('employee.efficinecy_show', compact('employeeEvaluations'));

 }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(EmployeeEvaluationRequest::class);

        CRUD::field('employee_id')->type('select2')->size(6);

        CRUD::field('evaluation_level_id')->type('select2')->entity('evaluationLevel')->model(EvaluationLevel::class)->attribute('name')->size(6);
        CRUD::field('evalution_creteria_id')->type('select2')->entity('evalutionCreteria')->model(EvalutionCreteria::class)->attribute('name')->size(6);

      //  CRUD::field('obtained_mark')->size(6);

        $this->crud->addField([
            'name'        => 'obtained_mark',
            'label'       => 'Obtained mark[5]',
            'type'        => 'radio',
            'default'      => 0,
            'options'     => [
                             4 => "Excellent[4]",
                             3 => "Very good[3]",
                             2 => "Good [2]",
                             1 => "Poor [1]"
                             ],
                             'inline' => true,
                             'label' => 'Questions',

        ]);

        CRUD::field('unit_id')->type('select2')->entity('unit')->model(Unit::class)->attribute('name')->size(6);
        CRUD::field('comment');

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

    protected function setupShowOperation()
    {

        $employeeEvaluations= EmployeeEvaluation::paginate(10);
        $this->data['employeeEvaluations'] = $employeeEvaluations;
        $evalutionCreterias=  EvalutionCreteria::paginate(20);
        $this->data['evalutionCreterias'] = $evalutionCreterias;


        // Note: if you HAVEN'T set show.setFromDb to false, the removeColumn() calls won't work
        // because setFromDb() is called AFTER setupShowOperation(); we know this is not intuitive at all
        // and we plan to change behaviour in the next version; see this Github issue for more details
        // https://github.com/Laravel-Backpack/CRUD/issues/3108
    }
}
