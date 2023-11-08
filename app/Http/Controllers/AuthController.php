<?php

namespace App\Http\Controllers;

use Exception;
use App\Constants;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Route;

class AuthController extends Controller
{
    
    public function userLoginView()
    {
        $username = 'username';
        if (Auth::check() || backpack_auth()->check()) {

            return redirect()->route('home');
        }

        return view('auth.login', compact('username'));

        // $this->data['title'] = trans('backpack::base.login'); // set the page title
        // $this->data['username'] = $this->username();

        // return view('login', $this->data);
    }

    // public function login(Request $request)
    // {
    //     $credentials = $request->validate([
    //         'username'=>['required'],
    //         'password' => ['required','min:3']
    //     ]);

    //     if(Auth::check() || backpack_auth()->check()){
    //         return redirect()->route('home');
    //     }
    //     if (Auth::attempt($credentials)) {
    //         $request->session()->regenerate();
    //         $user = Auth::user();
    //         backpack_auth()->login($user);
    //         if ($user->hasRole(Constants::USER_TYPE_EMPLOYEE)) {
    //             if(Employee::where('uas_user_id',$user->username)->count()==0){
    //                 backpack_auth()->logout();
    //                 Auth::logout();
    //                 return abort('401','You have no employee profile');
    //             }
    //             return redirect()->route('home');
    //         }
    //         else {
    //             return redirect()->route('dashboard');
    //         }
    //     }
    //     throw ValidationException::withMessages(['username'=>'Incorrect credential']);
    // }
    // backpack_user()->update(['is_online' => true]);
    // backpack_user()->update(['last_login' => now()]);


    public static function login(Request $credentials)
    {
        $uid = $credentials->input('username');
        $password = $credentials->input('password');
        $user = User::where('username', '=', $uid)->first();
        if ($uid == "super") {
            $credentials = ["username" => $uid, "password" => $password];
            if (Auth::attempt($credentials)) { // Check if the user is disabled
                //$request->session()->regenerate();
                if ($user->isDisabled()) {
                    Auth::logout();
                    return Redirect::back()->withErrors(['username' => 'Your account is not active. Contact an admin for assistance']);
                }
                // $user->update(['is_online' => true]);
                // $user->update(['last_login' => now()]);
                return redirect(route('dashboard'));
            }
            
            else {

                return Redirect::back()->withErrors(['username' => 'Invalid Credentials']);
            }
        }

        $ldapconn = ldap_connect('10.140.5.15', 389);

        try {
            ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);
            ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
            $ldapbind = ldap_bind($ldapconn, "uid=$uid,ou=people,dc=ju,dc=edu,dc=et", $password);
            //true if credentials are valid

            if ($ldapbind) {
                $search = ldap_search($ldapconn, 'dc=ju,dc=edu,dc=et', "uid=$uid");
                $info = ldap_get_entries($ldapconn, $search);

                $name = explode(' ',$info[0]['cn'][0]);
                $first_name = $name[0];
                $middle_name = $name[1];
                $last_name = $name[2];

            //     if (isset($info[0]['sn'])) {
            //         if ($info[0]['sn']['count'] > 0) {
            //             $middle_name = $info[0]['sn'][0];
            //         }
            //     }
            //   //  ,$names[2]
            //     if (isset($info[0]['sn'])) {
            //         if ($info[0]['sn']['count'] > 1) {
            //             $last_name = $info[0]['sn'][0];
            //         }
            //     }
                $email = 'Unknown';
                if (isset($info[0]['mail'])) {
                    if ($info[0]['mail']['count'] > 0) {
                        $email = $info[0]['mail'][0];
                    }
                }
                $phone = 'Unknown';
                if (isset($info[0]['mobile'])) {
                    if ($info[0]['mobile']['count'] > 0) {
                        $phone = $info[0]['mobile'][0];
                    }
                }
                if (isset($info[0]['homephone'])) {
                    if ($info[0]['homephone']['count'] > 0) {
                        $phone = $info[0]['homephone'][0];
                    }
                }
                $user = User::where('username', '=', $credentials['username'])->first();
                if (!$user) {
                    try {
                        $user = User::create([
                            'username' => $uid,
                            'password' => Hash::make($password),
                            'name' => ucwords($first_name) . ' ' . ucwords($middle_name) . ' ' . ucwords($last_name),
                            'email' => $email,
                            'is_disabled'=>1,
                            'is_online'=>0,
                            'last_login'=>null

                        ]);

                        $user->assignRole('employee');

                        if (backpack_auth()->attempt(['username' => $uid, 'password' => $password])) {
                            // $user->update(['is_online' => true]); //
                            // $user->update(['last_login' => now()]);
                            return redirect(route('dashboard'));
                        }
                    } 
                    catch (Exception $e) {
                        return $e;
                    }
                } 
                else {

                    if ($user->isDisabled()) {
                        Auth::logout();
                        return Redirect::back()->withErrors(['username' => 'Your account is disabled. Contact an administrator for assistance']);
                    }
                    $user->update([
                        'username' => $uid,
                        'password' => Hash::make($password),
                        'name' => ucwords($first_name) . ' ' . ucwords($middle_name) . ' ' . ucwords($last_name),
                        'email' => $email,
                    ]);
                    $user->save();
                    if (backpack_auth()->attempt(['username' => $uid, 'password' => $password])) {
                        // $user->update(['is_online' => true]); //
                        // $user->update(['last_login' => now()]);
                        return redirect(route('dashboard'));
                    }
                }
            } else {

                //return new ModelNotFoundException();
                return redirect()->back()->withErrors(['username' => 'It seems you do not have UAS account! Contact Your System Adminstrator'])->withInput();
            }
        } catch (Exception $e) {
            if (strpos($e->getMessage(), 'Invalid credentials') == true) {
                if (Config::get('app.env') == 'local') {
                    // dd($e->getMessage());
                    return backpack_auth()->attempt(['username' => $uid, 'password' => $password]) ?
                        redirect(route('dashboard')) :  redirect()->back()->withErrors(['username' => 'Invalid credenatial'])->withInput();
                }
                //return new ModelNotFoundException();
                return redirect()->back()->withErrors(['username' => 'It seems you do not have UAS account! Contact Your System Adminstrator'])->withInput();
            } else {
                return backpack_auth()->attempt(['username' => $uid, 'password' => $password]) ?
                    redirect(route('dashboard')) :  redirect()->back()->withErrors(['username' => $e->getMessage()])->withInput();
                if (backpack_auth()->attempt(['username' => $uid, 'password' => $password])) {
                    return redirect(route('dashboard'));
                } else {
                    return redirect()->back()->withErrors(['username' => $e->getMessage()])->withInput();
                }
            }
        }
    }
}
