<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Venturecraft\Revisionable\RevisionableTrait;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\BelongsToRelationship;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\Traits\HasRoles;

class Unit extends Model
{

    use RevisionableTrait;
    use CrudTrait;
    use HasFactory;
    use CrudTrait;
    use HasRoles;



    public function identifiableName()
    {
        return $this->name;
    }



    use RevisionableTrait;
    protected $revisionEnabled = true; //If needed, you can disable the revisioning by setting $revisionEnabled to false in your Model.
    // protected $revisionCleanup = true; //Remove old revisions (works only when used with $historyLimit)
    // protected $historyLimit = 500;   //Maintain a maximum of 500 changes at any point of time, while cleaning up old revisions.
    // protected $revisionForceDeleteEnabled = false; //If you want to store the Force Delete as a revision you can override this behavior by setting revisionForceDeleteEnabled to true
    protected $appends = ['name'];

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
        'level',
        'subordinate',
        'hr_branch_id',
        'is_active '
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
        'is_active' => 'boolean',
    ];

    public function seal()
    {
        return $this->belongsTo(UploadFile::class);
    }
    public function teter()
    {

        return $this->belongsTo(UploadFile::class);
    }

    public function chairManType()
    {

        return $this->belongsTo(Employee::class);
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


    public function viewOffice($crud = false)
    {

        if (!backpack_user()->can('position.index')) {
            return null;
        }

        $route =  route('position.index', ['unit_id' => $this->attributes['id']]); // custome toute here

        return '<a class="btn btn-sm btn-link"  href="' . $route . '" data-toggle="tooltip" title="View Positions"><i class="la la-flag"></i> Positions </a>';
    }




    public function viewEmployee($crud = false)
    {

        if (!backpack_user()->can('employee.index')) {
            return null;
        }
        $route =  route('employee.index', ['unit_id' => $this->attributes['id']]); // custome toute here

        return '<a class="btn btn-sm btn-link"  href="' . $route . '" data-toggle="tooltip" title="View employee"><i class="la la-users"></i> Employee </a>';
    }

    /**
     * Get all of the positions for the Unit
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function positions()
    {
        return $this->hasMany(Position::class, 'unit_id', 'id');
    }

    public function getPositionedChoice()
    {
        $positionIds = $this->positions()->pluck('id')->toArray();
        return PlacementChoice::whereIn('choice_one_id',$positionIds)->orWhereIn('choice_one_id',$positionIds)->get();
    }

    public function getPositionedResult()
    {
        $positionIds = $this->positions()->pluck('id')->toArray();
        return PlacementChoice::whereIn('new_position',$positionIds)->get();
    }

    public function hrBranch()
    {
       
        return $this->belongsTo(HrBranch::class);
    }


    public function childs()
    {

        return $this->hasMany(Self::class, 'parent_unit_id', 'id');
    }

    public function setIsActiveAttribute($value)
    {
        $this->attributes['is_active'] = $value === 'Yes' ? 1 : 0;
    }
    
    public function getIsActiveAttribute() {
        if (isset($this->attributes['is_active']) && $this->attributes['is_active'] !== 0 && !empty($this->attributes['is_active'])) {
            return 'Yes';
        }
        return 'No';
    
}
}