@extends('layouts.app')

@section('title', 'Tambah Penilaian')
@section('topbar', 'Tambah Penilaian')
@section('css')

    <!-- Custom styles for this page -->
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@stop
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Penilaian</h6>
        </div>



        <div class="card-body">

            <div class="form-group">
                <label for="nama_alternatif">Nama Alternatif</label>
                <input type="text" class="form-control" id="nama_alternatif" name="nama_alternatif"
                    value="{{ $alternatif->nama_alternatif }}" placeholder="Nama Alternatif">
            </div>
            <div class="form-group">
                <label for="nik">NIK</label>
                <input type="text" class="form-control" id="nik" name="nik" value="{{ $alternatif->nik }}"
                    placeholder="NIK">
            </div>
            <div class="form-group">
                <label for="alamat">Alamat</label>
                <input type="text" class="form-control" id="alamat" name="alamat" value="{{ $alternatif->alamat }}"
                    placeholder="Alamat">
            </div>
            <div class="form-group">
                <label for="telepon">Telepon</label>
                <input type="text" class="form-control" id="telepon" name="telepon" value="{{ $alternatif->telepon }}"
                    placeholder="Telepon">
            </div>


        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('penilaian.store') }}" method="POST">
                @csrf
                <div class="table-responsive">
                    <form action="{{ route('penilaian.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nama_alternatif">Nama Alternatif</label>
                            <input type="text" class="form-control" id="nama_alternatif" name="nama_alternatif"
                                placeholder="Nama Alternatif">
                        </div>
                        @foreach ($kriteria as $key => $value)
                            <div class="form-group">
                                <label for="crips_id">{{ $value->nama_kriteria }}</label>

                                <select name="crips_id[{{ $loop->iteration }}]" class="form-control">
                                    @foreach ($value->crips as $k_1 => $v_1)
                                        <option value="{{ $v_1->id }}">{{ $v_1->nama_crips }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endforeach
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>

            </form>
        </div>
    </div>
    </div>
@endsection
