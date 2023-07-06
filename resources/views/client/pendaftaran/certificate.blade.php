<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Certificate</title>

    <style>
        p {
            text-align: center;
            color: #2b3c53;
            font-size: 22pt;
            font-weight: Bold;
        }

        .box {
            position: absolute;
        }

        .image {
            height: 120%;
            width: 110%;
            margin-top: -1.3cm;
            margin-left: -1.3cm;
        }

        .certificate {
            position: absolute;
            top: 20pt;
            left: -6pt;
            font-size: 40pt;
            font-weight: bold;
            color: #2b3c53 !important;
        }

        .seminar_name {
            position: absolute;
            top: 60pt;
            left: -6pt;
            font-size: 30pt;
            font-weight: bold;
            color: #2b3c53 !important;
        }

        .organizer {
            position: absolute;
            top: 100pt;
            left: -6pt;
            font-size: 20pt;
            font-weight: bold;
            color: #2b3c53 !important;
        }

        .seminar_date {
            position: absolute;
            bottom: 120pt;
            left: 60pt;
            font-size: 12pt;
            font-weight: bold;
            color: #2b3c53 !important;
        }

        .name {
            position: absolute;
            top: 215pt;
            left: -6pt;
            font-size: 50pt;
            font-weight: bold;
            color: #2b3c53 !important;
        }

        .chief {
            position: absolute;
            bottom: 0pt;
            left: 50pt;
            font-size: 20pt;
            font-weight: bold;
            color: #2b3c53 !important;
        }

        .signature {
            position: absolute;
            bottom: 20pt;
            left: 50pt;
            width: 15%;
            height: auto;
        }

        .logo {
            position: absolute;
            top: 30pt;
            right: 50pt;
            width: 10%;
            height: auto;
        }
    </style>
</head>

<body>
    <section>
        <table width="100%">
            @foreach ($pendaftaran as $item)
                <tr>
                    <td class="text-center" width="50%">
                        <div class="box">
                            <div class="certificate">
                                Certificate of Achievement
                            </div>
                            <img class="image" src="{{ asset('images/certificate.png') }}" alt="">
                            <div class="name">{{ $item->yuser->name }}</div>
                            <div class="seminar_name">{{ $item->seminars->seminar_name }}</div>
                            <div class="organizer">Presented By {{ $item->seminars->organizer }}</div>
                            <div class="seminar_date">{{ tanggal_indonesia($item->seminars->seminar_date) }}</div>
                            <img class="signature" src="{{ asset('images/signature.png') }}" alt="">
                            <img class="logo" src="{{ asset('images/logo.png') }}" alt="">
                            <div class="chief">Nicholas J. Fury</div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </table>
    </section>
</body>

</html>
