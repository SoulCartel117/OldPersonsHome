<?php

use Illuminate\Support\Facades\Route;
use App\http\Controllers\MainController;

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

Route::get('/', [MainController::class, 'getHome']);

Route::get('/patientAdditionalInfo', [MainController::class, 'getPatientAdditionalInfo']);
Route::post('/patientAdditionalInfo', [MainController::class, 'postPatientAdditionalInfo']);

Route::get('/doctorAppt', [MainController::class, 'getDoctorAppt']);
Route::post('/doctorAppt', [MainController::class, 'postDoctorAppt']);

Route::get('/patientHomeIndex', [MainController::class, 'patientIndex']);
Route::get('/patientHome', [MainController::class, 'getPatientHome']);

Route::get('/employee', [MainController::class, 'getEmployee']);
Route::post('/employeeSearch', [MainController::class, 'searchEmployee']);
Route::post('/employee', [MainController::class, 'updateEmpSalary']);

Route::get('/patients', [MainController::class, 'getPatients']);
Route::post('/patients', [MainController::class, 'postPatients']);

Route::get('/roster', [MainController::class, 'getRoster']);

Route::get('/newRoster', [MainController::class, 'getNewRoster']);
Route::post('/newRoster', [MainController::class, 'postNewRoster']);

Route::get('/doctorHome', [MainController::class, 'getDoctorHome']);

Route::get('/patientOfDoctor', [MainController::class, 'getPatientOfDoctor']);

Route::get('/caregiverHome', [MainController::class, 'getCaregiverHome']);
Route::post('/caregiverHome', [MainController::class, 'postCaregiverHome']);

Route::get('/familyMemberHome', [MainController::class, 'getFamilyMemberHome']);
Route::post('/familyMemberHome', [MainController::class, 'postFamilyMemberHome']);

Route::get('/adminReport', [MainController::class, 'getAdminReport']);

Route::get('/payment', [MainController::class, 'getPayment']);

Route::get('/homepage', [MainController::class, 'getHomepage']);

Route::get('/registration', [MainController::class, 'getRegistration']);
Route::post('/registration', [MainController::class, 'registration']);

Route::get('/roles', [MainController::class, 'getRoles']);

Route::get('/login', [MainController::class, 'getLogin']);
Route::post('/login', [MainController::class, 'LoginPost']);

Route::get('/regisApproval', [MainController::class, 'getRegisApproval']);
Route::post('/regisApproval/{id}', [MainController::class, 'regisApproval']);

Route::get('/adminIndex', [MainController::class, 'adminIndex']);

Route::get('/superIndex', [MainController::class, 'superIndex']);

Route::get('/docIndex', [MainController::class, 'docIndex']);

Route::get('/careIndex', [MainController::class, 'careIndex']);



//Route::get('/familyMemberHome', [MainController::class, 'famIndex']);

