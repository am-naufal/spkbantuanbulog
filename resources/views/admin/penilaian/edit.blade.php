@extends('layouts.app')
@section('title', 'SPK Penerima Bantuan')
@section('topbar', 'Edit Penilaian')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Edit Penilaian</h6>
                    </div>
                    <div class="card-body">
                        @if (Session::has('msg'))
                            <div class="alert alert-info alert-dismissible fade show" role="alert">
                                <strong>Info</strong> {{ Session::get('msg') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <form action="{{ route('penilaian.update', $penilaian->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group row">
                                <label for="alternatif_id" class="col-sm-2 col-form-label">Nama Alternatif</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="nama" name="nama"
                                        placeholder="Masukkan Nama" value="{{ $penilaian->alternatif->nama_alternatif }}"
                                        disabled>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="nik" class="col-sm-2 col-form-label">NIK</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="nik" name="nik"
                                        placeholder="Masukkan NIK" value="{{ $penilaian->alternatif->nik }}" disabled>
                                </div>
                            </div>

                            <hr>
                            <h5 class="mb-3">Penilaian Kriteria</h5>

                            @foreach ($kriteria as $key => $k)
                                <input type="hidden" name="kriteria_id[]" value="{{ $k->id }}">
                                <div class="form-group row">
                                    <label for="kriteria{{ $k->id }}"
                                        class="col-sm-2 col-form-label">{{ $k->nama_kriteria }}</label>
                                    <div class="col-sm-10">
                                        <select name="crips_id[{{ $k->id }}]" id="kriteria{{ $k->id }}"
                                            class="form-control" required>
                                            <option value="">-- Pilih {{ $k->nama_kriteria }} --</option>
                                            @php
                                                $selectedCrips = null;
                                                foreach ($penilaian->detailPenilaian as $detail) {
                                                    if ($detail->kriteria_id == $k->id) {
                                                        $selectedCrips = $detail->crips_id;
                                                        break;
                                                    }
                                                }
                                            @endphp
                                            @foreach ($k->crips as $c)
                                                <option value="{{ $c->id }}"
                                                    {{ $selectedCrips == $c->id ? 'selected' : '' }}>
                                                    {{ $c->nama_crips }}
                                                </option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                            @endforeach

                            <div class="form-group row">
                                <div class="col-sm-10 offset-sm-2">
                                    <button type="submit" class="btn btn-primary">Perbarui Penilaian</button>
                                    <a href="{{ route('penilaian.index') }}" class="btn btn-secondary">Kembali</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
