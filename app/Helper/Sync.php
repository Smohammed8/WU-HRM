<?php

namespace App\Helper;

use Illuminate\Support\Facades\DB;

class SRS
{
    public function getEmployeeProfileDetail($employee_id)
    {
        $result = DB::connection('mysql_srs')->table('student')
            ->select('student.id', 'student_info.program_id', 'student_detail.telephone', 'student_detail.woreda_id', 'student_detail.zone_id', 'student_detail.state_id', 'student_detail.kebele', 'student_detail.place_of_birth', 'zone.zone_name', 'student_detail.mother_name', 'student_detail.family_phone', 'student_detail.alternative_email', 'woreda.woreda_name', 'student.birth_date',  'student_info.id as student_info_id', 'sf.first_name', 'sf.fathers_name', 'sf.grand_fathers_name', 'student.student_id', 'student.sex', DB::raw("ifnull(student_detail.photo,'\"\"') AS photo"), 'student_info.academic_year', 'student_info.year', 'student_info.semester', 'student_info.record_status', 'student_info.is_registered', DB::raw('now() as admission_year'), 'program.name as departement','student_info.section')
            ->leftJoin('sf_guard_user as sf', 'sf.id', '=', 'student.sf_guard_user_id')
            ->leftJoin('student_info as student_info', 'student.id', '=', 'student_info.student_id')
            ->leftJoin('student_detail as student_detail', 'student.id', '=', 'student_detail.student_id')
            ->leftJoin('program', 'program.id', '=', 'student_info.program_id')
            ->leftJoin('zone', 'zone.id', '=', 'student_detail.zone_id')
            ->leftJoin('woreda', 'woreda.id', '=', 'student_detail.woreda_id')
            ->where('student.id', '=', $employee_id)
            ->orderByDesc('student_info.id')
            ->get();
        $result[0]->nationality = 'Ethiopian';
        // dd($result[0]);
        return $result[0];
    }
    // Abraham start
    private $conn;
    private $em;

    //get studnet inf for each semister
    public function getStudent($student_id)
    {
        $student_detail = DB::connection('mysql_srs')->table('student')
            ->select('student.id', 'student_info.program_id', 'student_info.id as student_info_id', 'sf.first_name', 'sf.fathers_name', 'sf.grand_fathers_name', 'student.student_id', 'student.sex', DB::raw("ifnull(student_detail.photo,'\"\"') AS photo"), 'student_info.academic_year', 'student_info.year', 'student_info.semester', 'student_info.record_status', 'student_info.is_registered', DB::raw('now() as admission_year'), 'program.name')
            ->leftJoin('sf_guard_user as sf', 'sf.id', '=', 'student.sf_guard_user_id')
            ->leftJoin('student_info as student_info', 'student.id', '=', 'student_info.student_id')
            ->leftJoin('student_detail as student_detail', 'student.id', '=', 'student_detail.student_id')
            ->leftJoin('program', 'program.id', '=', 'student_info.program_id')
            ->where('student.id', '=', $student_id)
            ->orderByDesc('student_info.id')
            
            ->get();

        return $student_detail;
    }

    public function getCampus(){


    }
    public function getDepartment(){


    }
    public function getProgram(){

    }
    public function getProgramLevel(){

    }


    //get the unique auto increament id of the student with the given id
    public function getStudentId($student_id)
    {
        //dd($student_id->id);
        $id_number = DB::connection('mysql_srs')->table('student')->select('student.student_id')->where('student.id', '=', $student_id->id)->first()->student_id;
        //dd($id_number);
        return $id_number;
    }
    //get student auto increment id from given student id ru000
    public function getStudentIdFromstudentId($studentId)
    {
        $id_number = DB::connection('mysql_srs')->table('student')->select('student.student_id')->where('student.id', '=', $studentId)->first()->student_id;
        //dd($id_number);
        return $id_number;
    }


    //get student id based on user name
    public function getstudentidFromUserName($userName)
    {
        $studentId = DB::connection('mysql_srs')->table('student')
            ->join('sf_guard_user', 'student.sf_guard_user_id', '=', 'sf_guard_user.id')
            ->select('student.id')
            ->where('sf_guard_user.username', $userName)
            ->first();

        //dd($studentId->id);
        return $studentId;
    }
    public function student_local_email($username){
        $local =  DB::connection('mysql_srs')->select("SELECT * FROM `students_local_email` WHERE `username` = :username",['username' => $username]);
        return $local;
    }
}