<?php

namespace App\Http\Controllers;

use App\Models\accounts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Symfony\Contracts\Service\Attribute\Required;

class MainController extends Controller
{

    public function home(){
        return view('welcome');
    }

    public function login(){
        return view('login', ['loginError'=>'Please log in']);
    }

    public function regisApproval(){
        return view('regisApproval');
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
        return view('patientIndex');
    }

    public function famIndex(){
        return view('famIndex');
    }

    public function registrationGet(){
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

        DB::table('familycode')->insert([
            'patientID'=>$user->ID,
            'familyCode' => $request->input('familyCode')
        ]);

        $FCID = DB::table('familycode')->where
        ('patientID', $user->ID)->first();
        
        if($request->input('role') == 5){
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
