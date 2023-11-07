<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeSubCategory extends Model
{
  
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'employee_category_id',
        'description',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'employee_category_id' => 'integer',
    ];

    public function employeeCategory()
    {
        return $this->belongsTo(EmployeeCategory::class);
    }
    public function employees()
    {
        return $this->belongsTo(Employee::class);
    }
}
