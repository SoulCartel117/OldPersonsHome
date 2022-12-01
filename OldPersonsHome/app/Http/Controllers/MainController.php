<?php

namespace App\Http\Controllers;

use App\Models\accounts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Symfony\Contracts\Service\Attribute\Required;

class MainController extends Controller
{

    public function getHome(){
        return view('welcome');
    }

    public function login(){
        return view('login', ['loginError'=>'Please log in']);

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

    public function adminIndex(){
        return view('adminIndex');
    }

    public function superIndex(){
        return view('superIndex');
    }

    public function docIndex(){
        return view('docIndex');
    }

    public function careIndex(){
        return view('careIndex');
    }

    public function patientIndex(){
        return view('patientHome');
    }

    public function famIndex(){
        return view('familyMemberHome');
    }

    public function getRegistration(){
        return view('registration');
    }

    
    // registration
    public function registration(Request $request){
        // validates their imputs
        $fields = $request->validate([
            'email' => 'required|string|unique:accounts,Email'
        ]);

        // sends their information to the DB
        DB::table('accounts')->insert([
            'roleID' => $request->input('role'),
            'FName' => $request->input('fname'),
            'LName' => $request->input('lname'),
            'Email' => $request->input('email'),
            'phNo' => $request->input('phone'),
            'password' => $request->input('password'),
            'DOB' => $request->input('DOB')
        ]);

        $user = DB::table('accounts')->where
            ('Email', $request->input('email'))->first();

        
        if($request->input('role') == 5){
            DB::table('familycode')->insert([
                'patientID'=>$user->ID,
                'familyCode' => $request->input('familyCode')
            ]);
    
            $FCID = DB::table('familycode')->where
            ('patientID', $user->ID)->first();

            DB::table('patient')->insert([
                'patientID'=>$user->ID,
                'FCID' => $FCID->FCID,
                'admissionDate' => (date('Y')."-".date('m')."-".date('d')),
                'emContact' => $request->input('familyName'),
                'emContactPhNo' => $request->input('familyPhone'),
                'relationEmContact' => $request->input('familyRelation')
            ]);
        }

        // redirects to the login page
        return redirect('/login');
    }


    // Login 
    public function loginPost(Request $request){
        // get user info from DB on email
        $user = DB::table('accounts')->where
            ('Email', $request->input('email'))->first();

        // check if user has correct password
        if(!$user || ($request->input('password') != $user->password)){
            return view('login', ['loginError'=>'Your email or username is incorrect']);
        };

        // checks if their account is approved
        if($user->isRegApproved == NULL){
            return view('login', ['loginError'=>'Your account is not approved']);
        };

        // get user role
        $role = $user->roleID;

        // redirect to correct home page based on role
        if($role == 1){
            return redirect('/adminIndex');
        }
        if($role == 2){
            return redirect('/superIndex');
        }
        if($role == 3){
            return redirect('/docIndex');
        }
        if($role == 4){
            return redirect('/careIndex');
        }
        if($role == 5){
            return redirect('/patientHome');
        }
        if($role == 6){
            return redirect('/famlyMemberHome');
        }

        // return login page if nothing else
        return redirect('/login');

    }

}

