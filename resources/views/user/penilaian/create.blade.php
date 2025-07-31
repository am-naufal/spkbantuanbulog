@extends('layouts.app')

@section('title', 'Penilaian Bantuan')
@section('topbar', 'Form Penilaian')
@section('css')
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@stop
@section('content')
    @if (Session::has('msg'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> {{ Session::get('msg') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Alternatif</h6>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Nama Alternatif</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" value="{{ $alternatif->nama_alternatif }}" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">NIK</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" value="{{ $alternatif->nik }}" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Alamat</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" value="{{ $alternatif->alamat }}" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Telepon</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" value="{{ $alternatif->telepon }}" readonly>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Penilaian</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('penilaianuser.store') }}" method="POST">
                @csrf
                <input type="hidden" name="alternatif_id" value="{{ $alternatif->id }}">

                @foreach ($kriteria as $key => $k)
                    <input type="hidden" name="kriteria_id[]" value="{{ $k->id }}">
                    <div class="form-group row">
                        <label for="kriteria{{ $k->id }}"
                            class="col-sm-2 col-form-label">{{ $k->nama_kriteria }}</label>
                        <div class="col-sm-10">
                            <select name="crips_id[{{ $k->id }}]" id="kriteria{{ $k->id }}"
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
                        <a href="{{ route('userDashboard') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
