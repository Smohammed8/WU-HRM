<?php

use App\Http\Controllers\Admin\EmployeeCrudController;
use App\Http\Controllers\Admin\EmployeeEvaluationCrudController;
use App\Http\Controllers\Admin\LeaveCrudController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboard;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\UnitController;
use App\Models\Unit;
use App\Models\Employee;
use App\Models\EmployeeEvaluation;
<<<<<<< HEAD
use App\Models\Unit as ModelsUnit;
=======
>>>>>>> 93ea9f6 (solving issues)
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

// Route::get('/', function () {
//     return redirect(route('backpack.dashboard'));
// });
Route::redirect('/','/home');
<<<<<<< HEAD
<<<<<<< HEAD
Route::redirect('/admin/login','/login');
=======
Route::redirect('/admin/login','/home');
Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');
>>>>>>> 93ea9f6 (solving issues)
=======
Route::redirect('/admin/login','/login');
>>>>>>> d431a57 (importing)
// Registration Routes...
// Route::get('admin/register', [AuthController::class,'registerForm'])->name('register.form');
// Route::post('admin/register', [AuthController::class,'register']);
// // Registration Routes...
// Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('backpack.auth.register');
// Route::post('register', 'Auth\RegisterController@register');
<<<<<<< HEAD
Route::get('/home',[EmployeeController::class,'home'])->name('home')->middleware('auth');

Route::get('/home', function () {
    return view('home');
})->name('home');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

=======
>>>>>>> 93ea9f6 (solving issues)
Route::get('/home',[EmployeeController::class,'home'])->name('home')->middleware(['admin']);
Route::get('import_page',[EmployeeController::class,'importPage']);
Route::post('import',[EmployeeController::class,'import']);
Route::get('/login',[AuthController::class,'userLoginView'])->name('login')->middleware('guest');
Route::post('/login_action',[AuthController::class,'login'])->name('login.auth')->middleware('guest');
//Route::post('insertbatch', [EmployeeCrudController::class, 'insertbatch'])->name('insertbatch');
Route::resource('employeeEvaluation', EmployeeEvaluationCrudController::class);
// Route::resource('leave', LeaveCrudController::class);

Route::get( '/hierarchy', function () {$units = Unit::where('parent_unit_id')->latest()->get();
        return view('unit.tree', ['orgs' => $units]);
    }
)->name('hierarchy');


Route::get('{evaluation_id}/evaluation_show', [EmployeeEvaluationCrudController::class, 'evaluation_show'])->name('evaluation.evaluation_show');

