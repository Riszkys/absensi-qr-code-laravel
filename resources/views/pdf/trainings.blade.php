<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Training PDF</title>
    <!-- Include any necessary styles or scripts here -->
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h1>Data Training</h1>
    <table>
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">NIK Peserta</th>
                <th scope="col">Nama Peserta</th>
                <th scope="col">Dept. Peserta</th>
                <th scope="col">Status Absen</th>
                <th scope="col">col</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($trainings as $training)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $training->nik }}</td>
                    <td>{{ $training->name }}</td>
                    <td>{{ $training->nama }}</td>
                    <td>{{ $training->status_absen ? $training->status_absen : 'Belum Absen' }}</td>
                    <td>{{ $training->hasil_test ? $training->hasil_test : 'Belum Test' }}</td>
                </tr>
            @endforeach

        </tbody>
    </table>
</body>

</html>
