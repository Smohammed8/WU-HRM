<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use App\Employee; // Replace with the actual Employee model namespace

// class EmployeesExport implements FromCollection, WithHeadings, WithStyles
class AdminEmployeesExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize

{
    protected $exportEmployees;

    public function __construct($exportEmployees)
    {
        $this->exportEmployees = $exportEmployees;
    }

    public function collection()
    {
        return $this->exportEmployees;
    }

    public function headings(): array
    {
        return [
            ['Jmma University ID No', 'Full Name', 'Gender', 'Date Of Birth', 'Citizenship', 'Place Of Birth', 'Contact Information',   'Work Experience', 'Family Status', 'Education Level', 'If Specialized or Subspecialized', 'Academic Rank', 'Staff Category', 'Field Of Study', 'Institute College', 'Facultie', 'Department',   'Current Duty Status',   'If Study Leave',   'Empolyeement Status', 'Position',   'Work Load Recent Semester',   'Monthly Income',   'House Service Provision', 'Expected Retirement Year'],
            ['1', 'First Name', 'Middle Name', 'Last Name', 'Country', 'Region', 'Zone', 'Weredea', 'Kebele',   'Email', 'Phone No',     'Disabilities',   'Employment Year', 'Service Year under Other Org', 'Service Year under JU', 'Total Year',   'Marital Status', 'No Children',     'On Duty', 'Reason for Leave', 'Date Of Leave',   'Field Of Study', 'Program Modality', 'Study Country', 'Study INstituation', 'Target Education Level', 'Starting Date', 'Expected End Date', 'Basic Salary', 'House Allowance (If in Cash Amount) or In Kind', 'Position Allowance', 'Duty (for Health)',   ''],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Merge the main headers with their sub-menu headers and apply styling

        // "Jmma University ID No" cell
        $sheet->getStyle('A1')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFF00'], // Yellow
            ],
            'font' => [
                'bold' => true,
            ],
        ]);
        // $sheet->mergeCells('A1:D1'); // Merge cells A1 to D1

        // "Full Name" cell
        $sheet->getStyle('B1')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'ADD8E6'], // Blue
            ],
            'font' => [
                'bold' => true,
            ],
        ]);
        $sheet->mergeCells('B1:D1'); // Merge cells E1 to H1

        // "First Name" cell
        $sheet->getStyle('B2')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'ADD8E6'], // Blue
            ],
            'font' => [
                'bold' => true,
            ],
        ]);

        // "Father Name" cell
        $sheet->getStyle('C2')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'ADD8E6'], // Blue
            ],
            'font' => [
                'bold' => true,
            ],
        ]);

        // "Garndfather  Name" cell
        $sheet->getStyle('D2')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'ADD8E6'], // Blue
            ],
            'font' => [
                'bold' => true,
            ],
        ]);


        // "Gender" cell
        $sheet->getStyle('E1')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFF00'], // Yellow
            ],
            'font' => [
                'bold' => true,
            ],
        ]);
        $sheet->mergeCells('E1:E2'); // Merge cells A1 and A2 vertically (top and bottom)


        // "Date of birth (DD/MM/YYYY) EC." cell
        $sheet->getStyle('F1')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFF00'], // Yellow
            ],
            'font' => [
                'bold' => true,
            ],
        ]);
        $sheet->mergeCells('F1:F2'); // Merge cells A1 and A2 vertically (top and bottom)


        // "Citizineship" cell
        $sheet->getStyle('G1')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFF00'], // Yellow
            ],
            'font' => [
                'bold' => true,
            ],
        ]);
        $sheet->mergeCells('G1:G2'); // Merge cells A1 and A2 vertically (top and bottom)


        // "Place of birth" cell
        $sheet->getStyle('H1')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFFFF'], // Yellow
            ],
            'font' => [
                'bold' => true,
            ],
        ]);

        $sheet->mergeCells('H1:L1'); // Merge cells E1 to H1

        // "Country " cell
        $sheet->getStyle('H2')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFF00'], // Yellow
            ],
            'font' => [
                'bold' => true,
            ],
        ]);

        // "Region " cell
        $sheet->getStyle('I2')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFF00'], // Yellow
            ],
            'font' => [
                'bold' => true,
            ],
        ]);

        // "Zone " cell
        $sheet->getStyle('J2')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFF00'], // Yellow
            ],
            'font' => [
                'bold' => true,
            ],
        ]);

        // "Woreda " cell
        $sheet->getStyle('k2')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFF00'], // Yellow
            ],
            'font' => [
                'bold' => true,
            ],
        ]);

        // "Kebele " cell
        $sheet->getStyle('L2')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFF00'], // Yellow
            ],
            'font' => [
                'bold' => true,
            ],
        ]);


        // "Contact Information " cell
        $sheet->getStyle('M1')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFF00'], // Yellow
            ],
            'font' => [
                'bold' => true,
            ],
        ]);
        $sheet->mergeCells('M1:N1'); // Merge cells E1 to H1

        // "Email  " cell
        $sheet->getStyle('N1')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFF00'], // Yellow
            ],
            'font' => [
                'bold' => true,
            ],
        ]);

        // "Phone Nuber " cell
        $sheet->getStyle('N2')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFF00'], // Yellow
            ],
            'font' => [
                'bold' => true,
            ],
        ]);

        // "Disability " cell
        $sheet->getStyle('O1')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFF00'], // Yellow
            ],
            'font' => [
                'bold' => true,
            ],
        ]);

        $sheet->mergeCells('O1:O2');

        // "Work Experience " cell
        $sheet->getStyle('P1')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFF00'], // Yellow
            ],
            'font' => [
                'bold' => true,
            ],
        ]);

        $sheet->mergeCells('P1:T1'); // Merge cells E1 to H1

        // "Employment year (DD/MM/YYYY) EC. " cell
        $sheet->getStyle('P2')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFF00'], // Yellow
            ],
            'font' => [
                'bold' => true,
            ],
        ]);
        // "Employment year (DD/MM/YYYY) EC. in JU " cell
        $sheet->getStyle('Q2')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFF00'], // Yellow
            ],
            'font' => [
                'bold' => true,
            ],
        ]);
        // " Service year in other organization" cell
        $sheet->getStyle('R2')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFF00'], // Yellow
            ],
            'font' => [
                'bold' => true,
            ],
        ]);
        // " Service Year in JU" cell
        $sheet->getStyle('S2')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFF00'], // Yellow
            ],
            'font' => [
                'bold' => true,
            ],
        ]);
        // "Total Service Year  " cell
        $sheet->getStyle('T2')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFF00'], // Yellow
            ],
            'font' => [
                'bold' => true,
            ],
        ]);


        // "Familly Status " cell
        $sheet->getStyle('U1')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFF00'], // Yellow
            ],
            'font' => [
                'bold' => true,
            ],
        ]);
        $sheet->mergeCells('U1:V1'); // Merge cells E1 to H1

        // "Martial Status " cell
        $sheet->getStyle('U2')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFF00'], // Yellow
            ],
            'font' => [
                'bold' => true,
            ],
        ]);

        // "Number Of children  " cell
        $sheet->getStyle('V2')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFF00'], // Yellow
            ],
            'font' => [
                'bold' => true,
            ],
        ]);

        // "Education Level " cell
        $sheet->getStyle('W1')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFF00'], // Yellow
            ],
            'font' => [
                'bold' => true,
            ],
        ]);
        $sheet->mergeCells('W1:W2');

        // "If Specialist or Sub-Specialist (Specify) " cell
        $sheet->getStyle('X1')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFF00'], // Yellow
            ],
            'font' => [
                'bold' => true,
            ],
        ]);

        // "Academic rank " cell
        $sheet->getStyle('Y1')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFF00'], // Yellow
            ],
            'font' => [
                'bold' => true,
            ],
        ]);
        $sheet->mergeCells('Y1:Y2');

        // "Staff Category" cell
        $sheet->getStyle('Z1')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFF00'], // Yellow
            ],
            'font' => [
                'bold' => true,
            ],
        ]);
        $sheet->mergeCells('Z1:Z2');

        // "Field of Study" cell
        $sheet->getStyle('AA1')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFF00'], // Yellow
            ],
            'font' => [
                'bold' => true,
            ],
        ]);
        $sheet->mergeCells('AA1:AA2');

        // "Institute or Colleges " cell
        $sheet->getStyle('AB1')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFF00'], // Yellow
            ],
            'font' => [
                'bold' => true,
            ],
        ]);
        $sheet->mergeCells('AB1:AB2');

        // "Faculty " cell
        $sheet->getStyle('AC1')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFF00'], // Yellow
            ],
            'font' => [
                'bold' => true,
            ],
        ]);
        $sheet->mergeCells('AC1:AC2');

        // "Department, School or Chair(Specify)" cell
        $sheet->getStyle('AD1')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFF00'], // Yellow
            ],
            'font' => [
                'bold' => true,
            ],
        ]);
        $sheet->mergeCells('AD1:AD2');

        // "Current Duty Status " cell
        $sheet->getStyle('AE1')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFF00'], // Yellow
            ],
            'font' => [
                'bold' => true,
            ],
        ]);
        $sheet->mergeCells('AE1:AG1'); // Merge cells E1 to H1

        // " Call On Duity " cell
        $sheet->getStyle('AE2')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFF00'], // Yellow
            ],
            'font' => [
                'bold' => true,
            ],
        ]);

        // "Reason For Leave " cell
        $sheet->getStyle('AF2')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFF00'], // Yellow
            ],
            'font' => [
                'bold' => true,
            ],
        ]);
        // "Date of Leaving (DD/MM/YYYY) EC. " cell
        $sheet->getStyle('AG2')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFF00'], // Yellow
            ],
            'font' => [
                'bold' => true,
            ],
        ]);


        // " If on Study leave specify: " cell
        $sheet->getStyle('AH1')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFF00'], // Yellow
            ],
            'font' => [
                'bold' => true,
            ],
        ]);
        $sheet->mergeCells('AH1:AN1'); // Merge cells E1 to H1

        // " Feild of study  " cell
        $sheet->getStyle('AH2')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFF00'], // Yellow
            ],
            'font' => [
                'bold' => true,
            ],
        ]);
        // "Program Modularitie" cell
        $sheet->getStyle('AI2')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFF00'], // Yellow
            ],
            'font' => [
                'bold' => true,
            ],
        ]);
        // "Study country(Degree offering) " cell
        $sheet->getStyle('AJ2')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFF00'], // Yellow
            ],
            'font' => [
                'bold' => true,
            ],
        ]);
        // "  Study institution " cell
        $sheet->getStyle('AK2')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFF00'], // Yellow
            ],
            'font' => [
                'bold' => true,
            ],
        ]);

        // "Target education level " cell
        $sheet->getStyle('AL2')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFF00'], // Yellow
            ],
            'font' => [
                'bold' => true,
            ],
        ]);
        // "Starting date (DD/MM/YYYY) EC." cell
        $sheet->getStyle('AM2')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFF00'], // Yellow
            ],
            'font' => [
                'bold' => true,
            ],
        ]);
        // Expected completion year EC.." cell
        $sheet->getStyle('AN2')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFF00'], // Yellow
            ],
            'font' => [
                'bold' => true,
            ],
        ]);

        //  Employment Status.." cell
        $sheet->getStyle('AO1')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFF00'], // Yellow
            ],
            'font' => [
                'bold' => true,
            ],
        ]);
        $sheet->mergeCells('AO1:AO2');

        //   Position(yes/no) if yes please specify" cell
        $sheet->getStyle('AP1')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFF00'], // Yellow
            ],
            'font' => [
                'bold' => true,
            ],
        ]);
        $sheet->mergeCells('AP1:AP2');

        //   Work loads recent semester" cell
        $sheet->getStyle('AQ1')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFF00'], // Yellow
            ],
            'font' => [
                'bold' => true,
            ],
        ]);

        $sheet->mergeCells('AQ1:AU1'); // Merge cells E1 to H1

        //   Teaching load" cell
        $sheet->getStyle('AQ2')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFF00'], // Yellow
            ],
            'font' => [
                'bold' => true,
            ],
        ]);
        //   Research load" cell
        $sheet->getStyle('AR2')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFF00'], // Yellow
            ],
            'font' => [
                'bold' => true,
            ],
        ]);
        //  Advisory load" cell
        $sheet->getStyle('AS2')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFF00'], // Yellow
            ],
            'font' => [
                'bold' => true,
            ],
        ]);
        //  Service load" cell
        $sheet->getStyle('AT2')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFF00'], // Yellow
            ],
            'font' => [
                'bold' => true,
            ],
        ]);
        //   Office load" cell
        $sheet->getStyle('AU2')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFF00'], // Yellow
            ],
            'font' => [
                'bold' => true,
            ],
        ]);


        //    Office load" cell
        $sheet->getStyle('AV1')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFF00'], // Yellow
            ],
            'font' => [
                'bold' => true,
            ],
        ]);
        $sheet->mergeCells('AV1:AY1'); // Merge cells E1 to H1

        //   Basic Salary " cell
        $sheet->getStyle('AV2')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFF00'], // Yellow
            ],
            'font' => [
                'bold' => true,
            ],
        ]);
        //   House allowance (If in cash amount) or In kind" cell
        $sheet->getStyle('AW2')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFF00'], // Yellow
            ],
            'font' => [
                'bold' => true,
            ],
        ]);
        //   Position allowance" cell
        $sheet->getStyle('AX2')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFF00'], // Yellow
            ],
            'font' => [
                'bold' => true,
            ],
        ]);
        //   Duty (for health)" cell
        $sheet->getStyle('AY2')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFF00'], // Yellow
            ],
            'font' => [
                'bold' => true,
            ],
        ]);


        //  House service provision" cell
        $sheet->getStyle('AZ1')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFF00'], // Yellow
            ],
            'font' => [
                'bold' => true,
            ],
        ]);
        $sheet->mergeCells('AZ1:AZ2');

        //   Expected Retirement year (DD/MM/YYYY)  E.C cell
        $sheet->getStyle('BA1')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFF00'], // Yellow
            ],
            'font' => [
                'bold' => true,
            ],
        ]);
        $sheet->mergeCells('BA1:BA2');









        // Continue this pattern for other main headers and their sub-menu headers..

        return [
            1 => [
                'font' => ['bold' => true],
            ],
        ];
    }
}
