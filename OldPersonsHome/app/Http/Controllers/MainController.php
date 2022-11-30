<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function home(){
        return view('welcome');
    }

    public function login(){
        return view('login');
    }

    public function regisApproval(){
        return view('regisApproval');
    }

    public function registration(){
        return view('registration');
    }
    
    public function patientAdditionalInfo(){
        return view('patientAdditionalInfo');
    }

    public function doctorAppt(){
        return view('doctorAppt');
    }

    public function patientHome(){
        return view('patientHome');
    }

    public function employee(){
        return view('employee');
    }

    public function patients(){
        return view('patients');
    }

    public function roster(){
        return view('roster');
    }

    public function newRoster(){
        return view('newRoster');
    }

    public function doctorHome(){
        return view('doctorHome');
    }

    public function patientOfDoctor(){
        return view('patientOfDoctor');
    }

    public function caregiverHome(){
        return view('caregiverHome');
    }

    public function familyMemberHome(){
        return view('familyMemberHome');
    }

    public function adminReport(){
        return view('adminReport');
    }

    public function payment(){
        return view('payment');
    }

    public function homepage(){
        return view('homepage');
    }

    public function roles(){
        return view('roles');
    }

    

}
