<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PositionValue extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'position_type_id',
        'position_requirement_id',
        'value',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'position_type_id' => 'integer',
        'position_requirement_id' => 'integer',
        'value' => 'float',
    ];

    public function positionType()
    {
        return $this->belongsTo(PositionType::class);
    }

    public function positionRequirement()
    {
        return $this->belongsTo(PositionRequirement::class);
    }
}
