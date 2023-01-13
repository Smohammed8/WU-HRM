<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeFamily extends Model
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
        'family_relationship_id',
        'first_name',
        'father_name',
        'grand_father_name',
        'gender',
        'dob',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'employee_id' => 'integer',
        'family_relationship_id' => 'integer',
        'dob' => 'date',
    ];

    public function getNameAttribute()
    {
        return $this->attributes['first_name'].''.$this->attributes['father_name'].''.$this->attributes['grand_father_name'];
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function familyRelationship()
    {
        return $this->belongsTo(FamilyRelationship::class);
    }
}
