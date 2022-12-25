<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobTitle extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'job_title_category_id',
        'level_id',
        'vacant_post',
        'educational_level_id',
        'field_of_study_id',
        // 'unit_id',
        'job_code',
        'position_type_id',
        'work_experience'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'job_title_category_id' => 'integer',
        'educational_level_id' => 'integer',
        'field_of_study_id' => 'integer',
        'unit_id' => 'integer',
        'level_id' => 'integer'
    ];


    public function fieldOfStudy()
    {
        return $this->belongsToMany(\App\Models\FieldOfStudy::class)
            ->withPivot('job_title_id', 'Field_fo_study_id');
    }

    public function jobTitleCategory()
    {
        return $this->belongsTo(JobTitleCategory::class);
    }


    public function educationalLevel()
    {
        return $this->belongsTo(EducationalLevel::class);
    }

    public function fieldOfStudy_id()
    {
        return $this->belongsTo(FieldOfStudy::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function positionType()
    {
        return $this->belongsTo(PositionType::class);
    }
    public function viewEmployee()
    {

        if (!backpack_user()->can('employee.index')) {
            return null;
        }

        $route =  route('employee.index', ['job_title_id' => $this->attributes['id']]); // custome toute here

        return '<a class="btn btn-sm btn-link"  href="' . $route . '" data-toggle="tooltip" title="View Positions"><i class="la la-flag"></i> Employee </a>';
    }
}
