@extends('layouts.app')
@section('title', 'SPK Penerima Bantuan')
@section('topbar', 'Data Penilaian')
@section('content')

    <div class="card shadow mb-4">
        <!-- Card Header - Accordion -->
        <a href="#listkriteria" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true"
            aria-controls="collapseCardExample">
            <h6 class="m-0 font-weight-bold text-primary">Penilaian Alternatif</h6>
        </a>

        <div class="row p-3">
            <div class="col">
                <a href="{{ route('penilaian.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                    <i class="fas fa-plus fa-sm text-white-50"></i> Tambah
                </a>

                <a href="{{ route('penilaian.downloadPDF') }}" target="_blank"
                    class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm">
                    <i class="fas fa-download fa-sm text-white-50"></i> Download Laporan
                </a>
            </div>
        </div>

        <!-- Card Content - Collapse -->
        <div class="collapse show" id="listkriteria">
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

                @if (session('empty'))
                    <div class="alert alert-danger">
                        {{ session('empty') }}
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Alternatif</th>
                                <th>NIK</th>
                                @foreach ($kriteria as $k)
                                    <th>{{ $k->nama_kriteria }}</th>
                                @endforeach
                                <th>Total Nilai</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @dd($penilaians) --}}
                            @forelse ($penilaians as $index => $penilaian)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $penilaian->alternatif->nama_alternatif ?? 'Tidak ada data' }}</td>
                                    <td>{{ $penilaian->nik }}</td>

                                    @foreach ($kriteria as $k)
                                        <td>
                                            @php
                                                $detailFound = false;
                                            @endphp

                                            @foreach ($penilaian->detailPenilaian as $detail)
                                                @if ($detail->kriteria_id == $k->id)
                                                    {{ $detail->crips->nama_crips ?? 'Tidak ada data' }}
                                                    @php
                                                        $detailFound = true;
                                                    @endphp
                                                    @break
                                                @endif
                                            @endforeach

                                            @if (!$detailFound)
                                                Tidak ada data
                                            @endif
                                        </td>
                                    @endforeach

                                    <td>{{ $penilaian->total_nilai }}</td>
                                    <td>
                                        <a href="{{ route('penilaian.show', $penilaian->id) }}"
                                            class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('penilaian.edit', $penilaian->id) }}"
                                            class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('penilaian.calculate', $penilaian->id) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="fas fa-calculator"></i>
                                        </a>
                                        <form action="{{ route('penilaian.destroy', $penilaian->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Yakin akan menghapus data ini?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ 5 + count($kriteria) }}" class="text-center">Tidak ada data penilaian
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@stop
