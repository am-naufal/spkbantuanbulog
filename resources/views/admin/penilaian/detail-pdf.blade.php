<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detail Penilaian</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style type="text/css">
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
            <center><strong><u>DETAIL PENILAIAN ALTERNATIF</u></strong></center>
        </div>

        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title">Informasi Alternatif</h6>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <th>Nama Alternatif</th>
                                <td>: {{ $penilaian->alternatif->nama_alternatif ?? 'Tidak ada data' }}</td>
                            </tr>
                            <tr>
                                <th>NIK</th>
                                <td>: {{ $penilaian->nik ?? 'Tidak ada data' }}</td>
                            </tr>
                            <tr>
                                <th>Total Nilai</th>
                                <td>: {{ $penilaian->total_nilai }}</td>
                            </tr>
                            <tr>
                                <th>Dinilai Oleh</th>
                                <td>: {{ $penilaian->user->name ?? 'Tidak ada data' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <h6 class="font-weight-bold mb-3">Detail Kriteria dan Nilai</h6>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kriteria</th>
                        <th>Bobot Kriteria</th>
                        <th>Nilai (Crips)</th>
                        <th>Bobot Nilai</th>
                        <th>Hasil</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($penilaian->detailPenilaian as $index => $detail)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $detail->kriteria->nama_kriteria ?? 'Tidak ada data' }}</td>
                            <td>{{ $detail->kriteria->bobot ?? '0' }}</td>
                            <td>{{ $detail->crips->nama_crips ?? 'Tidak ada data' }}</td>
                            <td>{{ $detail->crips->bobot ?? '0' }}</td>
                            <td>
                                @if ($detail->kriteria && $detail->crips)
                                    {{ $detail->kriteria->bobot * $detail->crips->bobot }}
                                @else
                                    0
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data detail penilaian</td>
                        </tr>
                    @endforelse
                    <tr class="bg-light font-weight-bold">
                        <td colspan="5" class="text-right">Total Nilai:</td>
                        <td>{{ $penilaian->total_nilai }}</td>
                    </tr>
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
</body>

</html>
