@extends('layouts.app')
@section('title', 'SPK Penerima Bantuan')
@section('topbar', 'Data Penilaian')
@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Tambah Penilaian</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('penilaian.store') }}" method="POST">
                            @csrf

                            <div class="form-group row">
                                <label for="alternatif_id" class="col-sm-2 col-form-label">Pilih Alternatif</label>
                                <div class="col-sm-10">
                                    <select name="alternatif_id" id="alternatif_id" class="form-control" required>
                                        <option value="">-- Pilih Alternatif --</option>
                                        @foreach ($alternatif as $alt)
                                            <option value="{{ $alt->id }}">{{ $alt->nama_alternatif }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="nik" class="col-sm-2 col-form-label">NIK</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="nik" name="nik"
                                        placeholder="Masukkan NIK">
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
                                        <select name="crips_id[{{ $k->id }}][]" id="kriteria{{ $k->id }}"
                                            class="form-control" required>
                                            <option value="">-- Pilih {{ $k->nama_kriteria }} --</option>
                                            @foreach ($k->crips as $c)
                                                <option value="{{ $c->id }}">{{ $c->nama_crips }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endforeach

                            <div class="form-group row">
                                <div class="col-sm-10 offset-sm-2">
                                    <button type="submit" class="btn btn-primary">Simpan Penilaian</button>
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
