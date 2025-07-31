<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Perhitungan Metode SAW</title>
    <style type="text/css">
        @page {
            size: landscape;
            margin-top: 0.5cm;
        }

        /* CSS Bootstrap yang diperlukan */
        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
        }

        .table tbody+tbody {
            border-top: 2px solid #dee2e6;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.075);
        }

        .table-bordered {
            border: 1px solid #dee2e6;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #dee2e6;
        }

        .table-bordered thead th,
        .table-bordered thead td {
            border-bottom-width: 2px;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin-right: -15px;
            margin-left: -15px;
        }

        .col-md-4 {
            flex: 0 0 33.333333%;
            max-width: 33.333333%;
            position: relative;
            width: 100%;
            padding-right: 15px;
            padding-left: 15px;
        }

        .table-responsive {
            display: block;
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .card-body {
            flex: 1 1 auto;
            min-height: 1px;
            padding: 1.25rem;
        }

        /* CSS Kustom */
        .garis1 {
            border-top: 3px solid black;
            height: 2px;
            border-bottom: 1px solid black;
        }

        #camat {
            text-align: center;
        }

        #nama-camat {
            margin-top: 50px;
            text-align: center;
        }

        #ttd {
            float: right;
            margin-top: 50px;
            margin-right: 50px;
            text-align: left;
            width: 250px;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.5;
        }

        center {
            text-align: center;
        }

        strong {
            font-weight: bold;
        }

        u {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div>
        <table style="width: 100%; border-collapse: collapse; ">
            <tr>
                <td style="width: 20%; text-align: center; padding: 10px; "><img
                        src="{{ public_path('images/logobwibw.webp') }}" width="90"></td>
                <td style="width: 100%; text-align: center; padding: 5px;  ">
                    <div style="font-size: 18px; font-weight: bold;">PEMERINTAH KABUPATEN BANYUWANGI</div>
                    <div style="font-size: 16px; font-weight: bold;">KECAMATAN WONGSOREJO</div>
                    <div style="font-size: 12px;">Jl. Raya Wongsorejo No.136, Dusun Krajan, Kecamatan Wongsorejo,
                        Kabupaten Banyuwangi, Jawa Timur 68453</div>
                    <div style="font-size: 11px;">Telepon: (0333) 123456 Email: wongsorejo@banyuwangikab.go.id</div>
                </td>
            </tr>
        </table>
        <hr class="garis1" />
        <div style="margin-top: 25px; margin-bottom: 25px;">
            <center><strong><u>LAPORAN PERHITUNGAN METODE SAW</u></strong></center>
        </div>

        <div class="collapse show">
            <div class="card-body">
                <div class="table-responsive">
                    <h5>1. Matriks Keputusan</h5>
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Alternatif</th>
                                @foreach ($kriteria as $k)
                                    <th>{{ $k->nama_kriteria }} ({{ $k->attribut }})</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($alternatif as $key => $alt)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $alt->alternatif->nama_alternatif }}</td>
                                    @foreach ($kriteria as $k)
                                        @php
                                            $detailFound = false;
                                            $cripsValue = null;
                                            if ($alt->detailPenilaian) {
                                                foreach ($alt->detailPenilaian as $detail) {
                                                    if ($detail->kriteria_id == $k->id && $detail->crips) {
                                                        $cripsValue = $detail->crips->bobot;
                                                        $detailFound = true;
                                                        break;
                                                    }
                                                }
                                            }
                                        @endphp
                                        <td>{{ $detailFound ? $cripsValue : 'Tidak ada data' }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <h5>2. Matriks Ternormalisasi</h5>
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Alternatif / Kriteria</th>
                                @foreach ($kriteria as $k)
                                    <th>{{ $k->nama_kriteria }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($normalisasi as $key => $nilaiKriteria)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $key }}</td>
                                    @foreach ($kriteria as $k)
                                        <td>{{ number_format($nilaiKriteria[$k->id] ?? 0, 3) }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <h5>3. Hasil Perangkingan</h5>
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Ranking</th>
                                <th>Nama Alternatif</th>
                                <th>Total Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ranking as $alternatif => $nilai)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $alternatif }}</td>
                                    <td>{{ number_format($nilai, 3) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div style="width: 100%; margin-top: 100px;">
            <div id="ttd">
                <p id="camat">Banyuwangi, {{ date('d F Y') }}</p>
                <p id="camat"><strong> CAMAT WONGSOREJO </strong></p>
                <p id="nama-camat">
                    <strong><u>SUPARDI</u></strong><br />
                    NIP. 3175044408730004
                </p>
            </div>
        </div>
    </div>
</body>

</html>
