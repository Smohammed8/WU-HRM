<?php

namespace App\Models;

use App\Constants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;
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



    public function setPhotoAttribute($value)
    {
        $attribute_name = "photo";
        // or use your own disk, defined in config/filesystems.php
        $disk = config('backpack.base.root_disk_name');
        $disk = 'public';
        // destination path relative to the disk above
        $destination_path = Constants::EMPLOYEE_PHOTO_UPLOAD_PATH;

        // if the image was erased
        if ($value==null) {
            // delete the image from disk
            Storage::disk($disk)->delete($this->{$attribute_name});
            // set null in the database column
            $this->attributes[$attribute_name] = null;
        }

        // if a base64 was sent, store it in the db
        if (Str::startsWith($value, 'data:image'))
        {
            // 0. Make the image
            $image = Image::make($value)->encode('jpg', 90);

            // 1. Generate a filename.
            $filename = md5($value.time()).'.jpg';

            // 2. Store the image on disk.
            Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());

            // 3. Delete the previous image, if there was one.
            Storage::disk($disk)->delete($this->{$attribute_name});

            // 4. Save the public path to the database
            // but first, remove "public/" from the path, since we're pointing to it
            // from the root folder; that way, what gets saved in the db
            // is the public URL (everything that comes after the domain name)
            $public_destination_path = Str::replaceFirst('public/', '', $destination_path);
            $this->attributes[$attribute_name] = 'storage/'. $public_destination_path.'/'.$filename;
        }
    }
    public static function boot()
    {
        parent::boot();
        static::deleting(function($obj) {
            Storage::disk('public_folder')->delete($obj->image);
        });
    }
    public function setDrivingLicenceAttribute($value)
    {
        $disk = "public";
        $destination_path = Constants::EMPLOYEE_DRIVER_LICESNCE_UPLOAD_PATH;
        $attribute_name = "driving_licence";
        $this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path);
    }

    // public function getDrivingLicenceAttribute()
    // {
    //     if(array_key_exists('driving_licence',$this->attributes))
    //         return ($this->attributes['driving_licence']);
    //     return null;
    // }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'date_of_birth' => 'date',
        'photo' => 'string',
        'driving_licence' => 'string',
        'marital_status_id' => 'integer',
        'ethnicity_id' => 'integer',
        'religion_id' => 'integer',
        'unit_id' => 'integer',
        'employement_date' => 'date',
        'job_title_id' => 'integer',
        'employment_type_id' => 'integer',
        'employment_status_id' => 'integer',
    ];

    public function getNameAttribute()
    {
        return $this->attributes['first_name'].' '.$this->attributes['father_name'].' '.$this->attributes['grand_father_name'];
    }

    public function getPhotoAttribute()
    {
        if(array_key_exists('photo',$this->attributes))
            return asset($this->attributes['photo']);
        return null;
    }

    // public function photo()
    // {
    //     // return $this->belongsTo(UploadFile::class);
    // }

    // public function drivingLicence()
    // {
    //     return $this->belongsTo(UploadFile::class);
    // }

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

    /**
     * Get all of the addresses for the Employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function employeeAddresses(): HasMany
    {
        return $this->hasMany(EmployeeAddress::class);
    }

     public function getEmployeeAddressesListAttribute() {
        return json_encode($this->addresses);
    }
    /**
     * Get all of the licenses  for the Employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function licenses (): HasMany
    {
        return $this->hasMany(License::class);
    }

    public function getLicensesListAttribute() {
        return json_encode($this->licenses);
    }
}
