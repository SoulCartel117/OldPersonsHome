<?php

namespace App\Http\Controllers;

use App\Models\accounts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{

    public function getHome(){
        return view('welcome');
    }

    public function getRegistration(){
        return view('registration');
    }

    public function registration(Request $request){
        // $fields = $request->validate([
        //     'role' => 'required|string',
        //     'fname' => 'required|string',
        //     'lname' => 'required|string',
        //     'email' => 'required|string|unique:accounts,Email',
        //     'phone' => 'required|string',
        //     'password' => 'required|string|confirmed',
        //     'DOB' => 'required|date'
        // ]);

        DB::table('accounts')->insert([
            'roleID' => $request->input('role'),
            'FName' => $request->input('fname'),
            'LName' => $request->input('lname'),
            'Email' => $request->input('email'),
            'phNo' => $request->input('phone'),
            'password' => $request->input('password'),
            'DOB' => $request->input('DOB')
    ]);
        return redirect('/login');
    }

    public function getLogin(){
        return view('login');
    }

    public function getRegisApproval(){

        $data = DB::table('accounts')->join('roles', 'roles.roleID',  '=', 'accounts.roleID')->select('*')->whereNull('isRegApproved')->get();
        $data = json_decode(json_encode($data), true);
        return view('regisApproval')->with('users', $data);
    }

    public function regisApproval(){
        
    }
    
    public function getPatientAdditionalInfo(){
        return view('patientAdditionalInfo');
    }

    public function getDoctorAppt(){
        return view('doctorAppt');
    }

    public function getPatientHome(){
        return view('patientHome');
    }

    public function getEmployee(){
        return view('employee');
    }

    public function getPatients(){
        return view('patients');
    }

    public function getRoster(){
        return view('roster');
    }

    public function getNewRoster(){
        return view('newRoster');
    }

    public function getDoctorHome(){
        return view('doctorHome');
    }

    public function getPatientOfDoctor(){
        return view('patientOfDoctor');
    }

    public function getCaregiverHome(){
        return view('caregiverHome');
    }

    public function getFamilyMemberHome(){
        return view('familyMemberHome');
    }

    public function getAdminReport(){
        return view('adminReport');
    }

    public function getPayment(){
        return view('payment');
    }

    public function getHomepage(){
        return view('homepage');
    }

    public function getRoles(){
        return view('roles');
    }

   

}
