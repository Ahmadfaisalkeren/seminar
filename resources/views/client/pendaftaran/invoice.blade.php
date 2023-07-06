<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        p {
            text-align: center;
            color: #2b3c53;
            font-size: 22pt;
            font-weight: Bold;
        }

        .box {
            position: relative;
            border: 1px solid;
        }

        .logo {
            position: absolute;
            top: 10pt;
            left: 35pt;
            width: 10%;
            height: auto;
        }

        .seminar_name {
            position: absolute;
            top: 115pt;
            left: 45pt;
            /* font-family: 'Poppins', sans-serif; */
            font-size: 30pt;
            font-weight: bold;
            color: #2b3c53 !important;
        }

        .organizer {
            position: absolute;
            top: 150pt;
            left: 45pt;
            font-size: 20pt;
            font-weight: bold;
            color: #2b3c53 !important;
        }

        .seminar_date {
            position: absolute;
            top: 245pt;
            left: 45pt;
            font-size: 12pt;
            font-weight: bold;
            color: #2b3c53 !important;
        }

        .name {
            position: absolute;
            top: 120pt;
            right: 16pt;
            font-size: 16pt;
            font-weight: bold;
            color: #2b3c53 !important;
        }

        .phone {
            position: absolute;
            top: 140pt;
            right: 16pt;
            font-size: 16pt;
            font-weight: bold;
            color: #2b3c53 !important;
        }

        /* Table CSS */

        .vertical-table {
            border-collapse: collapse;
            margin: 20px 0;
            width: 100%;
        }

        .thead,
        .tdata {
            padding: 10px;
            border: 1px solid black;
        }

        /* .thead {
            text-align: left;
            width: 150px;
            background-color: #eee;
            font-weight: bold;
        } */

        .tdata {
            text-align: left;
        }

        .footer {
            margin-top: 20px;
            text-align: right;
        }

        .footer p {
            font-size: 14px;
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td,
        th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        thead {
            text-align: left;
        }

        .paid {
            position: absolute;
            top: 750px;
            left: 150px;
            /* width: 180px;
            height: 80px; */
            /* background-color: #6c757d; */
            color: #ff0000;
            text-align: center;
            line-height: 80px;
            font-size: 150px;
            font-weight: bold;
            transform: rotate(-25deg);
            opacity: 30%;
        }
    </style>
</head>

<body>
    <section style="border: 1px solid #fff">
        <p>This is your seminar ticket</p>
        <table width="100%">
            @foreach ($pendaftaran as $item)
                <tr>
                    <td class="text-center" width="50%">
                        <div class="box">
                            <img src="{{ asset('images/ticket.png') }}" width="100%" alt="">
                            <img class="logo" src="{{ asset('images/logo.png') }}" width="100%" alt="">
                            <div class="name">{{ $item->yuser->name }}</div>
                            <div class="phone">{{ $item->yuser->phone }}</div>
                            <div class="seminar_name">{{ $item->seminars->seminar_name }}</div>
                            <div class="organizer">Presented By {{ $item->seminars->organizer }}</div>
                            <div class="seminar_date">{{ tanggal_indonesia($item->seminars->seminar_date) }}</div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </table>
    </section>
    <section style="border: 1px solide #fff">
        <p>This is your invoice</p>
        <div class="paid">PAID</div>
        <table width="100%" class="vertical-table">
            @foreach ($pendaftaran as $item)
                <tr>
                    <th class="thead">Name</th>
                    <td class="tdata">{{ $item->yuser->name }}</td>
                </tr>
                <tr>
                    <th class="thead">Email</th>
                    <td class="tdata">{{ $item->yuser->email }}</td>
                </tr>
                <tr>
                    <th class="thead">Phone</th>
                    <td class="tdata">{{ $item->yuser->phone }}</td>
                </tr>
                <tr>
                    <th class="thead">Seminar Name</th>
                    <td class="tdata">{{ $item->seminars->seminar_name }}</td>
                </tr>
                <tr>
                    <th class="thead">Seminar Date</th>
                    <td class="tdata">{{ tanggal_indonesia($item->seminars->seminar_date) }}</td>
                </tr>
                <tr>
                    <th class="thead">Organizer</th>
                    <td class="tdata">{{ $item->seminars->organizer }}</td>
                </tr>
                <tr>
                    <th class="thead">Price</th>
                    <td class="tdata">IDR {{ format_uang($item->seminars->price) }}</td>
                </tr>
                <tr>
                    <th class="thead">Status</th>
                    <td class="tdata">{{ $item->statuses->status }}</td>
                </tr>
            @endforeach
        </table>
        <div class="footer">
            <p>Thank you for your business!</p>
        </div>
    </section>
</body>

</html>
