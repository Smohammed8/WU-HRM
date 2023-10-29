<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Constants;
use Carbon\Carbon;

class Application extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'application_type_id',
        'status',
        'description',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'application_type_id' => 'integer',
        'status' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getCreatedAtAttribute()
    {
        $carbon =  Carbon::parse(Constants::gcToEt($this->attributes['created_at']));
        return $carbon->format('d/m/Y').' E.C';
    }


    public function applicationType()
    {
        return $this->belongsTo(ApplicationType::class);
    }
    public function getStatusAttribute()
    {
        return $this->attributes['status'] ? 'Closed' : 'Pending';
    }
}
