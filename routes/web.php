<?php

use App\Constants;
use App\Http\Controllers\Admin\EmployeeCrudController;
use App\Http\Controllers\Admin\EmployeeEvaluationCrudController;
use App\Http\Controllers\Admin\LeaveCrudController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboard;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\IdAttributeController;
use App\Http\Controllers\IDCardController;
use App\Http\Controllers\IDController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\UnitController;
use App\Models\Unit;
use App\Models\Employee;
use App\Models\EmployeeEvaluation;
use App\Models\Unit as ModelsUnit;
use App\Score\ExperienceScore;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if(!backpack_user()){
        return redirect('logout');
    }
    if(!backpack_user()->hasRole(Constants::USER_TYPE_EMPLOYEE)){
        return redirect(route('dashboard'));
    }
    dd('sd');
    return redirect(route('home'));
});

Route::redirect('/admin/login','/home');
// Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');
// Route::redirect('/admin/login','/login');
// Route::get('/', function () {
//     return redirect(route('backpack.dashboard'));
// });
Route::redirect('/','/home');
Route::redirect('/admin/login','/login');
Route::get('/import', [ImportController::class, 'import']);
// Registration Routes...
// Route::get('admin/register', [AuthController::class,'registerForm'])->name('register.form');
// Route::post('admin/register', [AuthController::class,'register']);
// // Registration Routes...
// Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('backpack.auth.register');
// Route::post('register', 'Auth\RegisterController@register');
Route::get('/home',[EmployeeController::class,'home'])->name('home')->middleware(['admin']);
Route::get('import_page',[EmployeeController::class,'importPage']);
Route::post('import',[EmployeeController::class,'import']);
Route::get('/login',[AuthController::class,'userLoginView'])->name('login')->middleware('guest');
Route::post('/login',[AuthController::class,'login'])->name('login.auth')->middleware('guest');
//Route::post('insertbatch', [EmployeeCrudController::class, 'insertbatch'])->name('insertbatch');
Route::get('/calculate',[EmployeeController::class,'calculate']);
Route::resource('employeeEvaluation', EmployeeEvaluationCrudController::class);
// Route::resource('leave', LeaveCrudController::class);

Route::get( '/hierarchy', function () {$units = Unit::where('parent_unit_id')->latest()->get();
        return view('unit.tree', ['orgs' => $units]);
    }
)->name('hierarchy');


Route::get('{evaluation_id}/evaluation_show', [EmployeeEvaluationCrudController::class, 'evaluation_show'])->name('evaluation.evaluation_show');

Route::resource('idcard', IDCardController::class);
Route::get('idcard/{idcard}/show',[IDCardController::class, 'design'])->name('idcard.design');
Route::resource('attribute', IdAttributeController::class);
Route::post('{idcard}/save/design', [IDCardController::class, 'saveDesign'])->name('save.design');
Route::get('/employee/list', [IDCardController::class, 'printList'])->name('emp.list');
Route::get('{employee}/print/ID', [IDCardController::class, 'printID'])->name('print.id');