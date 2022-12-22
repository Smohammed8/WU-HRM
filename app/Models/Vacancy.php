<?php

namespace App\Models;

use App\Constants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacancy extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'registration_start_date',
        'registration_end_date',
        'position_id',
        'description',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'registration_start_date' => 'date',
        'registration_end_date' => 'date',
        'position_id' => 'integer',
    ];


    public function getRegistrationStartDateAttribute()
    {
        return Constants::gcToEt($this->attributes['registration_start_date']);
    }

    public function setRegistrationStartDateAttribute($registrationStartDate)
    {
        $this->attributes['registration_start_date'] = Constants::etToGc($registrationStartDate);
    }
    public function getRegistrationEndDateAttribute()
    {
        return Constants::gcToEt($this->attributes['registration_end_date']);
    }

    public function setRegistrationEndDateAttribute($registrationEndtDate)
    {
        $this->attributes['registration_end_date'] = Constants::etToGc($registrationEndtDate);
    }


    public function position()
    {
        return $this->belongsTo(Position::class);
    }


    public function candidatesButtonView($crud = false)
    {
        if (!backpack_user()->canany(['vacancy.candidate.icrud', 'vacancy.candidate.index'])) {
            return null;
        }
        $route =  route('vacancy/{vacancy}/candidate.index', ['vacancy' => $this->id]); // custome toute here
        return '<a class="btn btn-sm btn-link"  href="' . $route . '" data-toggle="tooltip" title="Candidates"><i class="la la-users"></i>Candidates </a>';
    }
}
