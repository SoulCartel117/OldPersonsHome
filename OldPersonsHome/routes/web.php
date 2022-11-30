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
Route::get('/registration', [MainController::class, 'registration']);
Route::get('/roles', [MainController::class, 'roles']);
Route::get('/login', [MainController::class, 'login']);
Route::get('/regisApproval', [MainController::class, 'regisApproval']);

// Route::get('/', function () {
//     return view('welcome');
// });


// Route::get('/patientAdditionalInfo', function () {
//     return view('patientAdditionalInfo');
// });

// Route::get('/doctorAppt', function () {
//     return view('doctorAppt');
// });

// Route::get('/patientHome', function () {
//     return view('patientHome');
// });

// Route::get('/employee', function () {
//     return view('employee');
// });

// Route::get('/patients', function () {
//     return view('patients');
// });

// Route::get('/roster', function () {
//     return view('roster'); 
// });

// Route::get('/newRoster', function () {
//     return view('newRoster');
// }); 

// Route::get('/doctorHome', function () {
//     return view('doctorHome');
// });

// Route::get('/patientOfDoctor', function () {
//     return view('patientOfDoctor');
// });

// Route::get('/caregiverHome', function () {
//     return view('caregiverHome');
// });

// Route::get('/familyMemberHome', function () {
//     return view('familyMemberHome');
// });

// Route::get('/adminReport', function () {
//     return view('adminReport');
// });

// Route::get('/payment', function () {
//     return view('payment');
// });

// Route::get('/homepage', function () {
//     return view('homepage');
// });

// Route::get('/registration', function () {
//     return view('registration');
// });

// Route::get('/roles', function () {
//     return view('roles');
// });

// Route::get('/login', function () {
//     return view('login');
// });

// Route::get('/regisApproval', function () {
//     return view('regisApproval');
// });

