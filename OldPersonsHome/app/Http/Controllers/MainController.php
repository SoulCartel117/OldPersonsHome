<?php

namespace App\Http\Controllers;

use App\Models\accounts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
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
        // $fields = ([
        //     'FName'=>request()->input('fname'),
        //     'LName'=>request()->input('lname'),
        //     'email'=>request()->input('email'),
        //     'phNo'=>request()->input('phone'),
        //     'password'=>request()->input('password'),
        //     'DOB'=>request()->input('DOB')
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
        // DB::table('accounts')->insert(['FName'=>'fname']);
        // DB::table('accounts')->insert(['LName'=>'lname']);
        // DB::table('accounts')->insert(['Email'=>'email']);
        // DB::table('accounts')->insert(['phNo'=>'phone']);
        // DB::table('accounts')->insert(['password'=>'password']);
        // DB::table('accounts')->insert(['DOB'=>'DOB']);

        // accounts::create([
        //     'roleID'=>$fields['role'],
        //     'FName'=>$fields['fname'],
        //     'LName'=>$fields['lname'],
        //     'Email'=>$fields['email'],
        //     'phNo'=>$fields['phone'],
        //     'password'=>$fields['password'],
        //     'DOB'=>$fields['DOB']
            
        // ]);
        return redirect('/login');
    }
}
