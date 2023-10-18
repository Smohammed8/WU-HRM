<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExternalExperience extends Model
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
        'job_title_id',
        'company_name',
        'start_date',
        'end_date',
        'comment',
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
        //'job_title_id' => 'integer',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function canRelateToJobTitlte(JobTitle $jobTitle)
    {

        if($this->jobTitle->jobTitleCategory->id == $jobTitle->jobTitleCategory->id){
            return true;
        }
        return false;
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function employmentType()
    {
        return $this->belongsTo(EmploymentType::class);
    }
    // public function jobTitle()
    // {
    //     return $this->belongsTo(JobTitle::class);
    // }

}
