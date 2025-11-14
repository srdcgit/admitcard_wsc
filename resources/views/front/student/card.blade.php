<!DOCTYPE html>
<html>

<head>
    <title>Admit Card - Odisha Skills 2025</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            padding: 30px;
        }

        .wrapper {
            width: 800px;
            margin: auto;
            background: #ffffff;
            padding: 40px 50px;
        }

        /* HEADER AREA */
        .header {
            text-align: center;
            position: relative;
        }

        .header img.logo-left {
            position: absolute;
            left: 0;
            top: 0;
            height: 80px;
        }

        .header img.logo-right {
            position: absolute;
            right: 0;
            top: 0;
            height: 80px;
        }

        .header-title {
            font-size: 24px;
            font-weight: bold;
        }

        .header-sub {
            margin-top: 5px;
            font-size: 16px;
            font-weight: 600;
        }

        .purple-line {
            width: 100%;
            height: 4px;
            background: #A020F0;
            margin: 20px 0;
        }

        /* DETAILS SECTION */
        table.details {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table.details td {
            padding: 6px 4px;
            font-size: 16px;
        }

        .label {
            font-weight: bold;
            width: 180px;
        }

        /* RIGHT SIDE PHOTO + QR */
        .right-box {
            text-align: center;
        }

        .candidate-photo {
            width: 150px;
            height: 150px;
            border: 1px solid #ddd;
            margin-bottom: 10px;
        }

        .qr-box {
            margin-top: 10px;
        }

        .qr-text {
            font-size: 12px;
            margin-top: 5px;
        }

        /* INSTRUCTIONS */
        .instructions-title {
            margin-top: 40px;
            font-weight: bold;
            font-size: 16px;
        }

        .instructions ul {
            margin-top: 10px;
            padding-left: 20px;
        }

        .instructions ul li {
            font-size: 14px;
            margin-bottom: 10px;
        }

        @media print {
            body {
                background: white;
            }
        }
    </style>
</head>

<body>

    <div class="wrapper">

        <!-- HEADER -->
        <div class="header">
            <img src="{{ asset('skilllogo.png') }}" class="logo-left" style="height: 90px;">
            <img src="{{ asset('wsc.png') }}" class="logo-right" style="height: 110px;">

            <div class="header-title">Odisha Skill Development Authority</div>
            <div class="header-sub">Government of Odisha</div>
            <div class="header-sub"><strong>Admit Card for Odisha Skills - 2025 (Level-1)</strong></div>
        </div>

        <div class="purple-line"></div>

        <!-- DETAILS TABLE -->
        <table class="details">
            <tr>
                <td class="label">Name</td>
                <td>: <b>{{ $student->candidate_first_name }} {{ $student->candidate_last_name }}</b></td>

                <td rowspan="12" class="right-box">

                    <!-- Photo -->
                    {{-- <img src="{{ asset('uploaded_files/' . $student->folder_number . '/passportphoto.jpg') }}"
                        class="candidate-photo"> --}}

                    <!-- QR CODE -->
                    <div class="qr-box">
                        {!! QrCode::size(130)->generate(url('/scan/' . $student->application_id)) !!}

                    </div>

                    <div class="qr-text">
                        This Admit card verified at <br>
                        https://www.skillodisha.gov.in/
                    </div>
                </td>
            </tr>

            <tr>
                <td class="label">Registration Number</td>
                <td>: <b>{{ $student->application_id }}</b></td>
            </tr>

            <tr>
                <td class="label">Email Address</td>
                <td>: <b>{{ $student->email }}</b></td>
            </tr>

            <tr>
                <td class="label">Mobile Number</td>
                <td>: <b>{{ $student->candidate_mobile_number }}</b></td>
            </tr>

            <tr>
                <td class="label">Venue Name</td>
                <td>: <b>{{ $student->center->name }}</b></td>
            </tr>

            <tr>
                <td class="label">Venue Address</td>
                <td>: <b>{{ $student->center->address }}</b></td>
            </tr>

            <tr>
                <td class="label">Skill/Trade</td>
                <td>: <b>{{ $student->trade }}</b></td>
            </tr>

            <tr>
                <td class="label">Exam Date</td>
                <td>: <b>23-November-2025</b></td>
            </tr>

            <tr>
                <td class="label">Exam Time</td>
                <td>: <b>11:00 AM to 12:00 PM</b></td>
            </tr>

            <tr>
                <td class="label">Level</td>
                <td>: <b>Level-1</b></td>
            </tr>
        </table>

        <!-- INSTRUCTIONS -->
        <div class="instructions-title">IMPORTANT INSTRUCTIONS</div>

        <div class="instructions">
            <ul>
                <li>Candidate must carry the admit card to the examination venues with valid ID proof and
                    should produce it whenever required.</li>

                <li>Candidate should be physically present in the assigned venue at least 1 Hour prior to the
                    starting time of competition.</li>

                <li>Candidates will not be permitted to enter the exam hall after 15 minutes after scheduled
                    start time of the examination and will not be allowed to leave the exam hall before the
                    end of the examination.</li>

                <li>The candidate must bring any essential Kit/Tools/Items etc. as required and instructed by
                    World Skill Center.</li>

                <li>Electronic devices like calculators, tablets, pager, mobile phones or any electronic gadgets
                    are not allowed inside the examination hall.</li>

                {{-- <li> Follow the Government COVID guidelines throughout the examination process.</li> --}}
            </ul>
        </div>

    </div>

    <script>
        // window.print(); // enable when needed
    </script>

</body>

</html>
