<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Penilaian</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Alternatif</th>
                        <th>Pendapatan Keluarga</th>
                        <th>Jumlah Anggota Keluarga</th>
                        <th>Kondisi Kesehatan</th>
                        <th>Status Tempat Tinggal</th>
                        <th>Keberlanjutan Pendidikan Anak</th>
                        <th>Status Pekerjaan</th>
                        <th>Akses Sumber Daya Lain</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($penilaian as $penilaian)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $penilaian->alternatif->nama_alternatif }}</td>
                            <td>{{ $penilaian->pendapatan_keluarga }}</td>
                            <td>{{ $penilaian->jumlah_anggota_keluarga }}</td>
                            <td>{{ $penilaian->kondisi_kesehatan }}</td>
                            <td>{{ $penilaian->status_tempat_tinggal }}</td>
                            <td>{{ $penilaian->keberlanjutan_pendidikan_anak }}</td>
                            <td>{{ $penilaian->status_pekerjaan }}</td>
                            <td>{{ $penilaian->akses_sumber_dayalain }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
