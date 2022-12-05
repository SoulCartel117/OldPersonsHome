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

    public function regisApproval(Request $request, $id){
        //grabs the option from the form to enter into DB request
        $option = $request->input('option');

        //updates table where id = id of account you clicked yes, sets isRegApproved to 1 or 0
        DB::table('accounts')->where('ID', $id)->update(['isRegApproved' => $option]);

        //redirects back to page with updated info 
        return redirect('/regisApproval');
    }
    
    public function getPatientAdditionalInfo(){
        return view('patientAdditionalInfo');
    }

    public function getDoctorAppt(Request $request){
        // patient1 is button. 
        $patient1 = $request->input("searchPt");
        // initialize $pid to assign value later
        $pid;
        //if patient1(button) is not null aka it's been pressed, then make $pid = input name='pid'
        if($patient1 != null){
            $pid = $request->input('pid');
            } 
        else {
            $pid = 2;
        }

        //SELECT * FROM `accounts` where roleID = 5 (patient) and ID = $pid and isRegApproved = 1
        //populates box on side once patient id is entered
        $pt = DB::table('accounts')->select('*')->whereroleidAndIsregapprovedAndId(5, 1, $pid)->get();
        $pt = json_decode(json_encode($pt), true);

        // searchDate is button
        $searchDate = $request->input("searchDate");
        //initialize $date to assign value later
        $date;
        //if searchDate(button) is not null aka it's been pressed, then make $date = input name='date' else make it today's date
        if($searchDate != null){
            $date = $request->input('date');
        }else{
            $date = date("Y-m-d");
        }
        
        // doctor is button
        $doctor = $request->input("searchDr");

        //joins tables to populate select/option with doctors working that date 
        $data = DB::table('accounts')->join('roster', 'roster.doctorID',  '=', 'accounts.ID')->select('roster.doctorID', 'accounts.FName', 'accounts.LName')->where('roster.date', '=', $date)->get();
        $data = json_decode(json_encode($data), true);

        //get doctorID to insert into appt table
        $doctorID = DB::table('accounts')->join('roster', 'roster.doctorID',  '=', 'accounts.ID')->select('roster.doctorID')->where('roster.date', '=', $date)->get();
        //get supervisorID to insert into appt table
        $supervisorID = DB::table('accounts')->join('roster', 'roster.supervisorID',  '=', 'accounts.ID')->select('roster.supervisorID')->where('roster.date', '=', $date)->get();
        //get patient group, number select groupID from accounts where id = pid;
        $group = DB::table('accounts')->select('groupID')->where('ID', '=', 48)->get();
        
        //get caregiver to insert into appt table
        if ($group == 1){
            //SELECT a.FName FROM accounts a join roster r on r.group1 = a.ID join caregiver c USING (date) where r.date = '2022-12-05';
            $caregiver = DB::table('accounts')->join('roster', 'roster.group1',  '=', 'accounts.ID')->joinUsing('caregiver', 'date')->select('accounts.FName')->where('roster.date', '=', $date)->get();
        } elseif($group == 2){
            $caregiver = DB::table('accounts')->join('roster', 'roster.group2',  '=', 'accounts.ID')->joinUsing('caregiver', 'date')->select('accounts.FName')->where('roster.date', '=', $date)->get();
        } elseif($group == 3){
            $caregiver = DB::table('accounts')->join('roster', 'roster.group3',  '=', 'accounts.ID')->joinUsing('caregiver', 'date')->select('accounts.FName')->where('roster.date', '=', $date)->get();
        } else {
            $caregiver = DB::table('accounts')->join('roster', 'roster.group4',  '=', 'accounts.ID')->joinUsing('caregiver', 'date')->select('accounts.FName')->where('roster.date', '=', $date)->get();
        } 
        
        
        
        //$insert =DB::table();

        
        return view('doctorAppt')->with('patient', $pt)->with('date', $date)->with('doctors', $data);
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

    public function getRoster(Request $request){
        // date is button
        $date = $request->input("searchByDate");
        // initialize $frmDateReg to assign value later
        $frmDateReg;
        if($date != null){
            $frmDateReg = $request->input('frmDateReg');
        }else{
            $frmDateReg = date("Y-m-d");
        }

        $data5 = DB::table('accounts')->join('roster', 'roster.supervisorID',  '=', 'accounts.ID')->select('*')->where('roster.date', '=', $frmDateReg)->get();
        $data5 = json_decode(json_encode($data5), true);

        $data0 = DB::table('accounts')->join('roster', 'roster.doctorID',  '=', 'accounts.ID')->select('*')->where('roster.date', '=', $frmDateReg)->get();
        $data0 = json_decode(json_encode($data0), true);

        $data1 = DB::table('accounts')->join('roster', 'roster.group1',  '=', 'accounts.ID')->select('*')->where('roster.date', '=', $frmDateReg)->get();
        $data1 = json_decode(json_encode($data1), true);

        $data2 = DB::table('accounts')->join('roster', 'roster.group2',  '=', 'accounts.ID')->select('*')->where('roster.date', '=', $frmDateReg)->get();
        $data2 = json_decode(json_encode($data2), true);

        $data3 = DB::table('accounts')->join('roster', 'roster.group3',  '=', 'accounts.ID')->select('*')->where('roster.date', '=', $frmDateReg)->get();
        $data3 = json_decode(json_encode($data3), true);

        $data4 = DB::table('accounts')->join('roster', 'roster.group4',  '=', 'accounts.ID')->select('*')->where('roster.date', '=', $frmDateReg)->get();
        $data4 = json_decode(json_encode($data4), true);

        return view('roster')->with('date', $frmDateReg)->with('users5', $data5)->with('users0', $data0)->with('users1', $data1)->with('users2', $data2)->with('users3', $data3)->with('users4', $data4);
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
        // validates their inputs
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

