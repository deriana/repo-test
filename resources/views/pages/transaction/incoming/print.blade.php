<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
            font-size: 14px;
        }
        h1 {
            margin-bottom: 0;
        }
        h4 {
            margin-top: 5px;
            font-weight: normal;
        }
        #filter-info {
            margin-top: 20px;
            font-style: italic;
            text-align: left;
        }
    </style>
</head>
<body onload="window.print()">

    <h1>{{ $title }}</h1>

    @if($since && $until)
        <div id="filter-info">
            Filter Tanggal: {{ \Carbon\Carbon::parse($since)->format('d/m/Y') }} s.d {{ \Carbon\Carbon::parse($until)->format('d/m/Y') }}<br>
            Total Surat: {{ count($data) }}
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>Nomor Agenda</th>
                <th>Nomor Surat</th>
                <th>Pengirim</th>
                <th>Tanggal Surat</th>
                <th>Deskripsi</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $letter)
                <tr>
                    <td>{{ $letter->agenda_number }}</td>
                    <td>{{ $letter->reference_number }}</td>
                    <td>{{ $letter->from ?? '-' }}</td>
                    <td>{{ $letter->letter_date ? \Carbon\Carbon::parse($letter->letter_date)->format('d/m/Y') : '-' }}</td>
                    <td>{{ $letter->description ?? '-' }}</td>
                    <td>{{ $letter->note ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center;">Tidak ada surat ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
