@extends('layouts.app')

@section('judul', 'Dashboard User')

@section('content')
    <div class="row">

        <!-- Status Penilaian Card -->
        <div class=" font-weight-bold text-primary text-uppercase mb-1">
            {{ auth()->user()->role }}</div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Status Penilaian</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                @if ($statusPenilaian)
                                    <span class="badge badge-success">Sudah Dinilai</span>
                                @else
                                    <span class="badge badge-warning">Belum Dinilai</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hasil Penilaian Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Hasil Penilaian</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                @if ($hasilPenilaian)

                                    <!-- Status kelayakan berdasarkan nilai terbobot -->
                                    @if ($statusPenilaian)
                                        <span
                                            class="ml-1 badge {{ $totalNilaiNormalisasi >= 60 ? 'badge-success' : 'badge-danger' }}">
                                            {{ $totalNilaiNormalisasi >= 60 ? 'LAYAK (Nilai ≥ 60)' : 'TIDAK LAYAK (Nilai < 60)' }}
                                        </span>
                                    @endif
                                @else
                                    <span class="badge badge-secondary">Belum Ada</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-pie fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Nilai Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Nilai</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($totalNilai ?? 0, 2) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calculator fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Nilai Terbobot Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total Nilai Terbobot</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($totalNilaiNormalisasi ?? 0, 3) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-balance-scale fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Kelayakan Card -->
    @if ($statusPenilaian)
        <div class="row mb-4">
            <div class="col-12">
                <div
                    class="card shadow h-100 {{ $totalNilaiNormalisasi >= 60 ? 'border-left-success' : 'border-left-danger' }}">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div
                                    class="text-xs font-weight-bold {{ $totalNilaiNormalisasi >= 60 ? 'text-success' : 'text-danger' }} text-uppercase mb-1">
                                    Status Kelayakan</div>
                                <div class="h4 mb-0 font-weight-bold text-gray-800">
                                    @if ($totalNilaiNormalisasi >= 60)
                                        <span class="badge badge-success">LAYAK</span>
                                        <span class="ml-2">Anda memenuhi kriteria untuk menerima bantuan</span>
                                    @else
                                        <span class="badge badge-danger">TIDAK LAYAK</span>
                                        <span class="ml-2">Maaf, Anda belum memenuhi kriteria untuk menerima
                                            bantuan</span>
                                    @endif
                                </div>
                                <div class="mt-2 small text-muted">
                                    Batas minimum nilai kelayakan adalah 60. Nilai terbobot Anda:
                                    {{ number_format($totalNilaiNormalisasi ?? 0, 3) }}
                                </div>
                            </div>
                            <div class="col-auto">
                                @if ($totalNilaiNormalisasi >= 60)
                                    <i class="fas fa-check-circle fa-3x text-success"></i>
                                @else
                                    <i class="fas fa-times-circle fa-3x text-danger"></i>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Normalisasi Penilaian -->
    @if (isset($normalisasiData) && count($normalisasiData) > 0)
        <div class="row">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Normalisasi Penilaian (Metode SAW)</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Kriteria</th>
                                        <th>Attribut</th>
                                        <th>Nilai Asli</th>
                                        <th>Nilai Normalisasi</th>
                                        <th>Bobot Kriteria</th>
                                        <th>Nilai Terbobot</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($normalisasiData as $normalisasi)
                                        <tr>
                                            <td>{{ $normalisasi['nama_kriteria'] }}</td>
                                            <td>{{ $normalisasi['attribut'] }}</td>
                                            <td>{{ $normalisasi['nilai_asli'] }}</td>
                                            <td>{{ number_format($normalisasi['nilai_normalisasi'], 3) }}</td>
                                            <td>{{ $normalisasi['bobot_kriteria'] }}</td>
                                            <td>{{ number_format($normalisasi['nilai_bobot'], 3) }}</td>
                                        </tr>
                                    @endforeach
                                    <tr class="bg-light">
                                        <td colspan="5" class="text-right font-weight-bold">Total Nilai Terbobot:</td>
                                        <td class="font-weight-bold">{{ number_format($totalNilaiNormalisasi, 3) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            <h5>Penjelasan Metode SAW</h5>
                            <p>
                                Metode SAW (Simple Additive Weighting) adalah metode penjumlahan terbobot yang digunakan
                                dalam sistem pendukung keputusan ini. Berikut tahapan perhitungannya:
                            </p>
                            <ol>
                                <li><strong>Tahap Analisa</strong> - Pengumpulan data nilai dari setiap kriteria</li>
                                <li><strong>Tahap Normalisasi</strong> - Nilai diubah menjadi skala 0-1 dengan rumus:
                                    <ul>
                                        <li>Jika kriteria benefit (makin tinggi makin baik): <code>nilai / nilai maksimum
                                                dari kriteria</code></li>
                                        <li>Jika kriteria cost (makin rendah makin baik): <code>nilai minimum dari kriteria
                                                / nilai</code></li>
                                    </ul>
                                </li>
                                <li><strong>Tahap Perangkingan</strong> - Nilai ternormalisasi dikalikan dengan bobot
                                    kriteria, kemudian dijumlahkan untuk mendapatkan nilai akhir.</li>
                            </ol>
                            <p>
                                Total nilai terbobot ini menjadi dasar keputusan kelayakan penerima bantuan.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if (!$alternatif)
        <div class="row">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="text-center">
                            <h5 class="text-primary">Silahkan Isi Form Pengajuan</h5>
                            <form action="{{ route('alternatifuser.create') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary">Isi Form Pengajuan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- @elseif ($alternatif)
        <div class="row">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="text-center">
                            <h5 class="text-primary">Data Anda Sedang Diajukan</h5>
                            <p>Data Anda sedang dalam proses penilaian. Silakan tunggu hingga proses selesai.</p>
                            <a href="{{ route('alternatif.edit', ['id' => $alternatif->id]) }}"
                                class="btn btn-warning">Tinjau Ulang Data</a>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
    @endif


@endsection
