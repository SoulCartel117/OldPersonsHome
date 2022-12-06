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

    public function getLogin(){
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
    public function postPatientAdditionalInfo(Request $request){
        DB::table('patient')
            ->where('groupID', 'gid')
            ->update(['groupID' => 'gid']);

        return redirect('/patientAdditionalInfo');
    }

    public function getDoctorAppt(Request $request){
        return view('doctorAppt');
    }

    public function postDoctorAppt(Request $request){
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
        //get doctorID to insert into appt table
        $doctorID = DB::table('accounts')->join('roster', 'roster.doctorID',  '=', 'accounts.ID')->select('roster.doctorID')->where('roster.date', '=', $date)->get();
        //get supervisorID to insert into appt table
        $supervisorID = DB::table('accounts')->join('roster', 'roster.supervisorID',  '=', 'accounts.ID')->select('roster.supervisorID')->where('roster.date', '=', $date)->get();
        
        //get patient group, number select groupID from accounts where id = pid;
        $group = DB::table('patient')->select('groupID')->where('patientID', '=', $pid)->get();
        $group = json_decode(json_encode($group), true);

        // get caregiver to insert into appt table
        if ($group == 1){
            // select * from roster r join accounts a on r.group2=a.ID where date = '2022-12-05';
            $caregiver = DB::table('accounts')->join('roster', 'roster.group1',  '=', 'accounts.ID')->select('accounts.ID')->where('roster.date', '=', $date)->get();
        } elseif($group == 2){
            $caregiver = DB::table('accounts')->join('roster', 'roster.group2',  '=', 'accounts.ID')->select('accounts.ID')->where('roster.date', '=', $date)->get();
        } elseif($group == 3){
            $caregiver = DB::table('accounts')->join('roster', 'roster.group3',  '=', 'accounts.ID')->select('accounts.ID')->where('roster.date', '=', $date)->get();
        } else {
            $caregiver = DB::table('accounts')->join('roster', 'roster.group4',  '=', 'accounts.ID')->select('accounts.ID')->where('roster.date', '=', $date)->get();
        } 

        $comment = $request->input("cid");

        DB::table('appointments')->insert([
            'supervisorID' => $supervisorID,
            'doctorID' => $doctorID,
            'patientID' => $pid,
            'caregiverID' => $caregiver,
            'comment' => $comment,
            'date' => $date
        ]);

        return redirect('/doctorAppt');
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

        // gets the supervisors, doctors and caretakers and send it to the page for the drop downs
        $super = DB::table('accounts')->where
        ('roleID', 2)->get();

        $doctor = DB::table('accounts')->where
        ('roleID', 3)->get();

        $caregiver = DB::table('accounts')->where
        ('roleID', 4)->get();

        return view('newRoster',['Super'=>$super,'Doctors'=>$doctor,'Care'=>$caregiver]);
    }

    public function postNewRoster(Request $request){
        //check if roster exist for the date
        $rosterDate = $caregiver = DB::table('roster')->where
        ('date', $request->input('frmDateReg'))->get();

        $DateCount = DB::select("select count(*) as count from roster where date = '2022-12-06'")[0];
        $DateCount = json_decode(json_encode($DateCount), true)["count"];
        
        if($DateCount <= 1){
            //get the new roster info
            $nSuperID = $request->input('Supervisor');
            $nDocID = $request->input('Doctor');
            $nGroup1 = $request->input('caregiver1');
            $nGroup2 = $request->input('caregiver2');
            $nGroup3 = $request->input('caregiver3');
            $nGroup4 = $request->input('caregiver4');

            //get the older roster info
            $oSuperID = $rosterDate[0]->supervisorID;
            $oDocID = $rosterDate[0]->doctorID;
            $oGroup1 = $rosterDate[0]->group1;
            $oGroup2 = $rosterDate[0]->group2;
            $oGroup3 = $rosterDate[0]->group3;
            $oGroup4 = $rosterDate[0]->group4;

            // compare old and new groups
            if($nSuperID != $oSuperID && $nSuperID != null){
                $oSuperID = $nSuperID;
            }
            if($nDocID != $oDocID && $nDocID != null){
                $oDocID = $nDocID;
            }
            if($nGroup1 != $oGroup1 && $nGroup1 != null){
                $oGroup1 = $nGroup1;
            }
            if($nGroup2 != $oGroup2 && $nGroup2 != null){
                $oGroup2 = $nGroup2;
            }
            if($nGroup3 != $oGroup3 && $nGroup3 != null){
                $oGroup3 = $nGroup3;
            }
            if($nGroup4 != $oGroup4 && $nGroup4 != null){
                $oGroup4 = $nGroup4;
            }
            // send all the data
            DB::table('roster')->where('date',$request->input('frmDateReg'))
                ->update([
                'supervisorID' => $oSuperID,
                'doctorID' => $oDocID,
                'group1' => $oGroup1,
                'group2' => $oGroup2,
                'group3' => $oGroup3,
                'group4' => $oGroup4                
            ]);
        }
        else{
        //sends data to create a new roster 
        DB::table('roster')->insert([
            'supervisorID' => $request->input('Supervisor'),
            'doctorID' => $request->input('Doctor'),
            'group1' => $request->input('caregiver1'),
            'group2' => $request->input('caregiver2'),
            'group3' => $request->input('caregiver3'),
            'group4' => $request->input('caregiver4'),
            'date' => $request->input('frmDateReg')
        ]);
        
        }

        
        // gets the supervisors, doctors and caretakers and send it to the page for the drop downs
        $super = DB::table('accounts')->where
        ('roleID', 2)->get();

        $doctor = DB::table('accounts')->where
        ('roleID', 3)->get();

        $caregiver = DB::table('accounts')->where
        ('roleID', 4)->get();

        return view('newRoster',['Super'=>$super,'Doctors'=>$doctor,'Care'=>$caregiver]);
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

        // then we regrab that previously entered information 
        $user = DB::table('accounts')->where
            ('Email', $request->input('email'))->first();

        // then we check if Role from $user is a patient and then update the em contact stuff
        // we may want to added validation to ensure those fields are filled in 
        if($request->input('role') == 5){
            DB::table('familycode')->insert([
                'patientID'=>$user->ID,
                'familyCode' => $request->input('familyCode')
            ]);
            
            // get FCID info we just inserted to update the patients table
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

