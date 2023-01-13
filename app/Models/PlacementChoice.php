<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlacementChoice extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'placement_round_id',
        'employee_id',
        'choice_one_id',
        'choice_two_id',
        'choice_one_result',
        'choice_two_result',
        'choice_one_rank',
        'choice_two_rank',
        'new_position'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'placement_round_id' => 'integer',
        'employee_id' => 'integer',
        'choice_one_id' => 'integer',
        'choice_two_id' => 'integer',

    ];

    public function placementRound()
    {
        return $this->belongsTo(PlacementRound::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function choiceOne()
    {
        return $this->belongsTo(Position::class,'choice_one_id');
    }

    public function newPosition()
    {
        return $this->belongsTo(Position::class,'new_position');
    }
    public function choiceTwo()
    {
        return $this->belongsTo(Position::class,'choice_two_id');
    }

}
