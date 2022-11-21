<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FieldOfStudy extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'educational_level_id',
        'name',
        'description',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'educational_level_id' => 'integer'
    ];

public function jobTitle()
{
    return $this->belongsToMany(\App\Models\JobTitle::class)
                ->withPivot('job_title_id', 'Field_fo_study_id');
}


    public function educationalLevel()
    {
        return $this->belongsTo(EducationalLevel::class);
    }
}
