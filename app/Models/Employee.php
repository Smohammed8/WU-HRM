<?php

namespace App\Models;

use Exception;
use App\Constants;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Zone;
use App\Models\Kebele;
use App\Models\Region;
use App\Models\Woreda;
use App\Models\HrBranch;
use Illuminate\Support\Str;
use function PHPSTORM_META\map;
use App\Models\ExternalExperience;
use App\Models\InternalExperience;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\PositionRequest;
use Spatie\Permission\Traits\HasRoles;
////////////// for permission /////////////
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use \Venturecraft\Revisionable\RevisionableTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\BelongsToRelationship;

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
        'employee_category_id',
        'employee_sub_category_id',
        'file_number',
        'region_id',
        'zone_id',
        'woreda_id',
        'kebele_id'

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
        'employee_category_id'=>'integer'
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


    public function employeeSubCategory()
    {
        return $this->belongsTo(EmployeeSubCategory::class, 'employee_sub_category_id');
    }
///$employees = Employee::with('employeeSubCategory')->get();
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
        return   $this->attributes['employement_date'] = Constants::etToGc($employementDate);
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

       // Add a method to calculate total experience for each internal experience
   public function totalInternalExperiences()
   {
       $totalExperiences = [];

       // Sort internal experiences by start date
       $sortedExperiences = $this->internalExperiences->sortBy('start_date');

       foreach ($sortedExperiences as $key => $internalExperience) {
           $startDate = $internalExperience->start_date;
           $endDate = $internalExperience->end_date ?? Constants::gcToEt(now()); // Use current date if end_date is null
           if ($key > 0) {
               $previousExperience = $sortedExperiences[$key - 1];

               if ($startDate < $previousExperience->end_date) {
                   $startDate = $previousExperience->end_date;
               }
           }
           $years = $startDate->diff($endDate)->y;
           $months = $startDate->diff($endDate)->m;
           $days = $startDate->diff($endDate)->d;

           // Adjust for cases where months > 12
           $years += intdiv($months, 12);
           $months = $months % 12;

           // Adjust for cases where days > 29
           if ($days > 29) {
               $months += intdiv($days, 30);
               $days = $days % 30;
           }

           $totalExperiences[] = $years . ' years ' . $months . ' months ' . $days . ' days';
       }

       return $totalExperiences;
   }

   // Add a method to calculate the total sum of durations
   public function calculateTotalSum()
   {
       $totalSum = [
           'years' => 0,
           'months' => 0,
           'days' => 0,
       ];

       foreach ($this->totalInternalExperiences() as $experience) {
           preg_match('/(\d+) years (\d+) months (\d+) days/', $experience, $matches);

           $totalSum['years'] += (int)$matches[1];
           $totalSum['months'] += (int)$matches[2];
           $totalSum['days'] += (int)$matches[3];
       }

       return $totalSum;
   }
  ///////////////////////////////////////////////////////////////////////////////////////////////////

       // Add a method to calculate total experience for each internal experience
       public function totalExeternalExperiences()
       {
           $totalExperiences = [];
    
           // Sort internal experiences by start date
           $sortedExperiences = $this->externalExperiences->sortBy('start_date');
    
           foreach ($sortedExperiences as $key => $externalExperiences) {
               $startDate = $externalExperiences->start_date;
               $endDate   = $externalExperiences->end_date ?? Constants::gcToEt(now()); // Use current date if end_date is null
               if ($key > 0) {
                   $previousExperience = $sortedExperiences[$key - 1];
    
                   if ($startDate < $previousExperience->end_date) {
                       $startDate = $previousExperience->end_date;
                   }
               }
               $years = $startDate->diff($endDate)->y;
               $months = $startDate->diff($endDate)->m;
               $days = $startDate->diff($endDate)->d;
    
               // Adjust for cases where months > 12
               $years += intdiv($months, 12);
               $months = $months % 12;
    
               // Adjust for cases where days > 29
               if ($days > 29) {
                   $months += intdiv($days, 30);
                   $days = $days % 30;
               }
    
               $totalExperiences[] = $years . ' years ' . $months . ' months ' . $days . ' days';
           }
    
           return $totalExperiences;
       }
    
       // Add a method to calculate the total sum of durations
       public function calculateExTotalSum()
       {
           $totalSum = [
               'years' => 0,
               'months' => 0,
               'days' => 0,
           ];
    
           foreach ($this->totalExeternalExperiences() as $experience) {
               preg_match('/(\d+) years (\d+) months (\d+) days/', $experience, $matches);
    
               $totalSum['years'] += (int)$matches[1];
               $totalSum['months'] += (int)$matches[2];
               $totalSum['days'] += (int)$matches[3];
           }
    
           return $totalSum;
       }



public function totalExperiences()
{
    $totalSumInternal = $this->calculateTotalSum();
    $totalSumExternal = $this->calculateExTotalSum();
    // Merge the arrays to combine internal and external experience durations
    $totalSum = [
        'years' => $totalSumInternal['years'] + $totalSumExternal['years'],
        'months' => $totalSumInternal['months'] + $totalSumExternal['months'],
        'days' => $totalSumInternal['days'] + $totalSumExternal['days'],
    ];
    // Adjust for cases where months > 12
    $totalSum['years'] += intdiv($totalSum['months'], 12);
    $totalSum['months'] = $totalSum['months'] % 12;

    // Adjust for cases where days > 29
    if ($totalSum['days'] > 29) {
        $totalSum['months'] += intdiv($totalSum['days'], 30);
        $totalSum['days'] = $totalSum['days'] % 30;
    }
    return $totalSum;
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
    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class,'region_id','id');
    }

    public function zone(): BelongsTo
    {
        return $this->belongsTo(Zone::class,'zone_id','id');
    }
    public function woreda(): BelongsTo
    {
        return $this->belongsTo(Woreda::class,'woreda_id','id');
    }
    public function kebele(): BelongsTo
    {
        return $this->belongsTo(Kebele::class,'kebele_id','id');
    }



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

    public function employeeEducations(): HasMany
    {
        return $this->hasMany(EmployeeEducation::class, 'employee_id', 'id');
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
