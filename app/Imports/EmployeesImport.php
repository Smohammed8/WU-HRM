<?php

namespace App\Imports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\ToCollection;
use DateTime;
use Illuminate\Support\Collection;

class EmployeesImport implements ToModel
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
       
        set_time_limit(2000);
        if (EmployeesImport::$x > 0) {
            $firstName       = $row[0];
            $fatherName      = $row[1];
            $gFatherName     = $row[2];
            $fnameAm         = $row[3];
            $mnmeAm          = $row[4];
            $lnameAm         = $row[5];
            $gender          = $row[6];
            $hr              = $row[7];
            // $title           = $row[7];
            // $religion        = $row[8];

            // $education       = $row[9];
            // $hireType        = $row[10];
            // $hireDate        = $row[11];

            // $field           = $row[12];
            // $birthPlace      = $row[13];
            // $birthDate       = $row[14];

            // $maritalStatus   = $row[15];
            // $ethinicity      = $row[16];
          
          
                 $employeeInfo = [
                 'first_name' =>$firstName,
                 'father_name' =>$fatherName,
                 'grand_father_name' =>$gFatherName,
                 'first_name_am'  =>$fnameAm,
                 'father_name_am'  =>$mnmeAm,
                 'grand_father_name_am'  =>$lnameAm,
                // 'employee_title_id'  =>$title,
                 'gender'             =>$gender == 'Male' ? 'Male' : 'Female',
                 'hr_branch_id'  =>$hr,
                //  'religion_id'        =>$religion,
                //  'educational_level_id'  =>$education,
                //  'employment_type_id'  =>$hireType ,
                //  'employement_date' => date('Y-m-d', strtotime($hireDate)+365 * 8),

                //  'field_of_study_id'  =>$field,
                //  'birth_city'  =>$birthPlace ,
                //  'date_of_birth'  =>date('Y-m-d', strtotime($birthDate)+365 * 8),

                //  'marital_status_id'  =>$maritalStatus ,
                //  'ethnicity_id'  =>$ethinicity ,
                //  'employee_category_id'  =>1,
                //  'phone_number' =>null,
               
                 //'nationality' =>1
               // 'college' => $this->college,
            ]; 
           // dd($employeeInfo['employee_title_id']);
            if ($firstName != null && $fatherName != null && $gFatherName != null) {
                return new Employee($employeeInfo);
            }
        } 
        else {
            EmployeesImport::$x = EmployeesImport::$x + 1;
        }

        return null;
    }
}


