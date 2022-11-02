<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use DateTime;
//use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = DB::table('users')->count();
        $employees = DB::table('employees')->count();
<<<<<<< HEAD
<<<<<<< HEAD
        return view('dashboard', compact( 'users', 'employees',));
=======
        return view('dashboard', compact( 'users', 'employees',

        ));
>>>>>>> 93ea9f6 (solving issues)
=======
        return view('dashboard', compact( 'users', 'employees',));
>>>>>>> d431a57 (importing)
    }
}
