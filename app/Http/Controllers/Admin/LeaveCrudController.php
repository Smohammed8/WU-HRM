<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\LeaveRequest;
use App\Models\Leave;
use App\Models\User;
use App\Models\TypeOfLeave;
use Illuminate\Http\Request;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Andegna\DateTimeFactory;
use App\Models\Demotion;
use App\Models\JobTitle;
use App\Models\Misconduct;
use App\Models\Promotion;
use App\Models\TypeOfMisconduct;
use App\Models\Unit;
use DateTime;
use Dompdf\Dompdf;
use Dompdf\Options;
use PDF;

/**
 * Class LeaveCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class LeaveCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\ReviseOperation\ReviseOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitUpdate; } //IMPORTANT HERE


    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Leave::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/leave');
        CRUD::setEntityNameStrings('leave', 'leaves');
        $this->crud->orderBy('id','DESC');

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
        CRUD::column('type_of_leave_id');
        CRUD::column('created_by_id');
        CRUD::column('approved_by_id');
        CRUD::column('due_date');
        CRUD::column('status');
        CRUD::column('description');


        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }


    function addDayswithdate($date, $days){

            $date = strtotime("+".$days."days",strtotime($date));

            return date("Y-m-d",$date);
    }

/*
$gregorian = new DateTime('now');
$ethiopic = Andegna\DateTimeFactory::fromDateTime($gregorian);

// but we provided some shortcuts
$now1 = \Andegna\DateTimeFactory::now();
$now2 = new DateTime();

// if you wanna specify time zone
$sheger = new DateTimeZone('Africa/Addis_Ababa');
$now3 = \Andegna\DateTimeFactory::now($sheger);



$tomorrow = Carbon::now()->addDay();
$lastWeek = Carbon::now()->subWeek();
$nextSummerOlympics = Carbon::createFromDate(2016)->addYears(4);



if (Carbon::now()->isWeekend()) {
    echo 'Party!';
}
echo Carbon::now()->subMinutes(2)->diffForHumans(); // '2 minutes ago'
*/
    public function create(Request $request){

        $leave          = $request->get('leave_type');
        $employee       = $request->get('employee');
        $ldate          = $request->get('ldate');
        $days             = $request->get('days');
        $comment            = $request->get('comment');
        $status = 'Leave out';
        $date =  DateTime::createFromFormat('d/m/Y', $ldate);
        $year = $date->format('Y');
        $month = $date->format('m');
        $day = $date->format('d');;
        $sGC = DateTimeFactory::of($year, $month, $day)->toGregorian();
        $leave_date = $sGC->format('Y/m/d');
        $dudate = $this->addDayswithdate($leave_date,$days);

        $current_time = Carbon::now()->toDateTimeString();
        /*  if(Carbon::now() > cdate) */

          if($current_time  >  $leave_date){

           return redirect()->route('employee.show')->with('error', 'Leave date must be the past!');
          }

          $leave =  Leave::create(['type_of_leave_id'=>$leave,
                           'employee_id'=>$employee,
                           'created_by_id'=>1,
                           'approved_by_id'=>1,
                           'created_at '=>now(),
                           'leave_date'=>$leave_date,
                           'due_date'=>$dudate,
                           'status'=>$status,
                           'description'=>$comment

                        ]);

                 if ($leave) {
                    //         return response()->json(['status' => 'success', 'message' =>'Employee leave has been created!']);
                    //     }
                    //     return response()->json(['status' => 'failed', 'message' => 'Failed! Leave not created']);
                    // }
                    return redirect()->route('employee.show',$employee)->with('message', 'Employee leave out successful!');


                }

                }


    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(LeaveRequest::class);

        CRUD::field('employee_id')->type('select2')->size(6);
        CRUD::field('type_of_leave_id')->type('select2')->entity('typeOfLeave')->model(TypeOfLeave::class)->attribute('name')->size(6);
        CRUD::field('created_by_id')->type('hidden');
        CRUD::field('approved_by_id')->type('hidden');
        CRUD::field('due_date')->type('hidden');
        CRUD::field('status')->type('hidden');
        CRUD::field('duration_in_days')->type('number')->size(6);
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
