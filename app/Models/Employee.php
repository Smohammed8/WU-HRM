<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'father_name',
        'grand_father_name',
        'gender',
        'date_of_birth',
        'photo',
        'birth_city',
        'passport',
        'driving_licence',
        'blood_group',
        'eye_color',
        'phone_number',
        'alternate_email',
        'rfid',
        'employment_identity',
        'marital_status_id',
        'ethnicity_id',
        'religion_id',
        'unit_id',
        'employement_date',
        'salary_step',
        'job_title_id',
        'employment_type_id',
        'pention_number',
        'employment_status_id',
        'static_salary',
        'uas_user_id',
    ];

    public function setNameAttribute()
    {
        return 'sd';
    }
    public function setPhotoAttribute($value)
    {
        dd('sd1');
        // $attribute_name = "image";
        // $disk = "public";
        // $destination_path = "folder_1/subfolder_1";

        // $this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path);

        // return $this->attributes[{$attribute_name}]; // uncomment if this is a translatable field
    }


    public function setDrivingLicenceAttribute($value)
    {
        $fileName = $value;
        $disk = "public";
        $destination_path = "employee/driving_license_uploads";
        $attribute_name = "image";
        $this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path);
        // dump($content);
        // dump($value);
        // dd('sd2');
        // return $this->attributes[{$attribute_name}]; // uncomment if this is a translatable field
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'date_of_birth' => 'date',
        'photo' => 'integer',
        'driving_licence' => 'integer',
        'marital_status_id' => 'integer',
        'ethnicity_id' => 'integer',
        'religion_id' => 'integer',
        'unit_id' => 'integer',
        'employement_date' => 'date',
        'job_title_id' => 'integer',
        'employment_type_id' => 'integer',
        'employment_status_id' => 'integer',
    ];


    public function photo()
    {
        return $this->belongsTo(UploadFile::class);
    }

    public function drivingLicence()
    {
        return $this->belongsTo(UploadFile::class);
    }

    public function maritalStatus()
    {
        return $this->belongsTo(MaritalStatus::class);
    }

    public function ethnicity()
    {
        return $this->belongsTo(Ethnicity::class);
    }

    public function religion()
    {
        return $this->belongsTo(Religion::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function jobTitle()
    {
        return $this->belongsTo(JobTitle::class);
    }

    public function employmentType()
    {
        return $this->belongsTo(EmploymentType::class);
    }

    public function employmentStatus()
    {
        return $this->belongsTo(EmploymentStatus::class);
    }
    /**
     * Get all of the externalExperiences for the Employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function externalExperiences(): HasMany
    {
        return $this->hasMany(ExternalExperience::class);
    }
}
