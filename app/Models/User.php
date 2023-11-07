<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Role;
use App\Models\Employee;
//use App\Models\LdapAuthenticatable;
//use LdapRecord\Laravel\Auth\LdapAuthenticatable;
use LdapRecord\Laravel\Auth\AuthenticatesWithLdap;


use Laravel\Sanctum\HasApiTokens;

//class User extends Authenticatable implements LdapAuthenticatable
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use CrudTrait;
    use HasRoles;
    use HasFactory, Notifiable;
    use HasRoles;
    // use CrudTrait;


    use CrudTrait; // <----- this
    // use HasRoles; // <-
    protected $username = 'username';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'hr_branch_id',
        'is_online',
        'last_login',
        'is_disabled',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'id' => 'integer',
        'email_verified_at' => 'datetime',
        'hr_branch_id'  => 'integer',
        'is_online' =>'boolean',
        'last_login' => 'datetime',
        'is_disabled' =>'boolean',

    ];
    

    // public function setIsOnlineAttribute($value)
    // {
    //     $this->attributes['is_online'] = $value ? 1 : 0;
    // }
    public function getIsOnlineAttribute()
    {
        $lastLogin = $this->last_login;
        $isOnline = $this->attributes['is_online'];
    
        if ($isOnline == true) {
            return 'Online';
        } else {
            if ($lastLogin && $isOnline == false) {
                return 'Active ' . $lastLogin->diffForHumans();
            } else {
                return '-';
            }
        }
    }



public function isDisabled()
{
    return $this->is_disabled;
}

    public function employee()
    {
 
        return $this->hasOne(Employee::class, 'user_id', 'id');
    }


    public function getNameAttribute()
    {
       // return $this->attributes['name'] . '[' . $this->attributes['username'] . ']';
        return $this->attributes['name'];
    }



    public function hrBranch() {
        return $this->belongsTo(HrBranch::class);
    }
    
    public function applications ():HasMany
    {
       
        return $this->hasMany(Application::class);
    }

    // public function getIsOnlineAttribute($value)
    // {
    //     return $this->attributes['is_online'] = $value === 1 ? 'Online' : 'Offline';
    // }



}
