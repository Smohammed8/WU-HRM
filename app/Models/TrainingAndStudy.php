<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingAndStudy extends Model
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
        'name',
        'nationality_id',
        'educational_level_id',
        'inistitution',
        'city',
        'is_contract',
        'date_of_leave',
        'end_of_study',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'employee_id' => 'integer',
        'nationality_id' => 'integer',
        'educational_level_id' => 'integer',
        'is_contract' => 'boolean',
        'date_of_leave' => 'date',
        'end_of_study' => 'date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function nationality()
    {
        return $this->belongsTo(Nationality::class);
    }

    public function educationalLevel()
    {
        return $this->belongsTo(EducationalLevel::class);
    }
}
