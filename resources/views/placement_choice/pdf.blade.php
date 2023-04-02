<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,500;1,600;1,700;1,800&family=Noto+Serif+Ethiopic:wght@700&display=swap" rel="stylesheet">
    <style>
        .styled-table {
            border-collapse: collapse;
            margin: 25px 0;
            /* margin-top: 110px; */
            font-size: 0.9em;
            font-family: sans-serif;
            min-width: 100%;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
        }

        .styled-table thead tr {
            background-color: #0a0ad8;
            color: #ffffff;
            text-align: left;
        }

        .styled-table th,
        .styled-table td {
            padding: 12px 15px;
        }
        .styled-table tbody tr {
            border-bottom: 1px solid #dddddd;
        }

        .styled-table tbody tr:nth-of-type(even) {
            background-color: #f3f3f3;
        }

        .styled-table tbody tr:last-of-type {
            border-bottom: 2px solid #dddddd;
        }

        .styled-table tbody tr.active-row {
            font-weight: bold;
            color: #009879;
        }
        .pdfheader {
            text-align: center;
            height: 50px;
            line-height: 0.4;
            flex: 1;
            margin-top: -40px;
        }
        @font-face {
            font-family: 'Ethiopian';
            src: url({{ storage_path('fonts/jiret.ttf') }}) format('truetype'), url({{ storage_path('fonts/jiret.woff') }}) format('woff');
        }
        #content {
            display: table;
            text-align: center;
        }

        #pageFooter {
            display: table-footer-group;
        }

        #pageFooter:after {
            counter-increment: page;
            content: counter(page);
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div style="display: flex">
        <div style="text-align: right">
            <b style="font-size: 20px">Date: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</b>
        </div>
        <div class="pdfheader" style="margin-bottom: 70px">
            <img class="logo" style=" height: 100px;" src="{{ public_path('assets/logo/'.\App\Constants::LOGO_PATH) }}" alt="Avatar">
            <h2>Jimma University</h2>
            <h3>All placement choice</h3>
        </div>
    </div>
    <div class="card-body">
        @foreach ($units as $keyUnit => $unit)
        <div style="page-break-after: always;break-after: page;">
            <table class="styled-table">
                <tbody>
                    <tr>
                        <td colspan="5" style="text-align: center">
                            {{ $keyUnit + 1 }}. <b style="font-family: 'Noto Serif Ethiopic'">Unit: {{ $unit->name }}</b>
                        </td>
                    </tr>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Full name</th>
                            <th>Current Position</th>
                            <th>Choice one</th>
                            <th>Choice two</th>
                        </tr>
                    </thead>
                    @forelse ( $type == 'choice' ? $unit->getPositionedChoice() : $unit->getPositionedResult() as $key => $placementChoice )
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $placementChoice->employee?->getNameAttribute() }}</td>
                            <td><b style="font-family: 'Noto Serif Ethiopic'">{{ $placementChoice->employee?->position?->name }}</b></td>
                            <td><b style="font-family: 'Noto Serif Ethiopic'">{{ $placementChoice->choiceOne?->name }}</b></td>
                            <td><b style="font-family: 'Noto Serif Ethiopic'">{{ $placementChoice->choiceTwo?->name }}</b></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center">No employee found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
            
            {{-- <div id="content">
                <div id="pageFooter">Page </div>
            </div> --}}
        @endforeach
    </div>
</body>
</html>