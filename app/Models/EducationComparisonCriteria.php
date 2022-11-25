<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationComparisonCriteria extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'position_value_id',
        'educational_level_id',
        'min_educational_level_id',
        'value',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'position_value_id' => 'integer',
        'educational_level_id' => 'integer',
        'min_educational_level_id' => 'integer',
        'value' => 'float',
    ];

    public function positionValue()
    {
        return $this->belongsTo(PositionValue::class);
    }

    public function educationalLevel()
    {
        return $this->belongsTo(EducationalLevel::class);
    }

    public function minEducationalLevel()
    {
        return $this->belongsTo(MinEducationalLevel::class);
    }
}
