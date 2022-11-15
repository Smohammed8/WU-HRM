<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,500;1,600;1,700;1,800&family=Noto+Serif+Ethiopic:wght@700&display=swap" rel="stylesheet">
    <style>
        @font-face {
            font-family: 'Ethiopian';
            src: url({{ storage_path('fonts/jiret.ttf') }}) format('truetype'), url({{ storage_path('fonts/jiret.woff') }}) format('woff');
        }
        td{
            padding:5px;
        }

    </style>
</head>
<body>
    <div style="width: 50%; height: auto; position: absolute; page-break-after: always; margin-left: -27px; margin-top: -230px; break-after: page; transform: rotate(270deg);">
        <img src="images/front.png" alt="">
        <div style="position: relative; float: right; left: -236px; top: -453px;">
            <img src="{{ storage_path('employee/photo/'.$img) }}" alt="" style="width: 190px; height: 190px; border-radius: 50%;">
        </div>
        <div style="width: 350px; position: relative; float: right; left: -165px; top: -285px; background-color: inherit; text-align: center; ">
            <p style="font-size: 27px; color: black;">
                <strong>Mr. Milky Seifu</strong>
            </p>
            <p style="position: relative; font-size: 20px; color: black; top: -40px;">
                <strong style="font-family: 'Noto Serif Ethiopic'">አቶ ሚልኪ ሰይፉ</strong>
            </p>
            <p style="position: relative; font-size: {{ strlen($employee->jobTitle->name) < 23 ? '25px' : '22px' }}; color: black; top: -65px; line-height: 0.6;">
                <strong style="font-family: 'Noto Serif Ethiopic'">Administrative Staff</strong>
            </p>
            <div style="position: relative; background-color: inherit;  text-align: center; width: {{ strlen($employee->jobTitle->name) < 23 ? '100%' : '80%' }}; top: {{ strlen($employee->jobTitle->name) < 23 ? '-115px' : '-110px' }}; left: {{ $role_left }};">
                <p style="font-size: {{ strlen($employee->jobTitle->name) < 23 ? '25px' : '22px' }}; color: black;  line-height: 0.6;">
                    <strong style="font-family: 'Noto Serif Ethiopic'">{{ $employee->jobTitle->name }}</strong>
                </p>
            </div>
            <div style="position: relative; left: 5px;  top: {{ strlen($employee->jobTitle->name) < 23 ? '-135px' : '-130px' }}; background-color: inherit; text-align: center;">
                <img src="{{ $qrcode }}" alt="">
            </div>
        </div>
        {{-- <div style="position: relative; float: right; left: {{ strlen($user_id->ju_role) < 25 ? '575px' : '610px' }}; top: 895px; background-color: inherit; text-align: center; width: 80%">
            <p style="position: relative; font-size: {{ strlen($user_id->ju_role) < 25 ? '52px' : '47px' }}; color: black; top: -225px; line-height: 0.6;">
                <strong style="font-family: 'Noto Serif Ethiopic'">Administrator Staff</strong>
            </p>
        </div>
        <div style="position: relative; float: right; left: {{ strlen($user_id->ju_role) < 25 ? '1220px' : '1250px' }}; top: 940px; background-color: inherit; text-align: center; width: 80%">
            <p style="position: relative; font-size: {{ strlen($user_id->ju_role) < 25 ? '52px' : '47px' }}; color: black; top: -225px; line-height: 0.7;">
                <strong style="font-family: 'Noto Serif Ethiopic'">{{ $user_id->ju_role }}</strong>
            </p>
        </div>

        <div style="position: relative; float: right; left: {{ strlen($user_id->ju_role) < 25 ? '1600px' : '1630px' }}; top: {{ strlen($user_id->ju_role) < 25 ? '825px' : '860px' }}; background-color: inherit; text-align: center;">
            <img src="{{ $qrcode }}" alt="">
        </div> --}}
    </div>

    <div style="width: 54%; height: auto; break-after: page; position: absolute; margin-left: -45px; margin-top: -59px; page-break-after: always;">
        <img width="100%" src="images/back.png" alt="">
        <p style="font-size: 18px; color: black; position: relative; top: -290px; left: 10px;">
            <strong style="font-family: 'Noto Serif Ethiopic'">Mr. {{ $employee->first_name }} {{ $employee->father_name }} {{ $employee->grand_father_name }}</strong>
        </p>
        <p style="font-size: 16px; color: black; position: relative; top: -315px; left: 14px;">
            <strong style="font-family: 'Noto Serif Ethiopic'">Mr. {{ $employee->first_name }} {{ $employee->father_name }} {{ $employee->grand_father_name }}</strong>
        </p>
        <p style="font-size: 18px; color: black; position: relative; top: -305px; left: 14px;">
            <strong style="font-family: 'Noto Serif Ethiopic'">Ethiopian</strong>
        </p>

        <p style="font-size: 18px; color: black; position: relative; top: -295px; left: 14px;">
            <strong style="font-family: 'Noto Serif Ethiopic'">{{ Carbon\Carbon::now()->format('d/m/Y') }}</strong>
        </p>

        <p style="font-size: 18px; color: black; position: relative; top: -345px; left: 330px;">
            <strong style="font-family: 'Noto Serif Ethiopic'">{{ Carbon\Carbon::now()->format('d/m/Y') }}</strong>
        </p>
        <div style="position: relative; float: right; top: -630px;">
            <img src="{{ storage_path('employee/photo/'.$img) }}" alt="" style="width: 92px; height: 92px;">
        </div>
        <div style="position: relative; top: -530px; text-align: right; left: 90px;">
            <img src="{{ $barcode }}" alt="">
        </div>
    </div>
</body>
</html>