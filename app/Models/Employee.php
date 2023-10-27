<?php

namespace App\Models;

use App\Constants;
use App\Http\Requests\PositionRequest;
use App\Models\HrBranch;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Exception;
use Carbon\Carbon;
use App\Models\InternalExperience;
use App\Models\ExternalExperience;
use Illuminate\Support\Facades\DB;
////////////// for permission /////////////
use \Venturecraft\Revisionable\RevisionableTrait;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\BelongsToRelationship;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Permission\Traits\HasRoles;
use function PHPSTORM_META\map;

class Employee extends  Model
{

    // use  \Venturecraft\Revisionable\RevisionableTrait;
    // use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;
    use CrudTrait;
    use HasRoles;
    use RevisionableTrait;

    // use RevisionableTrait, CrudTrait, HasFactory, HasRoles;

  

    public function identifiableName()
    {
        return $this->name;
    }
    protected $revisionEnabled = true; 
    protected $appends = ['name'];
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
        'email',
        'employmeent_identity',
        'marital_status_id',
        'ethnicity_id',
        'religion_id',
        'employement_date',
        'salary_step',
        'position_id',
        'employment_type_id',
        'pention_number',
        'employment_status_id',
        'static_salary',
        'uas_user_id',
        'staff_national_id',
        'educational_level_id',
        'field_of_study_id',
        'employee_category_id',
        'grand_father_name_am',
        'father_name_am',
        'first_name_am',
        'employee_title_id',
        'hr_branch_id',
        'horizontal_level',
        'national_id',
        'cbe_account',
        'user_id',

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
        if ($value == null) {
            // delete the image from disk
            Storage::disk($disk)->delete($this->{$attribute_name});
            // set null in the database column
            $this->attributes[$attribute_name] = null;
        }

        // if a base64 was sent, store it in the db
        if (Str::startsWith($value, 'data:image')) {
            // 0. Make the image
            $image = Image::make($value)->encode('jpg', 90);

            // 1. Generate a filename.
            $filename = md5($value . time()) . '.jpg';

            // 2. Store the image on disk.
            Storage::disk($disk)->put($destination_path . '/' . $filename, $image->stream());

            // 3. Delete the previous image, if there was one.
            Storage::disk($disk)->delete($this->{$attribute_name});

            // 4. Save the public path to the database
            // but first, remove "public/" from the path, since we're pointing to it
            // from the root folder; that way, what gets saved in the db
            // is the public URL (everything that comes after the domain name)
            $public_destination_path = Str::replaceFirst('public/', '', $destination_path);
            $this->attributes[$attribute_name] = 'storage/' . $public_destination_path . '/' . $filename;
        }
    }
    public static function boot()
    {
        parent::boot();
        static::deleting(function ($obj) {
            Storage::disk('public_folder')->delete($obj->image);
        });
    }

    public function isLocked()
    {
        return $this->is_locked;
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
        'employement_date' => 'date',
        'job_title_id' => 'integer',
        'employment_type_id' => 'integer',
        'employment_status_id' => 'integer',
        'employee_title_id' =>'integer',
        'educational_level_id' =>'integer',
        'user_id'=>'integer',
    ];

    public function getDateOfBirthAttribute()
    {
        return Constants::gcToEt($this->attributes['date_of_birth']);
    }

    public function setDateOfBirthAttribute($dateOfBirth)
    {
        $this->attributes['date_of_birth'] = Constants::etToGc($dateOfBirth);
    }

    public function getNameAttribute()
    {
        return $this->attributes['first_name'] . ' ' . $this->attributes['father_name'] . ' ' . $this->attributes['grand_father_name'];
    }

    public function getPhotoAttribute()
    {
        if (array_key_exists('photo', $this->attributes))
            return asset($this->attributes['photo'] ?? 'image/profile.jpg');
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


    public function employeeTitle()
    {
        return $this->belongsTo(EmployeeTitle::class);
    }

    // public function employeeTitle(): BelongsTo
    // {
    //     return $this->belongsTo(EmployeeTitle::class,'employee_title_id','id');
    // }


    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function ethnicity()
    {
        return $this->belongsTo(Ethnicity::class);
    }

    public function religion()
    {
        return $this->belongsTo(Religion::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function jobTitle()
    {
        return $this->belongsTo(JobTitle::class);
    }

    public function employmentStatus()
    {
        return $this->belongsTo(EmploymentStatus::class);
        
    }



    public function nationality()
    {
        return $this->belongsTo(Nationality::class);
    }


    public function positionCode()
    {
        return $this->hasOne(PositionCode::class,'employee_id','id');
    }


    public function age()
    {
        return Carbon::parse($this->attributes['date_of_birth'])->age;
        
    }
    public function employeeCategory()
    {
        return $this->belongsTo(EmployeeCategory::class);
    }

    public function employmentType()
    {
        return $this->belongsTo(EmploymentType::class);
    }

    public function fieldOfStudy()
    {
        return $this->belongsTo(FieldOfStudy::class);
    }
    public function hrBranch()
    {
        return $this->belongsTo(HrBranch::class);
    }


    public function employmentCategory()
    {
        return $this->belongsTo(EmployeeCategory::class, 'employee_category_id');
    }

    public function getEmployementDateAttribute()
    {
        if(!array_key_exists('employement_date',$this->attributes))
            return null;
        $employementDate =$this->attributes['employement_date'];
        if($employementDate!=null){
            return Carbon::createFromDate(Constants::gcToEt($employementDate));
        }
        return Carbon::createFromDate(Constants::gcToEt($employementDate));
    }

    public function setEmployementDateAttribute($employementDate)
    {
        $this->attributes['employement_date'] = Constants::etToGc($employementDate);
    }

    public function getTotalInternalExperience()
    {
        $employementDate =$this->attributes['employement_date'];
        return Carbon::parse($employementDate)->diff(\Carbon\Carbon::now());
    }
    public function getEmployementDateRange()
    {
        $employementDate =$this->attributes['employement_date'];
        return Carbon::parse($employementDate)->diff(\Carbon\Carbon::now())->format('%y years, %m months and %d days') ?? '-';
    }




    /**
     * Get all of the externalExperiences for the Employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    protected function firstName(): Attribute
    {
        return new Attribute(
            set: fn ($value) => strtoupper($value),
        );
    }

    protected function fatherName(): Attribute
    {
        return new Attribute(
            set: fn ($value) => strtoupper($value),
        );
    }




    protected function grandFatherName(): Attribute
    {
        return new Attribute(
            set: fn ($value) => strtoupper($value),
        );
    }


    // public function getUpperText() {
    //     return strtoupper($this->field);
    //    // return ucfirst(strtolower($this->field));
    // }

    /**
     * Get all of the externalExperiences for the Employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function internalExperiences(): HasMany
    {
        return $this->hasMany(InternalExperience::class, 'employee_id', 'id');
    }

    public function externalExperiences(): HasMany
    {
     
        return $this->hasMany(ExternalExperience::class, 'employee_id', 'id');
    }


    public function totalExperiences()
    {
        $internalExperiences = $this->externalExperiences;
        $extrnalExperiences = $this->internalExperiences;
        $total = 0;
        foreach ($internalExperiences as $internalExperience) {
            $dump = $internalExperience->end_date->diff($internalExperience->start_date);
            // dump($dump);
        }

        foreach ($extrnalExperiences as $extrnalExperience) {
            // dump($extrnalExperience);
        }
        // dd("Total experience is $total");
        // dd('sd');
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

    public function getEmployeeAddressesListAttribute()
    {
        return json_encode($this->addresses);
    }
    /**
     * Get all of the licenses  for the Employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function licenses(): HasMany
    {
        return $this->hasMany(License::class);
    }

    public function getLicensesListAttribute()
    {
        return json_encode($this->licenses);
    }

    public function printID($crud = false)
    {

        $route =  backpack_url('job-grade'); // custome toute here

        return '<a class="btn btn-sm btn-link"  href="' . $route . '" data-toggle="tooltip" title="Print ID"><i class="la la-book"></i>Digital ID </a>';
    }

    /**
     * Get the educationLevel that owns the Employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function educationLevel(): BelongsTo
    {
        return $this->belongsTo(EducationalLevel::class,'educational_level_id','id');
    }

    /**
     * Get all of the licenses  for the Employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function choices(): HasMany
    {
        return $this->hasMany(PlacementChoice::class);
    }

    public function letters(): HasMany
    {
        return $this->hasMany(EmployeeLetter::class);
    }
    public function educations(): HasMany
    {
        return $this->hasMany(EmployeeEducation::class);
    }
    public function certifications():HasMany
    {
        return $this->hasMany(EmployeeCertificate::class);
    }
    public function account() : HasOne {
        
            return $this->hasOne(User::class);
            
    }
    

  //////////////////////////////////////////////////////
    public function getAgeAttribute()
    {
        return now()->diffInYears($this->date_of_birth);
    }
   /////////////////////////////////////////////////////
    /**
     * Get all of the evaluations for the Employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function evaluations(): HasMany
    {
        return $this->hasMany(Evaluation::class, 'employee_id', 'id');
    }


    public function families(): HasMany
    {
        return $this->hasMany(EmployeeFamily::class, 'employee_id', 'id');
    }

    public function getSalary($employeeId){
     $level  =    Employee::where('id', $employeeId)?->position?->jobTitle?->level_id;
     $startSalary  =    JobGrade::where('level_id', $level)->first()?->start_salary;
     $level_id  =    JobGrade::where('level_id', $level)->first()?->id;
     $step  =    Employee::where('id', $employeeId)->first()?->horizontal_level;
      //horizontal_level 
      if($step =='Start')
      return  JobGrade::getValueByIdAndColumn($level_id, 'start_salary');
      elseif($step ==1) 
      return JobGrade::getValueByIdAndColumn($level_id , 'one');
      elseif($step ==2)
      return JobGrade::getValueByIdAndColumn($level_id , 'two');
      elseif($step ==3)
      return JobGrade::getValueByIdAndColumn($level_id , 'three');
      elseif($step ==4)
      return  JobGrade::getValueByIdAndColumn($level_id , 'four');
      elseif($step ==5)
      return  JobGrade::getValueByIdAndColumn($level_id , 'five');
      elseif($step ==6)
      return  JobGrade::getValueByIdAndColumn($level_id , 'six');
      elseif($step ==7)
      return JobGrade::getValueByIdAndColumn($level_id , 'seven');
      elseif($step ==8)
      return  JobGrade::getValueByIdAndColumn($level_id , 'eight');
      elseif($step ==9)
      return  JobGrade::getValueByIdAndColumn($level_id , 'nine'); 
      elseif($step ==null)
      return  JobGrade::getValueByIdAndColumn($level_id , 'start_salary'); 
      else
          return JobGrade::getValueByIdAndColumn($level_id, 'ceil_salary');

    }
}
