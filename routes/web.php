<?php

use App\Http\Controllers\AdminController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use App\Http\Controllers\EmployeeController;

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

Route::get('/', function () {

   return redirect("login");
});

Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false,
]);

Route::get('/employee/dashboard', [EmployeeController::class, 'index'])->name('employee.dashboard')->middleware(['web', 'auth', 'role:Employee']);
Route::get('employees', [EmployeeController::class, 'show'])->name('employees.show')->middleware(['web', 'auth', 'role:Employee|Admin']);

Route::middleware(['web', 'auth', 'role:Admin'])->prefix('admin')->group(function() {

    Route::get('dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('employee/create', [AdminController::class, 'create'])->name('admin.employee.create');
    Route::get('employee/{employee_id}/edit', [AdminController::class, 'edit'])->name('admin.employee.edit');
    Route::post('employee', [AdminController::class, 'store'])->name('admin.employee.store');
    Route::put('employee', [AdminController::class, 'update'])->name('admin.employee.update');
    Route::delete('employee/{employee_id}', [AdminController::class, 'destory'])->name('admin.employee.destory');

    Route::get('city/{state_id}', [AdminController::class, 'city'])->name('admin.city');
    Route::get('state/{country_id}', [AdminController::class, 'state'])->name('admin.state');
    Route::get('country', [AdminController::class, 'country'])->name('admin.country');

});




