<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Constants;
class EmployeeLetter extends Model
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
        'title',
        'body',
        'written_date',
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
        'written_date' => 'date',
        'upload' => 'integer',
    ];



    public function setUploadAttribute($value)
    {
        $disk = "public";
        $destination_path = Constants::EMPLOYEE_LETTER_UPLOAD_PATH;
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
}
