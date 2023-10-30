<?php

use App\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class EmployeeExport implements FromCollection, WithHeadings
{
    protected $employees;

    public function __construct(Collection $employees)
    {
        $this->employees = $employees;
    }

    public function collection()
    {
        return $this->employees;
    }

    public function headings(): array
    {
        return [
            'ID',
            'FirstName',
            'FatherName',
            'LastName',
            'gender',	
            'date_of_birth',
            'birth_city', 
            'driving_licence',
            'blood_group', 
            'eye_color',	
            'Phone', 
            'Email',
            'Office',
        	'employment_identity',
            'employee_title',
            'educational_level',
            'marital_status',
            'ethnicity',
             'religion_id',
            'field of study',
            'employement_date',
            'position',
            'employment_type',
            'pention_number',
            'hr_branch_id',
            'employment_status',
            'nationality',
            'Employee Category',

        ];
    }
}