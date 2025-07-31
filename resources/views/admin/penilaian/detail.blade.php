@extends('layouts.app')
@section('title', 'SPK Penerima Bantuan')
@section('topbar', 'Detail Penilaian')
@section('content')

    <div class="card shadow mb-4">
        <!-- Card Header - Accordion -->
        <a href="#detailPenilaian" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true"
            aria-controls="collapseCardExample">
            <h6 class="m-0 font-weight-bold text-primary">Detail Penilaian Alternatif</h6>
        </a>

        <div class="collapse show" id="detailPenilaian">
            <div class="card-body">
                @if (Session::has('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Berhasil!</strong> {{ Session::get('status') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if (Session::has('msg'))
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <strong>Info</strong> {{ Session::get('msg') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="row mb-4">
                    <div class="col-md-6">
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

                <div class="mt-3">
                    <a href="{{ route('penilaian.index') }}" class="btn btn-secondary">Kembali</a>
                    <a href="{{ route('penilaian.calculate', $penilaian->id) }}" class="btn btn-primary">
                        <i class="fas fa-calculator"></i> Hitung Ulang
                    </a>
                    <a href="{{ route('penilaian.downloadDetail', $penilaian->id) }}" class="btn btn-info">
                        <i class="fas fa-file-pdf"></i> Unduh PDF
                    </a>
                </div>
            </div>
        </div>
    </div>

@stop
