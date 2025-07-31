@extends('layouts.app')
@section('title', 'SPK Penerima Bantuan')
@section('topbar', 'Data Alternatif')
@section('css')

    <!-- Custom styles for this page -->
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@stop
@section('content')



    <div class="row">
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <!-- Card Header - Accordion -->
                <a href="#tambahalternatif" class="d-block card-header py-3" data-toggle="collapse" role="button"
                    aria-expanded="true" aria-controls="collapseCardExample">
                    <h6 class="m-0 font-weight-bold text-primary">Tambah Data Warga</h6>
                </a>

                <!-- Card Content - Collapse -->
                <div class="collapse show" id="tambahalternatif">
                    <div class="card-body">
                        @if (Session::has('msg'))
                            <div class="alert alert-info alert-dismissible fade show" role="alert">
                                <strong>Infor</strong> {{ Session::get('msg') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <form action="{{ route('alternatif.store') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="nama">Nama Warga</label>
                                {{-- Ini Select2 untuk pencarian --}}
                                <select id="select_warga" class="form-control"></select>

                                {{-- Ini yang akan disubmit: nama warga --}}
                                <input type="hidden" name="nama_alternatif" id="nama_alternatif">
                                @error('nama_alternatif')
                                    <div class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="nama">NIK</label>
                                <input type="number" class="form-control @error('nik') is-invalid @enderror" name="nik"
                                    id="nik" value="{{ old('nik') }}">

                                @error('nik')
                                    <div class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                            <div class="form-group">
                                <label for="nama">Alamat</label>
                                <input type="text" class="form-control @error('alamat') is-invalid @enderror"
                                    name="alamat" id="alamat" value="{{ old('alamat') }}">

                                @error('alamat')
                                    <div class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>
                            <div class="form-group">
                                <label for="nama">Telepon</label>
                                <input type="text" class="form-control @error('telepon') is-invalid @enderror"
                                    name="telepon" id="telepon" value="{{ old('telepon') }}">

                                @error('telepon')
                                    <div class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>
                            <button class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow mb-4">
                <!-- Card Header - Accordion -->
                <a href="#listkriteria" class="d-block card-header py-3" data-toggle="collapse" role="button"
                    aria-expanded="true" aria-controls="collapseCardExample">
                    <h6 class="m-0 font-weight-bold text-primary">List Warga</h6>
                </a>

                <!-- Card Content - Collapse -->
                <div class="collapse show" id="listkriteria">
                    <div class="card-body">
                        <div class="table-responsive">
                            <a href="{{ URL::to('download-alternatif-pdf') }}" target="_blank"
                                class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm float-left"><i
                                    class="fas fa-download fa-sm text-white-50"></i>Download Laporan</a>
                            <table class="table table-striped table-hover" id="DataTable" data-paging="false">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Warga</th>
                                        <th>NIK</th>
                                        <th>Alamat</th>
                                        <th>Telepon</th>
                                        <th>Aksi</th>

                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($data as $row)
                                        <tr>
                                            <td> {{ $loop->iteration }}</td>
                                            <td>{{ $row->nama_alternatif }}</td>
                                            <td>{{ $row->nik }}</td>
                                            <td>{{ $row->alamat }}</td>
                                            <td>{{ $row->telepon }}</td>
                                            <td>
                                                <a href="{{ route('alternatif.edit', $row->id) }}"
                                                    class="btn btn-sm btn-circle btn-warning">
                                                    <i class="fa fa-edit"></i>
                                                </a>

                                                <a href="{{ route('alternatif.destroy', $row->id) }}"
                                                    class="btn btn-sm btn-circle btn-danger hapus">
                                                    <i class="fa fa-trash"></i>
                                                </a>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-end">
                                {{ $data->links() }}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
@section('js')

    <!-- Page level plugins -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#DataTable').DataTable();

            $('.hapus').on('click', function() {
                swal({
                        title: "Apa anda yakin?",
                        text: "Sekali anda menghapus data, data tidak dapat dikembalikan lagi!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                url: $(this).attr('href'),
                                type: 'DELETE',
                                data: {
                                    '_token': "{{ csrf_token() }}"
                                },
                                success: function() {
                                    swal("Data berhasil dihapus!", {
                                        icon: "success",
                                    }).then((willDelete) => {
                                        window.location =
                                            "{{ route('alternatif.index') }}"
                                    });
                                }
                            })
                        } else {
                            swal("Data Aman!");
                        }
                    });

                return false;
            });

            $('#select_warga').select2({
                placeholder: 'Cari Nama Warga...',
                allowClear: true,
                ajax: {
                    url: '{{ route('ajax.cari.alternatif') }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    id: item.id, // untuk AJAX dan fetch detail
                                    text: item.name + ' (' +
                                        item.nik + ')' // yang ditampilkan di dropdown
                                }
                            })
                        };
                    },
                    cache: true
                }
            });

            // Saat dipilih, ambil data dan set ke form
            $('#select_warga').on('select2:select', function(e) {
                const id = e.params.data.id;
                const nama = e.params.data.text;

                // Isi hidden input dengan nama
                $('#nama_alternatif').val(nama);

                // Ambil data lengkap berdasarkan ID
                $.ajax({
                    url: '/get-alternatif/' + id,
                    type: 'GET',
                    success: function(data) {
                        $('#nik').val(data.nik);
                        $('#alamat').val(data.alamat);
                        $('#telepon').val(data.telepon);
                    }
                });
            });

            // Reset data saat dikosongkan
            $('#select_warga').on('select2:clear', function() {
                $('#nama_alternatif, #nik, #alamat, #telepon').val('');
            });
        });
    </script>
@stop
