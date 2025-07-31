@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Hasil Perhitungan SAW</h1>
        </div>

        <!-- Content Row -->
        <div class="row">
            <!-- Tabel Normalisasi -->
            <div class="col-xl-12 col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Tabel Normalisasi</h6>
                    </div>
                    <div class="card-body">
                        @if (isset($normalisasi) && count($normalisasi) > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th rowspan="2" class="text-center align-middle">Alternatif</th>
                                            @foreach ($kriteria as $k)
                                                <th class="text-center">{{ $k->nama_kriteria }}</th>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            @foreach ($kriteria as $k)
                                                <th class="text-center">
                                                    <small>Bobot: {{ number_format($k->bobot, 2) }}</small>
                                                </th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($normalisasi as $nama => $nilai)
                                            <tr>
                                                <td>{{ $nama }}</td>
                                                @foreach ($kriteria as $k)
                                                    <td class="text-center">{{ number_format($nilai[$k->id] ?? 0, 4) }}</td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-info">
                                Belum ada data penilaian yang dapat dihitung.
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Hasil Akhir -->
            <div class="col-xl-12 col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Hasil Akhir Perhitungan</h6>
                    </div>
                    <div class="card-body">
                        @if (isset($sortedData) && count($sortedData) > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Ranking</th>
                                            <th>Nama</th>
                                            <th class="text-center">Nilai Akhir</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $rank = 1;
                                            $total = count($sortedData);
                                        @endphp
                                        @foreach ($sortedData as $nama => $nilai)
                                            <tr>
                                                <td class="text-center">{{ $rank }}</td>
                                                <td>{{ $nama }}</td>
                                                <td class="text-center">{{ number_format($nilai, 4) }}</td>
                                                <td class="text-center">
                                                    @if ($rank <= ceil($total * 0.3))
                                                        <span class="badge badge-success">Direkomendasikan</span>
                                                    @else
                                                        <span class="badge badge-secondary">Tidak Direkomendasikan</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @php $rank++; @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="alert alert-info mt-3">
                                <h6 class="alert-heading">Keterangan:</h6>
                                <p class="mb-0">
                                    - 30% teratas dari total peserta akan direkomendasikan untuk menerima bantuan<br>
                                    - Nilai akhir dihitung menggunakan metode SAW (Simple Additive Weighting)<br>
                                    - Semakin tinggi nilai akhir, semakin tinggi prioritas untuk menerima bantuan
                                </p>
                            </div>
                        @else
                            <div class="alert alert-info">
                                Belum ada data penilaian yang dapat dihitung.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .table th {
                background-color: #f8f9fc;
            }

            .badge {
                padding: 0.5em 1em;
            }
        </style>
    @endpush
@endsection
