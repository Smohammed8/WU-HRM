<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Constants;
class Quarter extends Model
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
        'start_date',
        'end_date',
        'description',
    ];



    public function setStartDateAttribute($startDate)
    {
        return $this->attributes['start_date'] = Constants::etToGc($startDate);
    }
    
    public function setEndDateAttribute($endDate)
    {
        return  $this->attributes['end_date'] = Constants::etToGc($endDate);
    }

    // public function getStartDateAttribute($startDate)
    // {
    //     return  $this->attributes['start_date'] = Constants::gcToEt($startDate);
    // }

    // public function getEndDateAttribute($endDate)
    // {
    //     return $this->attributes['end_date'] = Constants::gcToEt($endDate);
    // }



    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'start_date' => 'date',
        'end_date' => 'date',
    ];
}
