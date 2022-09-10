<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'acronym',
        'email',
        'telephone',
        'extension_line',
        'location',
        'seal',
        'teter',
        'vision',
        'mission',
        'objective',
        'building_number',
        'office_number',
        'motto',
        'value_list',
        'parent_unit_id',
        'reports_to_id',
        'organization_id',
        'chair_man_type_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'seal' => 'integer',
        'teter' => 'integer',
        'parent_unit_id' => 'integer',
        'reports_to_id' => 'integer',
        'organization_id' => 'integer',
    ];

    public function seal()
    {
        return $this->belongsTo(UploadFile::class);
    }

    public function teter()
    {
        return $this->belongsTo(UploadFile::class);
    }

    public function parentUnit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function reportsTo()
    {
        return $this->belongsTo(Unit::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
