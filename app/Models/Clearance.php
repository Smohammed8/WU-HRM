<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clearance extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_id',
        'check_point_id',
        'isApproved',
        'approved_by',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'employee_id' => 'integer',
        'check_point_id' => 'integer',
        'approved_by' => 'integer',
    ];

    public function getNameAttribute()
    {
        return $this->attributes['employee_id'];
        // $emloyee_id = $this->attributes['employee_id'];
         // then find employee name
         // retunr name;

    }

    
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function checkPoint()
    {
        return $this->belongsTo(CheckPoint::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class);
    }
}
