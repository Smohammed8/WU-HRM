<?php
namespace App;
class Constants
{
    const EMPLOYEE_PHOTO_UPLOAD_PATH = '/employee/photo/';
    const EMPLOYEE_DRIVER_LICESNCE_UPLOAD_PATH = '/employee/driver_license/';
    const EMPLOYEE_LICESNSES_UPLOAD_PATH = 'uploads/employee/licenses';
    const COLLEGES =[
        0=>'CENTER',
        1=>'BECO',
        2=>'AGARO',
        3=>'CEBS',
        4=>'CNS',
        5=>'JIH',
        6=>'JIT',
        7=>'JUCAVM',
        8=>'LAW',
        9=>'SPORT ACADEMY'
    ];

    const POSITION_STATUS = [
        0=>'OPEN',
        1=>'LOCK',
    ];
    const USER_TYPE_EMPLOYEE = 'employee';
    const PERMISSION_DASHBOARD = 'DASHBOARD';
}
