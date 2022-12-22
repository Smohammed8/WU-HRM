<?php

namespace App\Models;

use App\Constants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'vacancy_id',
        'employee_id',
        'first_name',
        'father_name',
        'grand_father_name',
        'dob',
        'field_of_study_id',
        'educational_level_id',
        'gpa',
        'gender',
        'disablity_status',
        'email',
        'phone',
        'year_of_graduation',
        'nationality_id',
        'total_experience',
        'job_position_experience',
        'mark',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'vacancy_id' => 'integer',
        'employee_id' => 'integer',
        'dob' => 'date',
        'field_of_study_id' => 'integer',
        'educational_level_id' => 'integer',
        'gpa' => 'float',
        'nationality_id' => 'integer',
        'mark' => 'float',
    ];



    public function getDobAttribute()
    {
        return Constants::gcToEt($this->attributes['dob']);
    }


    public function setDobAttribute($dob)
    {
        $this->attributes['dob'] = Constants::etToGc($dob);
    }
    public function vacancy()
    {
        return $this->belongsTo(Vacancy::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function fieldOfStudy()
    {
        return $this->belongsTo(FieldOfStudy::class);
    }

    public function educationalLevel()
    {
        return $this->belongsTo(EducationalLevel::class);
    }

    public function nationality()
    {
        return $this->belongsTo(Nationality::class);
    }

    public function addMark($crud = false)
    {
        $candidate = $this;
        return view('crud::buttons.add_mark',compact('candidate'));
    }
}
