<?php

namespace App\Http\Controllers;

use App\Models\accounts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Contracts\Service\Attribute\Required;

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

        // redirects to the login page
        return redirect('/login');
    }


    // Login 
    public function loginPost(Request $request){
        // validate inputs
        $fields = $request->validate([
            'email' => 'required|string|unique:accounts,Email',
            'password' => 'Required|string'
        ]);

        // get user info from DB on email
        $user = DB::table('accounts')->where
            ('Email', $fields['email'])->first();

        // check if user has correct password
        if(!$user || ($fields['password'] != $user->password)){
            return response([
                'message' => 'Your email or password is incorrect'
            ], 401);
        };

        // checks if their account is approved
        if($user->isRegApproved = NULL){
            return response([
                'message' => 'Your account is not approved.'
            ], 401);
        };

        
    }

}
