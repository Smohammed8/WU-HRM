<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'year',
        'month',
        'user_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'created_at' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function payrollSheet($crud = false)
    {
        

        $route =  backpack_url('payroll-sheet'); // custome toute here

        return '<a class="btn btn-sm btn-link"  href="' . $route . '" data-toggle="tooltip" title="Payroll Sheet"><i class="fa fa-list"></i> Payroll Sheet </a>';
    }

}
