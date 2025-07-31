<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
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
            <center><strong><u>LIST CRIPS / SUB KRITERIA</u></strong></center>
        </div>

        <div class="collapse show" id="listkriteria">
            <div class="card-body">
                <div class="table-responsive">
                    <h6 class="m-0 font-weight-bold">Dari Kriteria : {{ $kriteria->nama_kriteria }}</h6>
                    <br><br>
                    <table class="table table-striped table-hover" id="DataTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Crips / Sub Kriteria</th>
                                <th>Bobot</th>

                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @foreach ($crips as $row)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $row->nama_crips }}</td>
                                    <td>{{ $row->bobot }}</td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div id="ttd" class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <p id="camat">Jakarta, {{ $tanggal }}</p>
                <p id="camat"><strong>KETUA RT 004 / RW 001</strong></p>
                <div id="nama-camat"><strong><u>AGUSTINA</u></strong><br />
                    NIP. 3175044408730004</div>
            </div>
        </div>
    </div>
</body>



</html>
