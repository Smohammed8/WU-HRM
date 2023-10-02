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
        'isApproved',
        'approval_id',
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
        'approval_id' => 'integer',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }


    public function employeeEvaluations()
    {
        return $this->hasMany(EmployeeEvaluation::class);
    }

    public function getEffiency($employe_id)
    {
        $efficnecies = Evaluation::select('total_mark')->where('employee_id', $employe_id)->where('quarter_id', 1)->pluck('total_mark')->toArray();
        $sum = array_sum($efficnecies);
        if ($sum  == null) {
            $result = 0;
        } else {
            $result = $sum;
        }
        return $result;
    }


    public function quarter()
    {
        return $this->belongsTo(Quarter::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class);
    }

    public function approval()
    {
        return $this->belongsTo(User::class);
    }
}
