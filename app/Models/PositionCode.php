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

class PositionCode extends Model
{

    use RevisionableTrait;
    use CrudTrait;
    use HasFactory;
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
    protected $appends = ['employee_id'];

    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_id',
        'position_id',
        'code',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'employee_id' => 'integer',
        'position_id' => 'integer',
    ];


    public function getHrIdFromPositionCode($positionCode)
    {
        $position = PositionCode::find($positionCode)->position;
        $unit = $position->unit;
        $hrId = $unit->hr_id;

      return  $hrId;
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function getFreePositions()
    {
        return PositionCode::where('position_id', $this->attributes['id'])->where('employee_id',null)->count();
    }

}
