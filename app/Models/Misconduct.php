<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use CrudTrait;
class Misconduct extends Model
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
        'type_of_misconduct_id',
        'created_by_id',
        'attachement',
        'action_taken',
        'serverity',
        'description',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'employee_id' => 'integer',
        'type_of_misconduct_id' => 'integer',
        'created_by_id' => 'integer',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function typeOfMisconduct()
    {
        return $this->belongsTo(TypeOfMisconduct::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class);
    }
}
