<?php

namespace App;

use Andegna\DateTimeFactory;
use Carbon\Carbon;

class Constants
{
    const EMPLOYEE_PHOTO_UPLOAD_PATH = '/employee/photo/';
    const EMPLOYEE_DRIVER_LICESNCE_UPLOAD_PATH = '/employee/driver_license/';
    const EMPLOYEE_LICESNSES_UPLOAD_PATH = 'uploads/employee/licenses';

    const JOB_LEVELS = [
        'I' => 1,
        'II' => 2,
        'III' => 3,
        'IV' => 4,
        'V' => 5,
        'VI' => 6,
        'VII' => 7,
        'VIII' => 8,
        'IX' => 9,
        'X' => 10,
        'XI' => 11,
        'XII' => 12,
        'XIII' => 13,
        'XIV' => 14,
        'XV' => 15,
        'XVI' => 16,
        'XVII' => 17,
        'XVIII' => 18,
        'XIX' => 19,
        'XX' => 20,
        'XXI' => 21,
        'XXII' => 22,
    ];
    const COLLEGES = [
        0 => 'CENTER',
        1 => 'BECO',
        2 => 'AGARO',
        3 => 'CEBS',
        4 => 'CNS',
        5 => 'JIH',
        6 => 'JIT',
        7 => 'JUCAVM',
        8 => 'LAW',
        9 => 'SPORT ACADEMY'
    ];
    const LOGO_PATH = 'logo.jpg';
    const ORG_SHORT = 'JU';
    const ORG_LONG = 'Jimma University University';

    const PLACEMENT_ROUND_STATUS_OPENED = 0;
    const PLACEMENT_ROUND_STATUS_RANKED = 1;
    const PLACEMENT_ROUND_STATUS_PLACED = 2;
    const PLACEMENT_ROUND_STATUS_APPROVED = 3;
    const PLACEMENT_ROUND_STATUS_CLOSED = 4;

    const POSITION_STATUS = [
        0 => 'OPEN',
        1 => 'LOCK',
    ];
    const EDUCATION_CRITERIA = 'Education Criteria';
    const EXPERIENCE_CRITERIA = 'Experience Criteria';
    const EFFICIENCY_CRITERIA = 'Efficiency Criteria';
    const USER_TYPE_EMPLOYEE = 'employee';
    const USER_TYPE_SUPER_ADMIN = 'super_admin';
    const USER_TYPE_ADMIN = 'admin';
    const PERMISSION_DASHBOARD = 'DASHBOARD';



    public static function gcToEt($date)
    {
        return DateTimeFactory::fromDateTime(Carbon::createFromDate($date))->format('Y-m-d');
    }
    public static function etToGc($date)
    {
        $date = Carbon::createFromFormat('Y-m-d', $date);
        $year = $date->format('Y');
        $month = $date->format('m');
        $day = $date->format('d');
        return DateTimeFactory::of($year, $month, $day)->toGregorian();
    }
}
