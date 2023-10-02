<?php

namespace App\Imports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\ToModel;

use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\ToCollection;
use DateTime;
use Illuminate\Support\Collection;
class ImportEmployee implements ToModel
{
    
    static $x = 0;
    // protected $college;
    // public function  __construct($college)
    // {
    //     $this->college = $college;
    // }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

     
    public function model(array $row)
    {
       // dd($row);
        set_time_limit(2000);
        if (ImportEmployee::$x > 0) {
            $firstName       = $row[0];
            $fatherName      = $row[1];
            $gFatherName     = $row[2];
            $fnameAm         = $row[3];
            $mnmeAm          = $row[4];
            $lnameAm         = $row[5];
            $gender          = $row[6];
            $title           = $row[7];
            $religion        = $row[8];
            $education       = $row[9];
            $hireType        = $row[10];
            $hireDate        = $row[11];
            $field           = $row[12];
            $birthPlace      = $row[13];
            $birthDate       = $row[14];
            $maritalStatus   = $row[15];
            $ethinicity      = $row[16];
            $phone           = $row[17];
        // $email            = $row[18];
            $employeeInfo = [
            //    'staff_national_id' => $staffId,
              //  'email' => $email,
                 'first_name' =>$firstName,
                 'father_name' =>$fatherName,
                 'grand_father_name' =>$gFatherName,
                 'first_name_am'  =>$fnameAm,
                 'father_name_am'  =>$mnmeAm,
                 'grand_father_name_am'  =>$lnameAm,
                 'employee_title_id'  =>$title,
                 'gender'             =>$gender == 'M' ? 'Male' : 'Female',
                 'religion_id'        =>$religion,

                 'educational_level_id'  =>$education,
                 'employment_type_id'  =>$hireType ,
                 'employement_date' => date('Y-m-d', strtotime($hireDate)+365 * 8),

                 'field_of_study_id'  =>null,
                 'birth_city'  =>$birthPlace ,
                 'date_of_birth'  =>date('Y-m-d', strtotime($birthDate)+365 * 8),

                 'marital_status_id'  =>$maritalStatus ,
                 'ethnicity_id'  =>$ethinicity ,
                 'employee_category_id'  =>1,

                 'phone_number' => substr($phone, 0, 1)=='9'?'0'.$phone:$phone,
                 'email'  =>null,
                 'nationality' =>1
               // 'college' => $this->college,
            ];       
            if ($firstName != null && $fatherName != null && $gFatherName != null) {
                return new Employee($employeeInfo);
            }
        } 
        else {
            ImportEmployee::$x = ImportEmployee::$x + 1;
        }

        return null;
    }
}

