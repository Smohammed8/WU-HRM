<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;
class InternalExperience extends Model
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
        'unit_id',
        'job_title_id',
        'position',
        'start_date',
        'end_date',
        'employment_type_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'employee_id' => 'integer',
        'unit_id' => 'integer',
        'job_title_id' => 'integer',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function canRelateToJobTitlte(JobTitle $jobTitle)
    {

        if($this->jobTitle->jobTitleCategory->id == $jobTitle->jobTitleCategory->id){
            return true;
        }
        return false;
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function employmentType()
    {
        return $this->belongsTo(EmploymentType::class);
    }
    
    public function jobTitle()
    {
        return $this->belongsTo(JobTitle::class);
    }
}
