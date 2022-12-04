<?php

namespace App\Models;

use Database\Factories\FieldOfStudyFactory;
use Database\Factories\JobTitleCategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelatedWork extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    'field_of_studie_id',
        'job_title_categorie_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'job_title_categorie_id' => 'integer',
        'field_of_studie_id' => 'integer',
    ];

    public function jobTitleCategory()
    {
        return $this->belongsTo(JobTitleCategory::class);
    }

    public function fieldOfStudy()
    {
        return $this->belongsTo(FieldOfStudy::class);
    }
}
