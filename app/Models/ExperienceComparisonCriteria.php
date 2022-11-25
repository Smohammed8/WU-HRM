<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExperienceComparisonCriteria extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'position_value_id',
        'title',
        'min_year',
        'max_year',
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
        'value' => 'float',
    ];

    public function positionValue()
    {
        return $this->belongsTo(PositionValue::class);
    }
}
