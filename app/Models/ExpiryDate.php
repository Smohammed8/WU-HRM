<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpiryDate extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'employee_category_id', 'value'
    ];

    public function staffType()
    {
        return $this->belongsTo(EmployeeCategory::class, 'employee_category_id', 'id');
    }
}
