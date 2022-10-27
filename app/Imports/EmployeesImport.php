<?php

namespace App\Imports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\ToModel;

class EmployeesImport implements ToModel
{
    static $x = 0;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if (EmployeesImport::$x > 0) {
            $staffId = $row[0];
            $firstName = $row[1];
            $fatherName = $row[2];
            $grandFatherName = $row[3];
            $email = $row[5];
            $phone = $row[6];
            $gender = $row[7];
            $employeeInfo = [
                'staff_national_id' => $staffId,
                'email' => $email,
                'first_name' => $firstName,
                'father_name' => $fatherName,
                'grand_father_name' => $grandFatherName,
                'phone_number' => substr($phone, 0, 1)=='9'?'0'.$phone:$phone,
                'gender' => $gender == 'M' ? 'Male' : 'Female',
            ];
            if ($firstName != null && $fatherName != null && $grandFatherName != null) {
                return new Employee(
                    $employeeInfo
                );
            }
        } else {
            EmployeesImport::$x = EmployeesImport::$x + 1;
        }

        return null;
    }
}
