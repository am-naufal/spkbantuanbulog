@extends('layouts.app')
@section('title', 'SPK Penerima Bantuan')
@section('topbar', 'Data Perhitungan Metode SAW')
@section('content')

    <div class="mb-4">
        <div class="row">
            <div class="col">
                <a href="{{ URL::to('download-perhitungan-pdf') }}" target="_blank"
                    class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm float-right">
                    <i class="fas fa-download fa-sm text-white-50"></i> Download Laporan
                </a>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <a href="#tahapAnalisa" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true"
            aria-controls="collapseCardExample">
            <h6 class="m-0 font-weight-bold text-primary">Tahap Analisa (Matriks Keputusan)</h6>
        </a>

        <div class="collapse show" id="tahapAnalisa">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nama Alternatif</th>
                                @foreach ($kriteria as $k)
                                    <th>{{ $k->nama_kriteria }} ({{ $k->attribut }})</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($alternatif as $alt)
                                <tr>
                                    <td>{{ $alt->nama_alternatif }}</td>
                                    @if (count($alt->penilaian) > 0)
                                        @foreach ($kriteria as $k)
                                            @php
                                                $detailFound = false;
                                                $cripsValue = null;

                                                // Cari detail penilaian yang sesuai dengan kriteria ini
                                                if (isset($alt->penilaian[0])) {
                                                    foreach ($alt->penilaian[0]->detailPenilaian as $detail) {
                                                        if ($detail->kriteria_id == $k->id && $detail->crips) {
                                                            $cripsValue = $detail->crips->bobot;
                                                            $detailFound = true;
                                                            break;
                                                        }
                                                    }
                                                }
                                            @endphp

                                            <td>
                                                @if ($detailFound)
                                                    {{ $cripsValue }}
                                                @else
                                                    Tidak ada data
                                                @endif
                                            </td>
                                        @endforeach
                                    @else
                                        @foreach ($kriteria as $k)
                                            <td>Tidak ada data</td>
                                        @endforeach
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ count($kriteria) + 1 }}">Tidak ada data alternatif!</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <a href="#tahapNormalisasi" class="d-block card-header py-3" data-toggle="collapse" role="button"
            aria-expanded="true" aria-controls="collapseCardExample">
            <h6 class="m-0 font-weight-bold text-primary">Tahap Normalisasi (Matriks Ternormalisasi)</h6>
        </a>

        <div class="collapse show" id="tahapNormalisasi">
            <div class="card-body">
                <div class="table-responsive">
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
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <a href="#tahapRanking" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true"
            aria-controls="collapseCardExample">
            <h6 class="m-0 font-weight-bold text-primary">Tahap Perangkingan</h6>
        </a>

        <div class="collapse show" id="tahapRanking">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Ranking</th>
                                <th>Nama Alternatif</th>
                                <th>Total Nilai</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @foreach ($sortedData as $alternatif => $nilai)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $alternatif }}</td>
                                    <td>{{ number_format($nilai, 3) }}</td>
                                    <td>{{ $nilai >= 60 ? 'Terpilih' : 'Tidak Terpilih' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <a href="#penjelasanSAW" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true"
            aria-controls="collapseCardExample">
            <h6 class="m-0 font-weight-bold text-primary">Penjelasan Metode SAW</h6>
        </a>

        <div class="collapse show" id="penjelasanSAW">
            <div class="card-body">
                <h5>Metode Simple Additive Weighting (SAW)</h5>
                <p>
                    Metode SAW atau Simple Additive Weighting adalah metode penjumlahan terbobot. Konsep dasar metode SAW
                    adalah mencari
                    penjumlahan terbobot dari rating kinerja pada setiap alternatif pada semua atribut. Tahapan dari metode
                    SAW adalah:
                </p>
                <ol>
                    <li><strong>Tahap Analisa (Matriks Keputusan)</strong> - Menentukan alternatif dan kriteria yang akan
                        digunakan beserta bobotnya.</li>
                    <li><strong>Tahap Normalisasi</strong> - Normalisasi matriks keputusan dengan cara:
                        <ul>
                            <li>Jika kriteria benefit: <code>nilai / nilai maksimum dari kriteria</code></li>
                            <li>Jika kriteria cost: <code>nilai minimum dari kriteria / nilai</code></li>
                        </ul>
                    </li>
                    <li><strong>Tahap Perangkingan</strong> - Menghitung nilai preferensi untuk setiap alternatif dengan
                        menjumlahkan hasil kali antara nilai ternormalisasi dengan bobot kriteria.</li>
                </ol>
                <p>
                    Alternatif dengan nilai tertinggi menjadi rekomendasi terbaik.
                </p>
            </div>
        </div>
    </div>
@stop
