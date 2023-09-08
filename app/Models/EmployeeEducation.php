<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PHPUnit\TextUI\XmlConfiguration\Constant;
use App\Constants;

class EmployeeEducation extends Model
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
        'institution',
        'field_of_study_id',
        'educational_level_id',
        'training_start_date',
        'training_end_date',
        'upload',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'employee_id' => 'integer',
        'field_of_study_id' => 'integer',
        'educational_level_id' => 'integer',
        'training_start_date' => 'date',
        'training_end_date' => 'date',
        'upload' => 'integer',
    ];




    public function setUploadAttribute($value)
    {
        $disk = "public";
        $destination_path = Constants::EMPLOYEE_EDUCATIOM_UPLOAD_PATH;
        $attribute_name = "upload";
        $this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path);
    }


    public function getUploadAttribute($value)
    {
        return asset('storage/'.($this->attributes['upload']??''));
    }

    
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function fieldOfStudy()
    {
        return $this->belongsTo(FieldOfStudy::class);
    }

    public function educationalLevel()
    {
        return $this->belongsTo(EducationalLevel::class);
    }
}
