<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jobTitlePrerequest extends Model
{
    use HasFactory;

      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        
        'job_title_id',
        'job_prerequest_id',
    ];
        /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'job_title_id' => 'integer',
        'job_prerequest_id' => 'integer',
    ];



    public function jobTitle()
    {
        return $this->belongsTo(JobTitle::class);
    }
    public function jobTitlePrereuest()
    {
        return $this->belongsTo(JobTitle::class);
    }
    
    // public function prerequest()
    // {
    //     return $this->belongsTo(JobTitle::class);
    // }

    
}