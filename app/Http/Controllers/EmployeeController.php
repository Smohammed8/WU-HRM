<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    //

    public function home()
    {
        $user = Auth::user();
        $employee = Employee::where('uas_user_id',$user->id);
        if($employee->count()==0){
            return abort(405,'Please you have no employee profile contact admin');
        }
        $employee = $employee->first();
        return view('home',compact('user','employee'));
    }
}
