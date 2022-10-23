<?php

use App\Http\Controllers\Admin\EmployeeCrudController;
use App\Http\Controllers\Admin\EmployeeEvaluationCrudController;
use App\Http\Controllers\Admin\LeaveCrudController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboard;
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

Route::get('/dashboard', function () {
     return view('dashboard');
})->name('dashboard');

Route::get('/home', function () {
    return view('home');
})->name('home');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

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
