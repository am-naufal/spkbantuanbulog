<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Perhitungan Penerima Bantuan</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <style type="text/css">
        .garis1 {
            border-top: 3px solid black;
            height: 2px;
            border-bottom: 1px solid black;
        }

        #camat {
            text-align: center;
        }

        #nama-camat {
            margin-top: 100px;
            text-align: center;
        }

        #ttd {
            position: absolute;
            bottom: 10;
            right: 20;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            border: 1px solid #000;
            padding: 5px;
        }

        .table th {
            background-color: #f0f0f0;
        }
    </style>
</head>

<body>
    <div>
        <table>
            <tr>
                <td style="padding-right: 240px; padding-left: 20px"><img
                        src="{{ public_path('images/logobwibw.webp') }}" width="90" height="90"></td>
                <td>
                    <center>
                        <font size="4">PEMERINTAH KABUPATEN BANYUWANGI</font><br>
                        <font size="2">KANTOR KECAMATAN WONGSORERO</font><br>
                        <font size="2">Jl. Raya Wongsorejo No.136, Dusun Krajan, Wongsorejo, Banyuwangi, Kabupaten
                            Banyuwangi, Jawa Timur 68453</font><br>
                    </center>
                </td>
            </tr>
        </table>

        <hr class="garis1" />
        <div style="margin-top: 25px; margin-bottom: 25px;">
            <center><strong><u>HASIL PERHITUNGAN PENERIMA BANTUAN</u></strong></center>
        </div>

        <!-- Tabel Hasil Perangkingan -->
        <div style="margin-bottom: 30px;">
            <h5>Hasil Perangkingan</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Ranking</th>
                        <th>Nama Alternatif</th>
                        <th>Total Nilai</th>
                    </tr>
                </thead>
                <tbody>

                    @php $no = 1; @endphp
                    @foreach ($sortedData as $alternatif => $nilai)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $alternatif }}</td>
                            <td>{{ number_format($nilai, 3) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Tabel Normalisasi -->
        <div style="margin-bottom: 30px;">
            <h5>Matriks Ternormalisasi</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Alternatif / Kriteria</th>
                        @foreach ($kriteria as $k)
                            <th>{{ $k->nama_kriteria }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($normalisasi as $alternatif => $nilaiKriteria)
                        <tr>
                            <td>{{ $alternatif }}</td>
                            @foreach ($kriteria as $k)
                                <td>{{ number_format($nilaiKriteria[$k->id] ?? 0, 3) }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div id="ttd" class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <p id="camat">Banyuwangi, {{ $tanggal }}</p>
                <p id="camat"><strong>Camat Wongsorejo</strong></p>
                <div id="nama-camat"><strong><u>SUPARDI</u></strong><br />
                    NIP. 3175044408730004</div>
            </div>
        </div>
    </div>
    @dd($normalisasi)

</body>

</html>
