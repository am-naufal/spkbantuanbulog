@extends('layouts.app')
@section('title', 'Data Admin')
@section('topbar', 'Data Admin')
@section('css')

    <!-- Custom styles for this page -->
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection
@section('content')

    @if (Session::has('msg'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Sukses!</strong> {{ Session::get('msg') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Admin</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <a href="{{ route('user.create') }}" class="btn btn-primary mb-3">
                    <i class="fas fa-plus"></i> Tambah User
                </a>
                <table class="table table-bordered" id="dataTableAdmin" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>NIK</th>
                            <th>Alamat</th>
                            <th>Telepon</th>
                            <th>Role</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user as $key => $u)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $u->name }}</td>
                                <td>{{ $u->email }}</td>
                                <td>{{ $u->nik }}</td>
                                <td>{{ $u->alamat }}</td>
                                <td>{{ $u->telepon }}</td>
                                <td>{{ ucfirst($u->role) }}</td>
                                <td>{{ $u->keterangan }}</td>
                                <td>
                                    <a href="{{ route('user.edit', $u->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('user.destroy', $u->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
@section('js')

    <!-- Page level plugins -->
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#dataTableAdmin').DataTable();

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
                                            "{{ route('user.index') }}"
                                    });
                                }
                            })
                        } else {
                            swal("Data Aman!");
                        }
                    });

                return false;
            })
        })
    </script>

@endsection
