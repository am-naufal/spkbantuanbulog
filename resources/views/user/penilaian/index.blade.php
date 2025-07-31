@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Data Penilaian</h1>
            <a href="{{ route('penilaianuser.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Penilaian
            </a>
        </div>

        <!-- Content Row -->
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Daftar Penilaian</h6>
                    </div>
                    <div class="card-body">
                        @if (isset($penilaians) && count($penilaians) > 0)
                            @foreach ($penilaians as $penilaian)
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h6 class="m-0 font-weight-bold text-primary">
                                            Penilaian: {{ $penilaian->alternatif->nama_alternatif ?? 'Tidak ada data' }}
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                                <table class="table">
                                                    <tr>
                                                        <th>Nama Alternatif</th>
                                                        <td>:
                                                            {{ $penilaian->alternatif->nama_alternatif ?? 'Tidak ada data' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>NIK</th>
                                                        <td>: {{ $penilaian->alternatif->nik ?? 'Tidak ada data' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Total Nilai</th>
                                                        <td>: {{ $penilaian->total_nilai ?? '0' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Tanggal Penilaian</th>
                                                        <td>: {{ $penilaian->created_at->format('d/m/Y H:i') }}</td>
                                                    </tr>
                                                </table>
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
                                                            <td>{{ $detail->kriteria->nama_kriteria ?? 'Tidak ada data' }}
                                                            </td>
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
                                                            <td colspan="6" class="text-center">Tidak ada data detail
                                                                penilaian</td>
                                                        </tr>
                                                    @endforelse
                                                    <tr class="bg-light font-weight-bold">
                                                        <td colspan="5" class="text-right">Total Nilai:</td>
                                                        <td>{{ $penilaian->total_nilai ?? '0' }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="alert alert-info">
                                Belum ada data penilaian. Silahkan tambahkan penilaian baru.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
