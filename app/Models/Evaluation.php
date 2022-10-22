<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
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
        'quarter_id',
        'total_mark',
        'created_by_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'employee_id' => 'integer',
        'quarter_id' => 'integer',
        'created_by_id' => 'integer',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }


    public function employeeEvaluations()
    {
        return $this->hasMany(EmployeeEvaluation::class);
    }

    public function quarter()
    {
        return $this->belongsTo(Quarter::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class);
    }
}
