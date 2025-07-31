<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Hasil Voting - {{ $event->nama_kegiatan }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
        }

        .container {
            width: 100%;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .header p {
            margin: 5px 0;
            color: #666;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
            vertical-align: middle;
        }

        th {
            background-color: #f7f7f7;
            font-weight: bold;
        }

        .progress-bar-container {
            width: 100%;
            background-color: #e0e0e0;
            border-radius: 4px;
        }

        .progress-bar {
            height: 20px;
            background-color: #4f46e5;
            border-radius: 4px;
            text-align: center;
            color: white;
            line-height: 20px;
            font-size: 12px;
        }

        .candidate-photo {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #888;
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Laporan Hasil E-Voting</h1>
            <p>{{ $event->nama_kegiatan }}</p>
            <p>Total Suara Masuk: <strong>{{ $totalVotesInEvent }}</strong></p>
        </div>

        <table>
            <thead>
                <tr>
                    <th style="width: 10%; text-align: center;">Peringkat</th>
                    <th style="width: 15%;">Foto</th>
                    <th>Nama Kandidat</th>
                    <th style="width: 15%; text-align: center;">Jumlah Suara</th>
                    <th style="width: 30%;">Persentase</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($results as $index => $result)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td style="text-align: center;">
                        @if ($result->foto_data)
                        {{-- Tampilkan gambar dari data base64 --}}
                        <img src="{{ $result->foto_data }}" alt="Foto" class="candidate-photo">
                        @else
                        <span>-</span>
                        @endif
                    </td>
                    <td>{{ $result->nama_kandidat }}</td>
                    <td style="text-align: center;">{{ $result->vote_count }}</td>
                    <td>
                        <div class="progress-bar-container">
                            <div class="progress-bar" style="width: {{ $result->percentage }}%;">
                                {{ $result->percentage }}%
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center;">Belum ada suara yang masuk.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="footer">
            Laporan ini dibuat secara otomatis oleh Sistem E-Vote pada {{ date('d F Y, H:i') }}.
        </div>
    </div>
</body>
</html>
