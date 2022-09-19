<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeEvaluation extends Model
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
        'evalution_creteria_id',
        'evaluation_level_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'employee_id' => 'integer',
        'evalution_creteria_id' => 'integer',
        'evaluation_level_id' => 'integer',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function evalutionCreteria()
    {
        return $this->belongsTo(EvalutionCreteria::class);
    }

    public function evaluationLevel()
    {
        return $this->belongsTo(EvaluationLevel::class);
    }
}
