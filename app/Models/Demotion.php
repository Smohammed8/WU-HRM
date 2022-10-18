<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demotion extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_id',
        'old_unit_id',
        'new_unit_id',
        'old_job_title_id',
        'new_job_title_id',
        'created_by_id',
        'reason_of_demotion',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'employee_id' => 'integer',
        'old_unit_id' => 'integer',
        'new_unit_id' => 'integer',
        'old_job_title_id' => 'integer',
        'new_job_title_id' => 'integer',
        'created_by_id' => 'integer',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function oldUnit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function newUnit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function oldJobTitle()
    {
        return $this->belongsTo(OldJobTitle::class);
    }

    public function newJobTitle()
    {
        return $this->belongsTo(NewJobTitle::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class);
    }
}
