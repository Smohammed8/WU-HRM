<?php

namespace App\Models;

use App\Constants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class License extends Model
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
        'license_type_id',
        'license_file',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'employee_id' => 'integer',
        'license_type_id' => 'integer',
        'license_file' => 'integer',
    ];

    public function setLicenseFileAttribute($value)
    {
        $disk = "public";
        $destination_path = Constants::EMPLOYEE_LICESNSES_UPLOAD_PATH;
        $attribute_name = "license_file";
        $this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path);
    }


    public function getLicenseFileAttribute($value)
    {
        return asset('storage/'.($this->attributes['license_file']??''));
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function licenseType()
    {
        return $this->belongsTo(LicenseType::class);
    }

    public function uploadFile()
    {
        return $this->belongsTo(UploadFile::class);
    }
}
