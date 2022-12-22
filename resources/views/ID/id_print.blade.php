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
    <div style="width: 100%; height: auto; break-after: page; position: absolute; margin-left: -45px; margin-top: -45px; page-break-after: always;">
        <img width="100%" src="images/front.jpg" alt="">
        <p style="font-size: 30px; color: black; position: relative; top: -435px; left: 60px;">
            <strong style="font-family: 'Noto Serif Ethiopic'">ሙሉ ስም፦</strong>
        </p>
        <p style="font-size: 30px; color: black; position: relative; top: -519px; left: 220px;">
            <strong style="font-family: 'Noto Serif Ethiopic'">{{ $employee?->first_name_am  }} {{ $employee?->father_name_am  }} {{ $employee?->grand_father_name_am }}</strong>
        </p>
        <p style="font-size: 30px; color: black; position: relative; top: -545px; left: 60px;">
            <strong>Full Name:</strong>
        </p>
        <p style="font-size: 30px; color: black; position: relative; top: -609px; left: 220px;">
            <strong>{{ $employee->first_name }} {{ $employee->father_name }} {{ $employee->grand_father_name }}</strong>
        </p>
        <p style="font-size: 30px; color: black; position: relative; top: -640px; left: 60px;">
            <strong style="font-family: 'Noto Serif Ethiopic'">ዜግነት፦</strong>
        </p>
        <p style="font-size: 30px; color: black; position: relative; top: -722px; left: 184px;">
            <strong style="font-family: 'Noto Serif Ethiopic'">ኢትዮጵያዊ</strong>
        </p>
        <p style="font-size: 30px; color: black; position: relative; top: -745px; left: 60px;">
            <strong>Nationality:</strong>
        </p>
        <p style="font-size: 30px; color: black; position: relative; top: -822px; left: 224px;">
            <strong style="font-family: 'Noto Serif Ethiopic'">Ethiopian</strong>
        </p>
        <p style="font-size: 30px; color: black; position: relative; top: -855px; left: 60px;">
            <strong style="font-family: 'Noto Serif Ethiopic'">የስራ ክፍል፦</strong>
        </p>
        <p style="font-size: 30px; color: black; position: relative; top: -938px; left: 234px;">
            <strong style="font-family: 'Noto Serif Ethiopic'">{{ $employee?->position?->jobTitle?->jobTitleCategory?->unit?->name }}</strong>
        </p>
        <p style="font-size: 30px; color: black; position: relative; top: -965px; left: 60px;">
            <strong>Department:</strong>
        </p>
        <p style="font-size: 30px; color: black; position: relative; top: -1042px; left: 244px;">
            <strong style="font-family: 'Noto Serif Ethiopic'">{{ $employee?->position?->jobTitle?->jobTitleCategory?->unit?->name }}</strong>
        </p>
        <p style="font-size: 30px; color: black; position: relative; top: -1075px; left: 60px;">
            <strong style="font-family: 'Noto Serif Ethiopic'">የስራ መደብ:-</strong>
        </p>
        <p style="font-size: 30px; color: black; position: relative; top: -1158px; left: 234px;">
            <strong style="font-family: 'Noto Serif Ethiopic'">{{ $employee?->position?->jobTitle?->name }}</strong>
        </p>
        <p style="font-size: 30px; color: black; position: relative; top: -1195px; left: 60px;">
            <strong style="font-family: 'Noto Serif Ethiopic'">Job Position:</strong>
        </p>
        <p style="font-size: 30px; color: black; position: relative; top: -1278px; left: 264px;">
            <strong style="font-family: 'Noto Serif Ethiopic'">{{ $employee?->position?->jobTitle?->name }}</strong>
        </p>
        <p style="font-size: 25px; color: rgb(21, 58, 226); position: relative; top: -1720px; left: 660px;">
            <strong style="font-family: 'Noto Serif Ethiopic'">የመ.ቁጥር/ID No.</strong>
        </p>
        <p style="font-size: 25px; color: rgb(21, 58, 226); position: relative; top: -1790px; left: 860px;">
            <strong style="font-family: 'Noto Serif Ethiopic'">{{ $employee->employment_identity }}</strong>
        </p>
        <div style="position: relative; float: right; top: -1810px; left: -90px;">
            <img src="{{ storage_path('/employee/photo/'.$img) }}" alt="" style="width: 230px; height: 290px;">
        </div>
    </div>
    <div style="width: 100%; height: auto; break-after: page; position: absolute; margin-left: -45px; margin-top: -45px; page-break-after: always;">
        <img width="100%" src="images/back.jpg" alt="">
        <p style="font-size: 30px; color: rgb(224, 17, 17); position: relative; top: -440px; left: 400px;">
            <strong style="font-family: 'Noto Serif Ethiopic'">የተሰጠበት ቀን  {{ Carbon\Carbon::now()->format('d/m/Y') }} ዓ.ም</strong>
        </p>
        <p style="font-size: 25px; color: rgb(224, 17, 17); position: relative; top: -470px; left: 430px;">
            <strong style="font-family: 'Noto Serif Ethiopic'">Date of Issue  {{ Carbon\Carbon::now()->format('d/m/Y') }} G.C</strong>
        </p>
        <p style="font-size: 27px; color: rgb(79, 17, 224); position: relative; top: -520px; left: 80px;">
            <strong style="font-family: 'Noto Serif Ethiopic'">የባለስልጣኑ ፊርሚያ</strong>
        </p>
        <div style="position: relative; left: 250px;  top: -640px;">
            <img src="{{ storage_path('/signature/signature.png') }}" alt="" style="width: 200px; height: 220px;">
        </div>
        <div style="position: relative; left: 250px;  top: -710px;">
            <img src="{{ storage_path('/signature/titter.png') }}" alt="" style="width: 200px; height: 200px;">
        </div>
        <div style="position: relative; left: 650px;  top: -990px;">
            <img src="{{ storage_path('/signature/seal.png') }}" alt="" style="width: 270px; height: 270px;">
        </div>
    </div>
</body>
</html>

