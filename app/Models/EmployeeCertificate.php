<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeCertificate extends Model
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
        'address',
        'certificate_date',
        'duration',
        'comment',
        'certification_type_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'employee_id' => 'integer',
        'certificate_date' => 'date',
        'certification_type_id' =>'integer'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    public function certificationType()
    {
        return $this->belongsTo(CertificationType::class);
    }


}
