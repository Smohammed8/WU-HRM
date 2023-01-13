<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryScale extends Model
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
        'organization_id',
        'civil_service_year',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'organization_id' => 'integer',
        'civil_service_year' => 'date',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function salarySale($crud = false)
    {

        $route =  backpack_url('job-grade'); // custome toute here

        return '<a class="btn btn-sm btn-link"  href="'.$route.'" data-toggle="tooltip" title="View organization structure"><i class="la la-usd"></i> Salary Scale</a>';
    }
}
