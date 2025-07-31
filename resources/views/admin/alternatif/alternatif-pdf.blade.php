<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
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
            <center><strong><u>LIST WARGA</u></strong></center>
        </div>

        <div class="collapse show" id="listkriteria">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="DataTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Warga</th>
                                <th>NIK</th>
                                <th>Alamat</th>
                                <th>Telepon</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @foreach ($alternatif as $row)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $row->nama_alternatif }}</td>
                                    <td>{{ $row->nik }}</td>
                                    <td>{{ $row->alamat }}</td>
                                    <td>{{ $row->telepon }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div id="ttd" class="row">
            <div class="col-md-4"></div>
            <div id="ttd">
                <p id="camat">Banyuwangi, {{ $tanggal }}</p>
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
