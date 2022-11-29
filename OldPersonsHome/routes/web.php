<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('/patientAdditionalInfo', function () {
    return view('patientAdditionalInfo');
});

Route::get('/doctorAppt', function () {
    return view('doctorAppt');
});

Route::get('/patientHome', function () {
    return view('patientHome');
});

Route::get('/employee', function () {
    return view('employee');
});

Route::get('/patients', function () {
    return view('patients');
});

Route::get('/roster', function () {
    return view('roster'); 
});

Route::get('/newRoster', function () {
    return view('newRoster');
});

Route::get('/doctorHome', function () {
    return view('doctorHome');
});

Route::get('/patientOfDoctor', function () {
    return view('patientOfDoctor');
});

Route::get('/caregiverHome', function () {
    return view('caregiverHome');
});

Route::get('/familyMemberHome', function () {
    return view('familyMemberHome');
});

Route::get('/adminReport', function () {
    return view('adminReport');
});

Route::get('/payment', function () {
    return view('payment');
});