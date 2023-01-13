<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class MinimumRequirement extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'position_id',
        'experience',
        'educational_level_id',
        'minimum_efficeny',
        'minimum_employee_profile_value',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'position_id' => 'integer',
        'educational_level_id' => 'integer',
        'minimum_efficeny' => 'float',
    ];

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function getPositionJobTitleName()
    {
        return $this->position->jobTitle->name;
    }

    public function getPositionUnitName()
    {
        return $this->position->unit->name;
    }

    public function educationalLevel()
    {
        return $this->belongsTo(EducationalLevel::class);
    }
    /**
     * Get all of the relatedJobs for the MinimumRequirement
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function relatedJobs(): HasMany
    {
        return $this->hasMany(RelatedWork::class,'minimum_requirement_id', 'id');
    }
     /**
     * Get all of the relatedJobs for the MinimumRequirement
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function relatedJobTitles(): HasManyThrough
    {
        return $this->hasManyThrough(JobTitle::class, RelatedWork::class);
    }
}
