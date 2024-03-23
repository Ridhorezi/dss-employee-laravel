<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\AuthCotroller;
use App\Http\Controllers\CriteriaComparisonController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CriteriaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\SubcriteriaComparisonController;
use App\Http\Controllers\SubcriteriaController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [DashboardController::class, 'home'])->name('home');
Route::get('/login', [AuthCotroller::class, 'login'])->name('login');
Route::get('/logout', [AuthCotroller::class, 'logout'])->name('');
Route::post('/signin', [AuthCotroller::class, 'signin'])->name('signin');

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::middleware('role')->group(function () {

        Route::get('user', [UserController::class, 'index'])->name('user');
        Route::get('user/create', [UserController::class, 'create'])->name('user.create');
        Route::get('user/filter', [UserController::class, 'filter'])->name('user.filter');
        Route::post('user/store', [UserController::class, 'store'])->name('user.store');
        Route::put('user/update/{id}', [UserController::class, 'update'])->name('user.update');
        Route::get('user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
        Route::delete('user/destroy/{id}', [UserController::class, 'destroy'])->name('user.destroy');

        Route::get('division', [DivisionController::class, 'index'])->name('division');
        Route::post('division/store', [DivisionController::class, 'store'])->name('division.store');
        Route::get('division/edit/{id}', [DivisionController::class, 'edit'])->where('id', '[0-9]+')->name('division.edit');
        Route::put('division/update/{id}', [DivisionController::class, 'update'])->where('id', '[0-9]+')->name('division.update');
        Route::delete('division/destroy/{id}', [DivisionController::class, 'destroy'])->where('id', '[0-9]+')->name('division.destroy');
        Route::get('division/parent/dropdown/{id}/{level}', [DivisionController::class, 'dropdownParentUpdate'])->where('id', '[0-9]+')->where('level', '[0-9]+')->name('division.parent.dropdown.update');
        Route::get('division/parent/dropdown/{level}', [DivisionController::class, 'dropdownParentCreate'])->where('level', '[0-9]+')->name('division.parent.dropdown.create');

        Route::get('employee', [EmployeeController::class, 'index'])->name('employee');
        Route::get('employee/create', [EmployeeController::class, 'create'])->name('employee.create');
        Route::post('employee/store', [EmployeeController::class, 'store'])->name('employee.store');
        Route::get('employee/edit/{id}', [EmployeeController::class, 'edit'])->name('employee.edit');
        Route::put('employee/update/{id}', [EmployeeController::class, 'update'])->name('employee.update');
        Route::delete('employee/destroy/{id}', [EmployeeController::class, 'destroy'])->name('employee.destroy');
        Route::get('employee/heads/dropdown/{divisionId}', [EmployeeController::class, 'dropdownHeadByDivisi'])->where('level', '[0-9]+')->name('employee.heads.dropdown');
        Route::get('employee/position/suggest', [EmployeeController::class, 'suggestPosisi'])->name('employee.position.suggest');


        Route::get('criteria', [CriteriaController::class, 'index'])->name('criteria');
        Route::post('criteria/store', [CriteriaController::class, 'store'])->name('criteria.store');
        Route::put('criteria/update/{id}', [CriteriaController::class, 'update'])->name('criteria.update');
        Route::get('criteria/edit/{id}', [CriteriaController::class, 'edit'])->name('criteria.edit');
        Route::delete('criteria/destroy/{id}', [CriteriaController::class, 'destroy'])->name('criteria.destroy');
        Route::get('criteria/matrix', [CriteriaComparisonController::class, 'index'])->name('criteria.matrix');
        Route::post('criteria/matrix/store', [CriteriaComparisonController::class, 'store'])->name('criteria.matrix.store');

        Route::get('subciteria/{criteriaId}', [SubcriteriaController::class, 'index'])->where('criteriaId', '[0-9]+')->name('subcriteria');
        Route::post('subciteria/store', [SubcriteriaController::class, 'store'])->name('subcriteria.store');
        Route::get('subciteria/edit/{id}', [SubcriteriaController::class, 'edit'])->where('id', '[0-9]+')->name('subcriteria.edit');
        Route::put('subciteria/update/{id}', [SubcriteriaController::class, 'update'])->where('id', '[0-9]+')->name('subcriteria.update');
        Route::delete('subciteria/destroy/{id}', [SubcriteriaController::class, 'destroy'])->where('id', '[0-9]+')->name('subcriteria.destroy');
        Route::get('subciteria/{criteriaId}/matrix', [SubcriteriaComparisonController::class, 'index'])->where('criteriaId', '[0-9]+')->name('subcriteria.matrix');
        Route::post('subciteria/{criteriaId}/matrix/store', [SubcriteriaComparisonController::class, 'store'])->where('criteriaId', '[0-9]+')->name('subcriteria.matrix.store');

        Route::get('assessment/calculate', [AssessmentController::class, 'calculate'])->name('assessment.calculate');
    });

    Route::get('assessment', [AssessmentController::class, 'index'])->name('assessment');
    Route::get('assessment/edit/{employeeId}', [AssessmentController::class, 'edit'])->where('employeeId', '[0-9]+')->name('assessment.edit');
    Route::post('assessment/update/{employeeId}', [AssessmentController::class, 'update'])->where('employeeId', '[0-9]+')->name('assessment.update');
    Route::get('assessment/matrix', [AssessmentController::class, 'matrix'])->name('assessment.matrix');
    Route::get('assessment/create', [AssessmentController::class, 'create'])->name('assessment.create');
    Route::post('assessment/store', [AssessmentController::class, 'store'])->name('assessment.store');

});