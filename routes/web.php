<?php

use App\Http\Controllers\Admin\EmployeeCrudController;
use App\Http\Controllers\Admin\EmployeeEvaluationCrudController;
use App\Http\Controllers\Admin\LeaveCrudController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboard;
use App\Http\Controllers\EmployeeController;
use App\Models\Employee;
use App\Models\EmployeeEvaluation;

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
Route::get('/dashboard', function () {
     return view('dashboard');
})->name('dashboard');
// Registration Routes...
// Route::get('admin/register', [AuthController::class,'registerForm'])->name('register.form');
// Route::post('admin/register', [AuthController::class,'register']);
// // Registration Routes...
// Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('backpack.auth.register');
// Route::post('register', 'Auth\RegisterController@register');
Route::get('/home',[EmployeeController::class,'home'])->name('home')->middleware('auth');

Route::get('/home', function () {
    return view('home');
})->name('home');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/login',[AuthController::class,'userLoginView'])->name('login')->middleware('guest');
Route::post('/login_action',[AuthController::class,'login'])->name('login.auth')->middleware('guest');
//Route::post('insertbatch', [EmployeeCrudController::class, 'insertbatch'])->name('insertbatch');
Route::resource('employeeEvaluation', EmployeeEvaluationCrudController::class);
Route::resource('leave', LeaveCrudController::class);

//Route::get('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');

Route::get('{evaluation_id}/evaluation_show', [EmployeeEvaluationCrudController::class, 'evaluation_show'])->name('evaluation.evaluation_show');

// Route::group(['middleware' => 'web', 'prefix' => config('backpack.base.route_prefix', 'namespace' => 'Backpack\Base\app\Http\Controllers')], function () {
//     Route::auth();
//     Route::get('logout', 'Auth\LoginController@logout');
//     Route::get('dashboard', 'AdminController@dashboard');
//     Route::get('/', 'AdminController@redirect');
// });
