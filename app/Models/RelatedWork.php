<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelatedWork extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'minimum_requirement_id',
        'job_title_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'minimum_requirement_id' => 'integer',
        'job_title_id' => 'integer',
    ];

    public function minimumRequirement()
    {
        return $this->belongsTo(MinimumRequirement::class);
    }

    public function getJobNameAttribute()
    {
        return $this->jobTitle->name;
    }

    public function jobTitle()
    {
        return $this->belongsTo(JobTitle::class);
    }
}
