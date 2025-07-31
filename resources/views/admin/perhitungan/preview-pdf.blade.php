<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview Perhitungan SAW</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h2 {
            margin-bottom: 5px;
        }

        .header p {
            margin: 0;
        }

        table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .footer {
            margin-top: 50px;
            text-align: right;
        }

        .btn-container {
            margin: 20px 0;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>HASIL PERHITUNGAN SAW</h2>
            <p>Tanggal: {{ $tanggal }}</p>
        </div>

        <div class="btn-container">
            {{-- <a href="{{ route('perhitungan.download') }}" class="btn btn-primary">Download PDF</a> --}}
            <a href="{{ route('perhitungan.index') }}" class="btn btn-secondary">Kembali</a>
        </div>

        <h4>1. Tabel Normalisasi</h4>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Alternatif</th>
                        @foreach ($kriteria as $k)
                            <th>{{ $k->nama_kriteria }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($normalisasi as $nama => $nilai)
                        <tr>
                            <td>{{ $nama }}</td>
                            @foreach ($kriteria as $k)
                                <td>{{ number_format($nilai[$k->id], 4) }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <h4>2. Tabel Ranking</h4>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Ranking</th>
                        <th>Alternatif</th>
                        <th>Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    @php $rank = 1; @endphp
                    @foreach ($sortedData as $nama => $nilai)
                        <tr>
                            <td>{{ $rank++ }}</td>
                            <td>{{ $nama }}</td>
                            <td>{{ number_format($nilai, 4) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="footer">
            <p>Jakarta, {{ $tanggal }}</p>
            <br><br><br>
            <p>Admin</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
