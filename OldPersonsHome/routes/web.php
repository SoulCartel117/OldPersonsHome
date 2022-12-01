<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;

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

Route::get('/', [MainController::class, 'home']);
Route::get('/patientAdditionalInfo', [MainController::class, 'patientAdditionalInfo']);
Route::get('/doctorAppt', [MainController::class, 'doctorAppt']);
Route::get('/patientHome', [MainController::class, 'patientHome']);
Route::get('/employee', [MainController::class, 'employee']);
Route::get('/patients', [MainController::class, 'patients']);
Route::get('/roster', [MainController::class, 'roster']);
Route::get('/newRoster', [MainController::class, 'newRoster']);
Route::get('/doctorHome', [MainController::class, 'doctorHome']);
Route::get('/patientOfDoctor', [MainController::class, 'patientOfDoctor']);
Route::get('/caregiverHome', [MainController::class, 'caregiverHome']);
Route::get('/familyMemberHome', [MainController::class, 'familyMemberHome']);
Route::get('/adminReport', [MainController::class, 'adminReport']);
Route::get('/payment', [MainController::class, 'payment']);
Route::get('/homepage', [MainController::class, 'homepage']);
Route::get('/roles', [MainController::class, 'roles']);
Route::get('/login', [MainController::class, 'login']);
Route::post('/login', [MainController::class, 'loginPost']);
Route::get('/regisApproval', [MainController::class, 'regisApproval']);
Route::get('/registration', [MainController::class, 'registration']);
Route::post('/registration', [MainController::class, 'registration']);

Route::get('/adminIndex', [MainController::class, 'adminIndex']);
Route::get('/superIndex', [MainController::class, 'superIndex']);
Route::get('/docIndex', [MainController::class, 'docIndex']);
Route::get('/careIndex', [MainController::class, 'careIndex']);
Route::get('/patientHome', [MainController::class, 'patientIndex']);
Route::get('/familyMemberHome', [MainController::class, 'famIndex']);

