<?php

namespace App\Http\Controllers;

use App\Models\accounts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use PhpParser\Node\Expr\FuncCall;
use Symfony\Contracts\Service\Attribute\Required;
session_start();

global $user1;


class MainController extends Controller
{
    public function getHome(){
        return view('welcome');
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

        $user1 = DB::table('accounts')->select('*')->whereRoleidAndEmail($role, $request->input('email'))->get();
        $user1 = json_decode(json_encode($user1), true);
        $_SESSION['user1'] = $user1;

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
            return redirect('/familyMemberHome');
        }
        // return login page if nothing else
        return redirect('/login');

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

        //GET ALL THE DOCTORS
        $doctor = DB::table('accounts')->where
        ('roleID', 3)->get();

        $group = DB::table('groups')->get();

        return view('patientAdditionalInfo',['Doctors'=>$doctor, 'Groups'=>$group]);
       
    }
    public function postPatientAdditionalInfo(Request $request){
        var_dump($request->input('gid'));
        DB::table('patient')
            ->where('patientID', $request->input('pid'))
            ->update(['groupID' => $request->input('gid'), 'doctorID' => $request->input('did')]);

        return redirect('/patientAdditionalInfo');
    }

    public function getDoctorAppt(Request $request){
        return view('doctorAppt');
    }

    public function postDoctorAppt(Request $request){
        // searchDate is button
        $date = $request->input("date");
        //get doctorID to insert into appt table
        $doctorID = DB::table('accounts')->join('roster', 'roster.doctorID',  '=', 'accounts.ID')->select('roster.doctorID')->where('roster.date', '=', $date)->get();
        //$doctorID = json_decode(json_encode($doctorID), true);
        //get supervisorID to insert into appt table
        $supervisorID = DB::table('accounts')->join('roster', 'roster.supervisorID',  '=', 'accounts.ID')->select('roster.supervisorID')->where('roster.date', '=', $date)->get();
        //$supervisorID = json_decode(json_encode($supervisorID), true);

        $pid = $request->input("pid");

        //get patient group, number select groupID from accounts where id = pid;
        $group = DB::table('patient')->select('groupID')->where('patientID', '=', $pid)->get();
        $group = json_decode(json_encode($group), true);

        //$group is an array. This pulls the value out of that array and assigns it to groupID
        foreach($group[0] as $v){
            $groupID = $v;
        }
        
        //initialize caregiver
        $caregiver;
        // get caregiver to insert into appt table
        if ($groupID == 1){
            // select * from roster r join accounts a on r.group2=a.ID where date = '2022-12-05';
            $caregiver = DB::table('accounts')->join('roster', 'roster.group1',  '=', 'accounts.ID')->select('accounts.ID')->where('roster.date', '=', $date)->get();
        } elseif($groupID == 2){
            $caregiver = DB::table('accounts')->join('roster', 'roster.group2',  '=', 'accounts.ID')->select('accounts.ID')->where('roster.date', '=', $date)->get();
        } elseif($groupID == 3){
            $caregiver = DB::table('accounts')->join('roster', 'roster.group3',  '=', 'accounts.ID')->select('accounts.ID')->where('roster.date', '=', $date)->get();
        } elseif ($groupID == 4) {
            $caregiver = DB::table('accounts')->join('roster', 'roster.group4',  '=', 'accounts.ID')->select('accounts.ID')->where('roster.date', '=', $date)->get();
        } 

        //$caregiver = json_decode(json_encode($caregiver), true);
        $comment = $request->input("cid");

        DB::table('appointments')->insert([
            'supervisorID' => $supervisorID[0]->supervisorID,
            'doctorID' => $doctorID[0]->doctorID,
            'patientID' => $pid,
            'caregiverID' => $caregiver[0]->ID,
            'comment' => $comment,
            'date' => $date
        ]);

        return redirect('/doctorAppt');
    }

    public function getPatientHome(Request $request){
        // return $request->input('date');
        $pid = $_SESSION['user1'][0]['ID'];
        $mid = $_SESSION['user1'][0]['ID'];

        $date = date("Y-m-d");
        if($request->input('date') == null){
            $date = date("Y-m-d");
        } else {
            $date = $request->input('date');
        }

        //get patient group, number select groupID from accounts where id = pid;
        $group = DB::table('patient')->select('groupID')->where('patientID', '=', $pid)->get();
        $group = json_decode(json_encode($group), true);

        //$group is an array. This pulls the value out of that array and assigns it to groupID
        if(!empty($group)){
            foreach($group[0] as $v){
                $groupID = $v;
            }

            $meals = DB::table('meals')->select('*')->wherePatientidAndDate($mid, $date)->get();
            $meals = json_decode(json_encode($meals), true);

            $medicationTaken = DB::table('medicationtaken')->select('*')->wherePatientidAndDate($pid, $date)->get();
            $medicationTaken = json_decode(json_encode($medicationTaken), true);
            
            //initialize caregiver
            $caregiver;
            // get caregiver to insert into appt table
            if ($groupID == 1){
                // select * from roster r join accounts a on r.group2=a.ID where date = '2022-12-05';
                $caregiver = DB::table('accounts')->join('roster', 'roster.group1',  '=', 'accounts.ID')->select('accounts.FName', 'accounts.LName')->where('roster.date', '=', $date)->get();
            } elseif($groupID == 2){
                $caregiver = DB::table('accounts')->join('roster', 'roster.group2',  '=', 'accounts.ID')->select('accounts.FName', 'accounts.LName')->where('roster.date', '=', $date)->get();
            } elseif($groupID == 3){
                $caregiver = DB::table('accounts')->join('roster', 'roster.group3',  '=', 'accounts.ID')->select('accounts.FName', 'accounts.LName')->where('roster.date', '=', $date)->get();
            } elseif ($groupID == 4) {
                $caregiver = DB::table('accounts')->join('roster', 'roster.group4',  '=', 'accounts.ID')->select('accounts.FName', 'accounts.LName')->where('roster.date', '=', $date)->get();
            } 
            $caregiver = json_decode(json_encode($caregiver), true);

            $appointments = DB::table('appointments')->select('date')->where('patientID', '=', $pid)->get();
            $appointments = json_decode(json_encode($appointments), true);

            //$appointments is an array. This pulls the value out of that array and assigns it to groupID
            if(!empty($appointments)){
                foreach($appointments[0] as $v){
                    $apptDate = $v;
                }

                $doctor = DB::table('appointments')->join('accounts', 'appointments.doctorID', '=', 'accounts.ID')->select('appointments.doctorID', 'accounts.FName', 'accounts.LName')->wherePatientidAndDate($pid, $date)->get();
                $doctor = json_decode(json_encode($doctor), true);

                return view('patientHome')->with('medicationTaken', $medicationTaken)->with('meals', $meals)->with('date', $date)->with('caregiver', $caregiver)->with('apptDate', $apptDate)->with('doctor', $doctor);
        
            }
            
            $doctor = DB::table('appointments')->join('accounts', 'appointments.doctorID', '=', 'accounts.ID')->select('appointments.doctorID', 'accounts.FName', 'accounts.LName')->wherePatientidAndDate($pid, $date)->get();
            $doctor = json_decode(json_encode($doctor), true);

            // $doctor = join accounts, roster on date

            return view('patientHome')->with('medicationTaken', $medicationTaken)->with('meals', $meals)->with('date', $date)->with('caregiver', $caregiver)->with('doctor', $doctor);
        } else{
            return view('patientHome')->with('date', $date);
        }
    }

    public function getFamilyMemberHome(Request $request){
        $fcid = $request->input('fcid');
        $pid = $request->input('pid');

        $date = date("Y-m-d");
        if($request->input('date') == null){
            $date = date("Y-m-d");
        } else {
            $date = $request->input('date');
        }

        $medicationTaken = DB::table('medicationtaken')->select('*')->wherePatientidAndDate($pid, $date)->get();
        $medicationTaken = json_decode(json_encode($medicationTaken), true);
        
        $meals = DB::table('meals')->select('*')->wherePatientidAndDate($pid, $date)->get();
        $meals = json_decode(json_encode($meals), true);
        $x = DB::table('patient')->join('accounts', 'patient.patientID', '=', 'accounts.ID')->select('patient.patientID', 'patient.doctorID', 'patient.FCID', 'patient.groupID', 'accounts.FName', 'accounts.LName')->wherePatientidAndFcid($pid, $fcid)->get();
        $x = json_decode(json_encode($x), true);

        $doctor = DB::table('appointments')->join('accounts', 'appointments.doctorID', '=', 'accounts.ID')->select('appointments.doctorID', 'accounts.FName', 'accounts.LName')->wherePatientidAndDate($pid, $date)->get();
        $doctor = json_decode(json_encode($doctor), true);

        if($x == null){
            return view('familyMemberHome', ['FCError'=>'Family Code and Patient ID do not match.']);
        } else{
             
            $caregiver;
            // get caregiver to insert into appt table
            if ($x[0]['groupID'] == 1){
                // select * from roster r join accounts a on r.group2=a.ID where date = '2022-12-05';
                $caregiver = DB::table('accounts')->join('roster', 'roster.group1',  '=', 'accounts.ID')->select('accounts.FName', 'accounts.LName')->where('roster.date', '=', $date)->get();
            } elseif($x[0]['groupID'] == 2){
                $caregiver = DB::table('accounts')->join('roster', 'roster.group2',  '=', 'accounts.ID')->select('accounts.FName', 'accounts.LName')->where('roster.date', '=', $date)->get();
            } elseif($x[0]['groupID'] == 3){
                $caregiver = DB::table('accounts')->join('roster', 'roster.group3',  '=', 'accounts.ID')->select('accounts.FName', 'accounts.LName')->where('roster.date', '=', $date)->get();
            } elseif ($x[0]['groupID'] == 4) {
                $caregiver = DB::table('accounts')->join('roster', 'roster.group4',  '=', 'accounts.ID')->select('accounts.FName', 'accounts.LName')->where('roster.date', '=', $date)->get();
            } 
            $caregiver = json_decode(json_encode($caregiver), true);

            $appointments = DB::table('appointments')->select('date')->where('patientID', '=', $pid)->get();
            $appointments = json_decode(json_encode($appointments), true);
    
            //$appointments is an array. This pulls the value out of that array and assigns it to groupID
            foreach($appointments[0] as $v){
                $apptDate = $v;
            }
            
            $doctor = isset($doctor);

            return view('familyMemberHome')->with('FCError', 'Welcome to '.$x[0]['FName'].'\'s home page')->with('x', $x)->with('caregiver', $caregiver)->with('doctor', $doctor)->with('apptDate', $apptDate)->with('medicationTaken', $medicationTaken)->with('meals', $meals)->with('date', $date)->with('fcid', $fcid);
        }
    }

    public function postFamilyMemberHome(Request $request){
        $fcid = $request->input('fcid');
        $pid = $request->input('pid');

        $date = date("Y-m-d");
        if($request->input('date') == null){
            $date = date("Y-m-d");
        } else {
            $date = $request->input('date');
        }

        $medicationTaken = DB::table('medicationtaken')->select('*')->wherePatientidAndDate($pid, $date)->get();
        $medicationTaken = json_decode(json_encode($medicationTaken), true);
        
        $meals = DB::table('meals')->select('*')->wherePatientidAndDate($pid, $date)->get();
        $meals = json_decode(json_encode($meals), true);
        $x = DB::table('patient')->join('accounts', 'patient.patientID', '=', 'accounts.ID')->select('patient.patientID', 'patient.doctorID', 'patient.FCID', 'patient.groupID', 'accounts.FName', 'accounts.LName')->wherePatientidAndFcid($pid, $fcid)->get();
        $x = json_decode(json_encode($x), true);

        $doctor = DB::table('appointments')->join('accounts', 'appointments.doctorID', '=', 'accounts.ID')->select('appointments.doctorID', 'accounts.FName', 'accounts.LName')->wherePatientidAndDate($pid, $date)->get();
        $doctor = json_decode(json_encode($doctor), true);

        if($x == null){
            return view('familyMemberHome', ['FCError'=>'Family Code and Patient ID do not match.']);
        } else{
             
            $caregiver;
            // get caregiver to insert into appt table
            if ($x[0]['groupID'] == 1){
                // select * from roster r join accounts a on r.group2=a.ID where date = '2022-12-05';
                $caregiver = DB::table('accounts')->join('roster', 'roster.group1',  '=', 'accounts.ID')->select('accounts.FName', 'accounts.LName')->where('roster.date', '=', $date)->get();
            } elseif($x[0]['groupID'] == 2){
                $caregiver = DB::table('accounts')->join('roster', 'roster.group2',  '=', 'accounts.ID')->select('accounts.FName', 'accounts.LName')->where('roster.date', '=', $date)->get();
            } elseif($x[0]['groupID'] == 3){
                $caregiver = DB::table('accounts')->join('roster', 'roster.group3',  '=', 'accounts.ID')->select('accounts.FName', 'accounts.LName')->where('roster.date', '=', $date)->get();
            } elseif ($x[0]['groupID'] == 4) {
                $caregiver = DB::table('accounts')->join('roster', 'roster.group4',  '=', 'accounts.ID')->select('accounts.FName', 'accounts.LName')->where('roster.date', '=', $date)->get();
            } 
            $caregiver = json_decode(json_encode($caregiver), true);

            $appointments = DB::table('appointments')->select('date')->where('patientID', '=', $pid)->get();
            $appointments = json_decode(json_encode($appointments), true);
    
            //$appointments is an array. This pulls the value out of that array and assigns it to groupID
            foreach($appointments[0] as $v){
                $apptDate = $v;
            }
     
            return view('familyMemberHome')->with('FCError', 'Welcome to '.$x[0]['FName'].'\'s home page')->with('x', $x)->with('caregiver', $caregiver)->with('doctor', $doctor)->with('apptDate', $apptDate)->with('medicationTaken', $medicationTaken)->with('meals', $meals)->with('date', $date)->with('fcid', $fcid)->with('pid', $pid);
        };
    }

    public function getEmployee(){
        // get the employees info
        $emps = DB::table('accounts')
            ->join('roles', 'accounts.roleID', '=', 'roles.roleID')
            ->join('employee', 'accounts.ID', '=', 'employee.employeeID')
            ->select('employee.salary', 'roles.role', 'accounts.FName', 'accounts.LName', 'accounts.ID')
            ->where('accounts.roleID','<', 5)
            ->get();

        // get the roles for the drop down
        $roleIDs = DB::table('roles')
            ->select('role','roleID')->get();

        // get the ids for the drop down
        $empsIDs = DB::table('accounts')
            ->join('employee', 'accounts.ID', '=', 'employee.employeeID')
            ->select('ID')
            ->where('accounts.roleID','<', 5)
            ->get();

        // get the names for drop down
        $empsNames = DB::table('accounts')
            ->join('employee', 'accounts.ID', '=', 'employee.employeeID')
            ->select('FName', 'LName')
            ->where('accounts.roleID','<', 5)
            ->get();

        // get the salaries for drop down
        $empsSalaries = DB::table('accounts')
            ->join('employee', 'accounts.ID', '=', 'employee.employeeID')
            ->select('employee.salary')
            ->where('accounts.roleID','<', 5)
            ->get();

        // get all the employees 
        $empsNoSalary = DB::table('accounts')
            ->join('roles', 'accounts.roleID', '=', 'roles.roleID')
            ->select('roles.role', 'accounts.FName', 'accounts.LName', 'accounts.ID')
            ->where('accounts.roleID','<', 5)
            ->get();

        return view('employee',['Emps'=>$emps, 'RoleIDs'=>$roleIDs, 'EmpIDs'=>$empsIDs, 'EmpsNames'=>$empsNames, 'EmpSalaries'=>$empsSalaries, 'EmpsNoSalary'=>$empsNoSalary]);
    }

    public function updateEmpSalary(Request $request){
        // check if emp has a salary or not
        $isSalary = DB::select("select count(*) as count from accounts join employee  on accounts.ID = employee.employeeID where accounts.ID = ".($request->input('SalaryID')).";")[0];
        $isSalary = json_decode(json_encode($isSalary), true)["count"];

        if($isSalary == 0){
            DB::table('employee')->insert(['employeeID' => $request->input('SalaryID'), 'salary'=> $request->input('sid')]);
        }
        else{
            // set new salary for employee
         DB::table('employee')
            ->where('employeeID',  $request->input('SalaryID'))
            ->update(['salary' => $request->input('sid')]);
        }

        // get all the employees 
        $empsNoSalary = DB::table('accounts')
            ->join('roles', 'accounts.roleID', '=', 'roles.roleID')
            ->select('roles.role', 'accounts.FName', 'accounts.LName', 'accounts.ID')
            ->where('accounts.roleID','<', 5)
            ->get();

        // get the employees info with salaries
        $emps = DB::table('accounts')
            ->join('roles', 'accounts.roleID', '=', 'roles.roleID')
            ->join('employee', 'accounts.ID', '=', 'employee.employeeID')
            ->select('employee.salary', 'roles.role', 'accounts.FName', 'accounts.LName', 'accounts.ID')
            ->where('accounts.roleID','<', 5)
            ->get();

        // get the roles for the drop down
        $roleIDs = DB::table('roles')
            ->select('role','roleID')->get();

        // get the ids for the drop down
        $empsIDs = DB::table('accounts')
            ->join('employee', 'accounts.ID', '=', 'employee.employeeID')
            ->select('ID')
            ->where('accounts.roleID','<', 5)
            ->get();

        // get the names for drop down
        $empsNames = DB::table('accounts')
            ->join('employee', 'accounts.ID', '=', 'employee.employeeID')
            ->select('FName', 'LName')
            ->where('accounts.roleID','<', 5)
            ->get();

        // get the salaries for drop down
        $empsSalaries = DB::table('accounts')
            ->join('employee', 'accounts.ID', '=', 'employee.employeeID')
            ->select('employee.salary')
            ->where('accounts.roleID','<', 5)
            ->get();


         return view('employee',['Emps'=>$emps, 'RoleIDs'=>$roleIDs, 'EmpIDs'=>$empsIDs, 'EmpsNames'=>$empsNames, 'EmpSalaries'=>$empsSalaries, 'EmpsNoSalary'=>$empsNoSalary]);
    }

    public function searchEmployee(Request $request){

        //check to see what search boxs have inputs
        if($request->input('searchID') != NULL && $request->input('searchName') != NULL && $request->input('searchRole') != NULL && $request->input('searchSalary') != NULL){
            $emps = DB::table('accounts')
            ->join('roles', 'accounts.roleID', '=', 'roles.roleID')
            ->join('employee', 'accounts.ID', '=', 'employee.employeeID')
            ->select('employee.salary', 'roles.role', 'accounts.FName', 'accounts.LName', 'accounts.ID')
            ->where('accounts.roleID','=', $request->input('searchRole'))
            ->where('accounts.LName','like', "'%'.$request->input('searchName').'%'")
            ->where('accounts.ID','=', $request->input('searchID'))
            ->where('employee.salary','=', $request->input('searchSalary'))
            ->get();
        }
        elseif($request->input('searchID') != NULL && $request->input('searchName') != NULL && $request->input('searchRole') != NULL){
            $emps = DB::table('accounts')
            ->join('roles', 'accounts.roleID', '=', 'roles.roleID')
            ->join('employee', 'accounts.ID', '=', 'employee.employeeID')
            ->select('employee.salary', 'roles.role', 'accounts.FName', 'accounts.LName', 'accounts.ID')
            ->where('accounts.roleID','=', $request->input('searchRole'))
            ->where('accounts.LName','like', "'%'.$request->input('searchName').'%'")
            ->where('accounts.ID','=', $request->input('searchID'))
            ->get();
        }
        elseif($request->input('searchID') != NULL && $request->input('searchRole') != NULL && $request->input('searchSalary') != NULL){
            $emps = DB::table('accounts')
            ->join('roles', 'accounts.roleID', '=', 'roles.roleID')
            ->join('employee', 'accounts.ID', '=', 'employee.employeeID')
            ->select('employee.salary', 'roles.role', 'accounts.FName', 'accounts.LName', 'accounts.ID')
            ->where('accounts.roleID','=', $request->input('searchRole'))
            ->where('accounts.ID','=', $request->input('searchID'))
            ->where('employee.salary','=', $request->input('searchSalary'))
            ->get();
        }
        elseif($request->input('searchName') != NULL && $request->input('searchRole') != NULL && $request->input('searchSalary') != NULL){
            $emps = DB::table('accounts')
            ->join('roles', 'accounts.roleID', '=', 'roles.roleID')
            ->join('employee', 'accounts.ID', '=', 'employee.employeeID')
            ->select('employee.salary', 'roles.role', 'accounts.FName', 'accounts.LName', 'accounts.ID')
            ->where('accounts.roleID','=', $request->input('searchRole'))
            ->where('accounts.LName','like', "'%'.$request->input('searchName').'%'")
            ->where('employee.salary','=', $request->input('searchSalary'))
            ->get();
        }
        elseif($request->input('searchName') != NULL && $request->input('searchID') != NULL && $request->input('searchSalary') != NULL){
            $emps = DB::table('accounts')
            ->join('roles', 'accounts.roleID', '=', 'roles.roleID')
            ->join('employee', 'accounts.ID', '=', 'employee.employeeID')
            ->select('employee.salary', 'roles.role', 'accounts.FName', 'accounts.LName', 'accounts.ID')
            ->where('accounts.LName','like', "'%'.$request->input('searchName').'%'")
            ->where('accounts.ID','=', $request->input('searchID'))
            ->where('employee.salary','=', $request->input('searchSalary'))
            ->get();
        }
        elseif($request->input('searchName') != NULL && $request->input('searchRole') != NULL){
            $emps = DB::table('accounts')
            ->join('roles', 'accounts.roleID', '=', 'roles.roleID')
            ->join('employee', 'accounts.ID', '=', 'employee.employeeID')
            ->select('employee.salary', 'roles.role', 'accounts.FName', 'accounts.LName', 'accounts.ID')
            ->where('accounts.roleID','=', $request->input('searchRole'))
            ->where('accounts.LName','like', "'%'.$request->input('searchName').'%'")
            ->get();
        }
        elseif($request->input('searchName') != NULL && $request->input('searchID') != NULL){
            $emps = DB::table('accounts')
            ->join('roles', 'accounts.roleID', '=', 'roles.roleID')
            ->join('employee', 'accounts.ID', '=', 'employee.employeeID')
            ->select('employee.salary', 'roles.role', 'accounts.FName', 'accounts.LName', 'accounts.ID')
            ->where('accounts.ID','=', $request->input('searchID'))
            ->where('accounts.LName','like', "'%'.$request->input('searchName').'%'")
            ->get();
        }
        elseif($request->input('searchName') != NULL && $request->input('searchSalaray') != NULL){
            $emps = DB::table('accounts')
            ->join('roles', 'accounts.roleID', '=', 'roles.roleID')
            ->join('employee', 'accounts.ID', '=', 'employee.employeeID')
            ->select('employee.salary', 'roles.role', 'accounts.FName', 'accounts.LName', 'accounts.ID')
            ->where('employee.salary','=', $request->input('searchSalary'))
            ->where('accounts.LName','like', "'%'.$request->input('searchName').'%'")
            ->get();
        }
        elseif($request->input('searchRole') != NULL && $request->input('searchID') != NULL){
            $emps = DB::table('accounts')
            ->join('roles', 'accounts.roleID', '=', 'roles.roleID')
            ->join('employee', 'accounts.ID', '=', 'employee.employeeID')
            ->select('employee.salary', 'roles.role', 'accounts.FName', 'accounts.LName', 'accounts.ID')
            ->where('accounts.ID','=', $request->input('searchID'))
            ->where('accounts.roleID','=', $request->input('searchRole'))
            ->get();
        }
        elseif($request->input('searchRole') != NULL && $request->input('searchSalary') != NULL){
            $emps = DB::table('accounts')
            ->join('roles', 'accounts.roleID', '=', 'roles.roleID')
            ->join('employee', 'accounts.ID', '=', 'employee.employeeID')
            ->select('employee.salary', 'roles.role', 'accounts.FName', 'accounts.LName', 'accounts.ID')
            ->where('employee.salary','=', $request->input('searchSalary'))
            ->where('accounts.roleID','=', $request->input('searchRole'))
            ->get();
        }
        elseif($request->input('searchSalary') != NULL && $request->input('searchID') != NULL){
            $emps = DB::table('accounts')
            ->join('roles', 'accounts.roleID', '=', 'roles.roleID')
            ->join('employee', 'accounts.ID', '=', 'employee.employeeID')
            ->select('employee.salary', 'roles.role', 'accounts.FName', 'accounts.LName', 'accounts.ID')
            ->where('accounts.ID','=', $request->input('searchID'))
            ->where('employee.salary','=', $request->input('searchSalary'))
            ->get();
        }
        elseif($request->input('searchSalary') != NULL){
            $emps = DB::table('accounts')
            ->join('roles', 'accounts.roleID', '=', 'roles.roleID')
            ->join('employee', 'accounts.ID', '=', 'employee.employeeID')
            ->select('employee.salary', 'roles.role', 'accounts.FName', 'accounts.LName', 'accounts.ID')
            ->where('employee.salary','=', $request->input('searchSalary'))
            ->get();
        }
        elseif($request->input('searchRole') != NULL){
            $emps = DB::table('accounts')
            ->join('roles', 'accounts.roleID', '=', 'roles.roleID')
            ->join('employee', 'accounts.ID', '=', 'employee.employeeID')
            ->select('employee.salary', 'roles.role', 'accounts.FName', 'accounts.LName', 'accounts.ID')
            ->where('accounts.roleID','=', $request->input('searchRole'))
            ->get();
        }
        elseif($request->input('searchName') != NULL){
            $emps = DB::table('accounts')
            ->join('roles', 'accounts.roleID', '=', 'roles.roleID')
            ->join('employee', 'accounts.ID', '=', 'employee.employeeID')
            ->select('employee.salary', 'roles.role', 'accounts.FName', 'accounts.LName', 'accounts.ID')
            ->where('accounts.LName','like', "'%'.$request->input('searchName').'%'")
            ->get();
        }
        elseif($request->input('searchID') != NULL){
            $emps = DB::table('accounts')
            ->join('roles', 'accounts.roleID', '=', 'roles.roleID')
            ->join('employee', 'accounts.ID', '=', 'employee.employeeID')
            ->select('employee.salary', 'roles.role', 'accounts.FName', 'accounts.LName', 'accounts.ID')
            ->where('accounts.ID','=', $request->input('searchID'))
            ->get();
        }
        else{
            $emps = DB::table('accounts')
            ->join('roles', 'accounts.roleID', '=', 'roles.roleID')
            ->join('employee', 'accounts.ID', '=', 'employee.employeeID')
            ->select('employee.salary', 'roles.role', 'accounts.FName', 'accounts.LName', 'accounts.ID')
            ->where('accounts.roleID','<', 5)
            ->get();
        }
        
        // get all the employees 
        $empsNoSalary = DB::table('accounts')
            ->join('roles', 'accounts.roleID', '=', 'roles.roleID')
            ->select('roles.role', 'accounts.FName', 'accounts.LName', 'accounts.ID')
            ->where('accounts.roleID','<', 5)
            ->get();

        // get the roles for the drop down
        $roleIDs = DB::table('roles')
            ->select('role','roleID')->get();

        // get the ids for the drop down
        $empsIDs = DB::table('accounts')
            ->join('employee', 'accounts.ID', '=', 'employee.employeeID')
            ->select('ID')
            ->where('accounts.roleID','<', 5)
            ->get();

        // get the names for drop down
        $empsNames = DB::table('accounts')
            ->join('employee', 'accounts.ID', '=', 'employee.employeeID')
            ->select('FName', 'LName')
            ->where('accounts.roleID','<', 5)
            ->get();

        // get the salaries for drop down
        $empsSalaries = DB::table('accounts')
            ->join('employee', 'accounts.ID', '=', 'employee.employeeID')
            ->select('employee.salary')
            ->where('accounts.roleID','<', 5)
            ->get();
        
        return view('employee',['Emps'=>$emps, 'RoleIDs'=>$roleIDs, 'EmpIDs'=>$empsIDs, 'EmpsNames'=>$empsNames, 'EmpSalaries'=>$empsSalaries, 'EmpsNoSalary'=>$empsNoSalary]);
    }

    public function getPatients(){
        //SELECT p.patientID, p.admissionDate, p.emContact, p.relationEmContact, p.emContactPhNo, a.FName, a.LName FROM patient p join accounts a on p.patientID = a.ID;
        $allPatients = DB::table('patient')->join('accounts', 'patient.patientID', '=', 'accounts.ID')->select('patient.patientID', 'patient.admissionDate', 'patient.emContact', 'patient.relationEmContact', 'patient.emContactPhNo', 'accounts.FName', 'accounts.LName', 'accounts.DOB')->get();
        $allPatients = json_decode(json_encode($allPatients), true);

        return view('patients')->with('allPatients', $allPatients);
    }

public function postPatients(Request $request){
    //SELECT p.patientID, p.admissionDate, p.emContact, p.relationEmContact, p.emContactPhNo, a.FName, a.LName FROM patient p join accounts a on p.patientID = a.ID;
    $allPatients = DB::table('patient')->join('accounts', 'patient.patientID', '=', 'accounts.ID')->select('patient.patientID', 'patient.admissionDate', 'patient.emContact', 'patient.relationEmContact', 'patient.emContactPhNo', 'accounts.FName', 'accounts.LName', 'accounts.DOB')->get();
    $allPatients = json_decode(json_encode($allPatients), true);

    $id = $request->input('searchID');
    $fName = $request->input('searchFName');
    $lName = $request->input('searchLName');
    $DOB= $request->input('searchDOB');
    $REC = $request->input('searchREC');
    $EC = $request->input('searchEC');
    $AD = $request->input('searchAD');

    if(isset($id)){
        $searchID = DB::table('patient')->join('accounts', 'patient.patientID', '=', 'accounts.ID')
        ->select('patient.patientID', 'patient.admissionDate', 'patient.emContact', 'patient.relationEmContact', 'patient.emContactPhNo', 'accounts.FName', 'accounts.LName', 'accounts.DOB')
        ->where('accounts.ID', '=', $id)->get();
        $searchID = json_decode(json_encode($searchID), true);
        return view('patients')->with('allPatients', $searchID);
    } elseif (isset($fName)){
        $searchFName = DB::table('patient')->join('accounts', 'patient.patientID', '=', 'accounts.ID')
        ->select('patient.patientID', 'patient.admissionDate', 'patient.emContact', 'patient.relationEmContact', 'patient.emContactPhNo', 'accounts.FName', 'accounts.LName', 'accounts.DOB')
        ->where('accounts.FName', '=', $fName)->get();
        $searchFName = json_decode(json_encode($searchFName), true);
        return view('patients')->with('allPatients', $searchFName);
    } elseif (isset($lName)){
        $searchLName = DB::table('patient')->join('accounts', 'patient.patientID', '=', 'accounts.ID')
        ->select('patient.patientID', 'patient.admissionDate', 'patient.emContact', 'patient.relationEmContact', 'patient.emContactPhNo', 'accounts.FName', 'accounts.LName', 'accounts.DOB')
        ->where('accounts.LName', '=', $lName)->get();
        $searchLName = json_decode(json_encode($searchLName), true);
        return view('patients')->with('allPatients', $searchLName);
    }elseif (isset($DOB)){
        $searchDOB = DB::table('patient')->join('accounts', 'patient.patientID', '=', 'accounts.ID')
        ->select('patient.patientID', 'patient.admissionDate', 'patient.emContact', 'patient.relationEmContact', 'patient.emContactPhNo', 'accounts.FName', 'accounts.LName', 'accounts.DOB')
        ->where('accounts.DOB', '=', $DOB)->get();
        $searchDOB = json_decode(json_encode($searchDOB), true);
        return view('patients')->with('allPatients', $searchDOB);
    }elseif (isset($REC)){
        $searchREC = DB::table('patient')->join('accounts', 'patient.patientID', '=', 'accounts.ID')
        ->select('patient.patientID', 'patient.admissionDate', 'patient.emContact', 'patient.relationEmContact', 'patient.emContactPhNo', 'accounts.FName', 'accounts.LName', 'accounts.DOB')
        ->where('patient.relationEmContact', '=', $REC)->get();
        $searchREC = json_decode(json_encode($searchREC), true);
        return view('patients')->with('allPatients', $searchREC);
    }elseif (isset($EC)){
        $searchEC = DB::table('patient')->join('accounts', 'patient.patientID', '=', 'accounts.ID')
        ->select('patient.patientID', 'patient.admissionDate', 'patient.emContact', 'patient.relationEmContact', 'patient.emContactPhNo', 'accounts.FName', 'accounts.LName', 'accounts.DOB')
        ->where('patient.emContact', '=', $EC)->get();
        $searchEC = json_decode(json_encode($searchEC), true);
        return view('patients')->with('allPatients', $searchEC);
    }elseif (isset($AD)){
        $searchAD = DB::table('patient')->join('accounts', 'patient.patientID', '=', 'accounts.ID')
        ->select('patient.patientID', 'patient.admissionDate', 'patient.emContact', 'patient.relationEmContact', 'patient.emContactPhNo', 'accounts.FName', 'accounts.LName', 'accounts.DOB')
        ->where('patient.admissionDate', '=', $AD)->get();
        $searchAD = json_decode(json_encode($searchAD), true);
        return view('patients')->with('allPatients', $searchAD);
    }
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
        $rosterDate = DB::table('roster')->where
        ('date', $request->input('frmDateReg'))->get();

        // check roster to see if we already have a roster for that date
        $DateCount = DB::table('roster')->where('date', '=', $request->input('frmDateReg'))->get();
        $DateCount = $DateCount->count();

        if($DateCount >= 1){
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

    public function getDoctorHome(Request $request){
        $did = $_SESSION['user1'][0]['ID'];
        $date = $request->input('date');
        $search = $request->input('searchAttribute');
        $searchText = $request->input('searchText');

        if($search == 1){
            $FName = DB::table('appointments')->join('accounts', 'appointments.patientID', '=', 'accounts.ID')->join('medicationTaken', 'appointments.date', '=', 'medicationTaken.date')->distinct()->select('appointments.patientID', 'appointments.comment', 'appointments.date', 'accounts.FName', 'accounts.LName', 'medicationtaken.morningMed', 'medicationtaken.afternoonMed', 'medicationtaken.nightMed')->where('appointments.doctorID', '=', $did)->where('appointments.date', '<', date("Y-m-d"))->where('accounts.FName', '=', $searchText)->get();
            $FName = json_decode(json_encode($FName), true);

            if(isset($date)){
                $upcomingAppts = DB::table('appointments')->join('accounts', 'appointments.patientID', '=', 'accounts.ID')->join('medicationTaken', 'appointments.date', '=', 'medicationTaken.date')->distinct()->select('appointments.patientID', 'appointments.comment', 'appointments.date', 'accounts.FName', 'accounts.LName', 'medicationtaken.morningMed', 'medicationtaken.afternoonMed', 'medicationtaken.nightMed')->where('appointments.doctorID', '=', $did)->whereBetween('appointments.date', [date("Y-m-d"), $date])->get();
                $upcomingAppts = json_decode(json_encode($upcomingAppts), true);
                return view('doctorHome')->with('oldAppts', $FName)->with('upcomingAppts', $upcomingAppts);
            } else {
                return view('doctorHome')->with('oldAppts', $FName);
            }

        } elseif($search == 2){
            $LName = DB::table('appointments')->join('accounts', 'appointments.patientID', '=', 'accounts.ID')->join('medicationTaken', 'appointments.date', '=', 'medicationTaken.date')->distinct()->select('appointments.patientID', 'appointments.comment', 'appointments.date', 'accounts.FName', 'accounts.LName', 'medicationtaken.morningMed', 'medicationtaken.afternoonMed', 'medicationtaken.nightMed')->where('appointments.doctorID', '=', $did)->where('appointments.date', '<', date("Y-m-d"))->where('accounts.LName', '=', $searchText)->get();
            $LName = json_decode(json_encode($LName), true);

            if(isset($date)){
                $upcomingAppts = DB::table('appointments')->join('accounts', 'appointments.patientID', '=', 'accounts.ID')->join('medicationTaken', 'appointments.date', '=', 'medicationTaken.date')->distinct()->select('appointments.patientID', 'appointments.comment', 'appointments.date', 'accounts.FName', 'accounts.LName', 'medicationtaken.morningMed', 'medicationtaken.afternoonMed', 'medicationtaken.nightMed')->where('appointments.doctorID', '=', $did)->whereBetween('appointments.date', [date("Y-m-d"), $date])->get();
                $upcomingAppts = json_decode(json_encode($upcomingAppts), true);
                return view('doctorHome')->with('oldAppts', $LName)->with('upcomingAppts', $upcomingAppts);
            } else {
                return view('doctorHome')->with('oldAppts', $LName);
            } 

        }elseif($search == 3){
            $comment = DB::table('appointments')->join('accounts', 'appointments.patientID', '=', 'accounts.ID')->join('medicationTaken', 'appointments.date', '=', 'medicationTaken.date')->distinct()->select('appointments.patientID', 'appointments.comment', 'appointments.date', 'accounts.FName', 'accounts.LName', 'medicationtaken.morningMed', 'medicationtaken.afternoonMed', 'medicationtaken.nightMed')->where('appointments.doctorID', '=', $did)->where('appointments.date', '<', date("Y-m-d"))->where('appointments.comment', 'like', '%'.$searchText.'%')->get();
            $comment = json_decode(json_encode($comment), true);

            if(isset($date)){
                $upcomingAppts = DB::table('appointments')->join('accounts', 'appointments.patientID', '=', 'accounts.ID')->join('medicationTaken', 'appointments.date', '=', 'medicationTaken.date')->distinct()->select('appointments.patientID', 'appointments.comment', 'appointments.date', 'accounts.FName', 'accounts.LName', 'medicationtaken.morningMed', 'medicationtaken.afternoonMed', 'medicationtaken.nightMed')->where('appointments.doctorID', '=', $did)->whereBetween('appointments.date', [date("Y-m-d"), $date])->get();
                $upcomingAppts = json_decode(json_encode($upcomingAppts), true);
                return view('doctorHome')->with('oldAppts', $comment)->with('upcomingAppts', $upcomingAppts);
            } else {
                return view('doctorHome')->with('oldAppts', $comment);
            } 

        } else {
            //SELECT DISTINCT a.patientID, a.comment, a.date, aa.FName, aa.LName, m.morningMed, m.afternoonMed, m.nightMed FROM accounts aa join appointments a on a.patientID=aa.ID join medicationtaken m on a.date = m.date where a.doctorID = 43;
            $oldAppts = DB::table('appointments')->join('accounts', 'appointments.patientID', '=', 'accounts.ID')->join('medicationTaken', 'appointments.date', '=', 'medicationTaken.date')->distinct()->select('appointments.patientID', 'appointments.comment', 'appointments.date', 'accounts.FName', 'accounts.LName', 'medicationtaken.morningMed', 'medicationtaken.afternoonMed', 'medicationtaken.nightMed')->where('appointments.doctorID', '=', $did)->where('appointments.date', '<', date("Y-m-d"))->get();
            $oldAppts = json_decode(json_encode($oldAppts), true);

            if(isset($date)){
                $upcomingAppts = DB::table('appointments')->join('accounts', 'appointments.patientID', '=', 'accounts.ID')->join('medicationTaken', 'appointments.date', '=', 'medicationTaken.date')->distinct()->select('appointments.patientID', 'appointments.comment', 'appointments.date', 'accounts.FName', 'accounts.LName', 'medicationtaken.morningMed', 'medicationtaken.afternoonMed', 'medicationtaken.nightMed')->where('appointments.doctorID', '=', $did)->whereBetween('appointments.date', [date("Y-m-d"), $date])->get();
                $upcomingAppts = json_decode(json_encode($upcomingAppts), true);
                return view('doctorHome')->with('oldAppts', $oldAppts)->with('upcomingAppts', $upcomingAppts);
            } else {
                return view('doctorHome')->with('oldAppts', $oldAppts);
            } 
        }
    }

    public function getPatientOfDoctor(Request $request){
        $did = $_SESSION['user1'][0]['ID'];
        
 
        return view('patientOfDoctor');
    }

    public function postPatientOfDoctor(Request $request){
        $did = $_SESSION['user1'][0]['ID'];
        $comment = $request->input('comment');
        $morningMed = $request->input('morningMed');
        $afternoonMed = $request->input('afternoonMed');
        $nightMed = $request->input('nightMed');
        $pid = $request->input('pid');
        
        DB::table('appointments')
        ->updateOrInsert(
            ['date'=> date('Y-m-d'), 'patientID' => $pid, 'doctorID' => $did],
            ['comment' => $comment]
        );
        
        DB::table('patient')->updateOrInsert(
            ['doctorID' => $did, 'patientID' => $pid],
            ['medNameMorning'=> $morningMed, 'medNameAfternoon'=> $afternoonMed, 'medNameNight'=> $nightMed ]
        );
        
        return view('patientOfDoctor');
    }
    

    public function getCaregiverHome(){
        // get all the patients for the group that the caregiver is working for that day

        $pid = $_SESSION['user1'][0]['ID'];

        // get the roster for current date and PID in group 1
        $Roster = DB::table('roster')
            ->where('date', '=' , date('Y-m-d'))
            ->where('group1', '=', $pid)->get();

        $RosterCount = $Roster->count();

        if($RosterCount >= 1){
            $Group1 = DB::table('accounts')
            ->join('patient', 'accounts.ID', '=', 'patient.patientID')
            ->join('meals', 'meals.patientID', '=', 'accounts.ID')
            ->join('medicationtaken', 'medicationtaken.patientID', '=', 'accounts.ID')
            ->where('patient.groupID', '=', '1')
            ->where('meals.date', '=', date('Y-m-d'))
            ->where('medicationtaken.date', '=', date('Y-m-d'))
            ->get();


            return view('caregiverHome', ['Group1'=>$Group1]);
            
        }
        /// try for group 2

        $Roster = DB::table('roster')
        ->where('date', '=' , date('Y-m-d'))
        ->where('group2', '=', $pid)->get();

        $RosterCount = $Roster->count();

        if($RosterCount >= 1){
            $Group1 = DB::table('accounts')
            ->join('patient', 'accounts.ID', '=', 'patient.patientID')
            ->join('meals', 'meals.patientID', '=', 'accounts.ID')
            ->join('medicationtaken', 'medicationtaken.patientID', '=', 'accounts.ID')
            ->where('patient.groupID', '=', '1')
            ->where('meals.date', '=', date('Y-m-d'))
            ->where('medicationtaken.date', '=', date('Y-m-d'))
            ->get();

            return view('caregiverHome', ['Group1'=>$Group1]);
        
        }

        /// try for group 3

        $Roster = DB::table('roster')
        ->where('date', '=' , date('Y-m-d'))
        ->where('group3', '=', $pid)->get();

        $RosterCount = $Roster->count();


        if($RosterCount >= 1){
            $Group1 = DB::table('accounts')
            ->join('patient', 'accounts.ID', '=', 'patient.patientID')
            ->join('meals', 'meals.patientID', '=', 'accounts.ID')
            ->join('medicationtaken', 'medicationtaken.patientID', '=', 'accounts.ID')
            ->where('patient.groupID', '=', '1')
            ->where('meals.date', '=', date('Y-m-d'))
            ->where('medicationtaken.date', '=', date('Y-m-d'))
            ->get();

            return view('caregiverHome', ['Group1'=>$Group1]);
            
        }

        /// try for group 4

        $Roster = DB::table('roster')
        ->where('date', '=' , date('Y-m-d'))
        ->where('group4', '=', $pid)->get();

        $RosterCount = $Roster->count();

        if($RosterCount >= 1){
            $Group1 = DB::table('accounts')
            ->join('patient', 'accounts.ID', '=', 'patient.patientID')
            ->join('medicationtaken', 'medicationtaken.patientID', '=', 'accounts.ID')
            ->where('patient.groupID', '=', '1')
            ->where('meals.date', '=', date('Y-m-d'))
            ->where('medicationtaken.date', '=', date('Y-m-d'))
            ->get();

            return view('caregiverHome', ['Group1'=>$Group1]);

        }
        
        return view('caregiverHome');
    }

    public function postCaregiverHome(Request $request){
        // get the values of the checkboxes and see if they are check or not for meals
        if($request->filled('checkbox-4')){
            $checkBox4 = 1;
        }
        else{
            $checkBox4 = 0;
        }
        if($request->filled('checkbox-5')){
            $checkBox5 = 1;
        }
        else{
            $checkBox5 = 0;
        }
        if($request->filled('checkbox-6')){
            $checkBox6 = 1;
        }
        else{
            $checkBox6 = 0;
        }

        // update meals 
        DB::table('meals')->updateOrInsert(
            ['date'=> date('Y-m-d'), 'patientID' => $request->input('PID')],
            ['breakfast'=> $checkBox4, 'lunch'=> $checkBox5, 'dinner'=> $checkBox6]
        );

        // get the values of the checkboxes and see if they are check or not for meals
        if($request->filled('checkbox-1')){
            $checkBox1 = 1;
        }
        else{
            $checkBox1 = 0;
        }
        if($request->filled('checkbox-2')){
            $checkBox2 = 1;
        }
        else{
            $checkBox2 = 0;
        }
        if($request->filled('checkbox-3')){
            $checkBox3 = 1;
        }
        else{
            $checkBox3 = 0;
        }

        // update medication taken
        DB::table('medicationtaken')->updateOrInsert(
            ['date'=> date('Y-m-d'), 'patientID' => $request->input('PID')],
            ['morningMed'=> $checkBox1, 'afternoonMed'=> $checkBox2, 'nightMed'=> $checkBox3 ]
        );


        // get all the patients for the group that the caregiver is working for that day
        $pid = $_SESSION['user1'][0]['ID'];

        // get the roster for current date and PID in group 1
        $Roster = DB::table('roster')
            ->where('date', '=' , date('Y-m-d'))
            ->where('group1', '=', $pid)->get();

        $RosterCount = $Roster->count();

        if($RosterCount >= 1){
            $Group1 = DB::table('accounts')
            ->join('patient', 'accounts.ID', '=', 'patient.patientID')
            ->join('meals', 'meals.patientID', '=', 'accounts.ID')
            ->join('medicationtaken', 'medicationtaken.patientID', '=', 'accounts.ID')
            ->where('patient.groupID', '=', '1')
            ->where('meals.date', '=', date('Y-m-d'))
            ->where('medicationtaken.date', '=', date('Y-m-d'))
            ->get();

            return view('caregiverHome', ['Group1'=>$Group1]);
            
        }
        /// try for group 2

        $Roster = DB::table('roster')
        ->where('date', '=' , date('Y-m-d'))
        ->where('group2', '=', $pid)->get();

        $RosterCount = $Roster->count();

        if($RosterCount >= 1){
            $Group1 = DB::table('accounts')
            ->join('patient', 'accounts.ID', '=', 'patient.patientID')
            ->join('meals', 'meals.patientID', '=', 'accounts.ID')
            ->join('medicationtaken', 'medicationtaken.patientID', '=', 'accounts.ID')
            ->where('patient.groupID', '=', '1')
            ->where('meals.date', '=', date('Y-m-d'))
            ->where('medicationtaken.date', '=', date('Y-m-d'))
            ->get();

            return view('caregiverHome', ['Group1'=>$Group1]);
        
        }

        /// try for group 3

        $Roster = DB::table('roster')
        ->where('date', '=' , date('Y-m-d'))
        ->where('group3', '=', $pid)->get();

        $RosterCount = $Roster->count();


        if($RosterCount >= 1){
            $Group1 = DB::table('accounts')
            ->join('patient', 'accounts.ID', '=', 'patient.patientID')
            ->join('meals', 'meals.patientID', '=', 'accounts.ID')
            ->join('medicationtaken', 'medicationtaken.patientID', '=', 'accounts.ID')
            ->where('patient.groupID', '=', '1')
            ->where('meals.date', '=', date('Y-m-d'))
            ->where('medicationtaken.date', '=', date('Y-m-d'))
            ->get();

            return view('caregiverHome', ['Group1'=>$Group1]);
            
        }

        /// try for group 4

        $Roster = DB::table('roster')
        ->where('date', '=' , date('Y-m-d'))
        ->where('group4', '=', $pid)->get();

        $RosterCount = $Roster->count();

        if($RosterCount >= 1){
            $Group1 = DB::table('accounts')
            ->join('patient', 'accounts.ID', '=', 'patient.patientID')
            ->join('meals', 'meals.patientID', '=', 'accounts.ID')
            ->join('medicationtaken', 'medicationtaken.patientID', '=', 'accounts.ID')
            ->where('patient.groupID', '=', '1')
            ->where('meals.date', '=', date('Y-m-d'))
            ->where('medicationtaken.date', '=', date('Y-m-d'))
            ->get();

            return view('caregiverHome', ['Group1'=>$Group1]);

        }
        return view('caregiverHome');
    }

    public function getAdminReport(){
        $Group1 = DB::table('accounts')
            ->join('patient', 'accounts.ID', '=', 'patient.patientID')
            ->join('meals', 'meals.patientID', '=', 'accounts.ID')
            ->join('medicationtaken', 'medicationtaken.patientID', '=', 'accounts.ID')
            ->where('accounts.roleID', '=', '5')
            ->where('meals.date', '=', date('Y-m-d'))
            ->where('medicationtaken.date', '=', date('Y-m-d'))
            ->get();

        return view('adminReport', ['Group1'=>$Group1]);
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

   



    // Redirect to correct Home Page based on Role
    public function goBack() {
        // get account role ID
        $roleID = $_SESSION['user1'][0]['roleID'];

        // checks if their account is Admin
        if($roleID == 1){
            return redirect('/adminIndex');
        }
        if($roleID == 2){
            return redirect('/superIndex');
        }
        if($roleID == 3){
            return redirect('/docIndex');
        }
        if($roleID == 4){
            return redirect('/careIndex');
        }
        if($roleID == 5){
            return redirect('/patientHome');
        }
        if($roleID == 6){
            return redirect('/familyMemberHome');
        }
        return redirect('/login');
}


}

