@extends('layouts.app')

@section('title', 'SPK Penerima Bantuan')
@section('topbar', 'Penerima')
@section('css')
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <!-- DataTables Buttons CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
    <style>
        .dataTables_wrapper .dt-buttons {
            margin-bottom: 20px;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="card shadow mt-4">
            <div class="card-header bg-primary text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Data Warga Terpilih</h4>
                </div>
            </div>

            <div class="card-body">
                @if (Session::has('msg'))
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <strong>Info</strong> {{ Session::get('msg') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('empty'))
                    <div class="alert alx`ert-danger alert-dismissible fade show" role="alert">
                        {{ session('empty') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table id="wargaTerpilihTable" class="table table-striped table-hover w-100">
                        <thead class="table-primary">
                            <tr>
                                <th>No</th>
                                <th>NIK</th>
                                <th>Nama Alternatif</th>
                                <th>NO.Handphone</th>
                                <th>Ranking</th>
                                <th>Total Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($wargaTerpilih as $index => $data)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $data->alternatif->nik ?? '-' }}</td>
                                    <td>{{ $data->alternatif->nama_alternatif ?? '-' }}</td>
                                    <td>{{ $data->alternatif->telepon ?? '-' }}</td>
                                    <td>{{ $data->ranking }}</td>
                                    <td>{{ number_format($data->total_nilai, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Belum ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <!-- DataTables Buttons -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <!-- Font Awesome untuk icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            // Inisialisasi DataTable dengan fitur export
            var table = $('#wargaTerpilihTable').DataTable({
                dom: 'Bfrtip',
                buttons: ['copy', 'csv', 'excel', {
                    extend: 'pdfHtml5', // Ini adalah tombol PDF yang akan kita kustomisasi
                    text: 'PDF', // Anda bisa mengubah teks tombol
                    title: 'Data Warga Terpilih SPK', // Judul dokumen PDF
                    orientation: 'portrait', // 'portrait' atau 'landscape'
                    pageSize: 'A4', // Ukuran halaman: 'A3', 'A4', 'A5', 'LEGAL', 'LETTER', 'TABLOID'
                    exportOptions: {
                        columns: [0, 1, 2,
                            3
                        ] // Kolom yang akan diekspor (No, Nama Alternatif, Ranking, Total Nilai)
                    },
                    customize: function(doc) {
                        // --- Contoh Kustomisasi ---
                        doc.content[1].table.widths = ['10%', '40%', '20%',
                            '30%'
                        ]; // Contoh: No, Nama, Ranking, Total Nilai
                        // Menambahkan layout untuk garis vertikal
                        doc.content.splice(0,
                            0, { // Menambahkan di awal dokumen (indeks 0)
                                text: 'Laporan Data Warga Terpilih Penerima Bantuan',
                                fontSize: 15,
                                alignment: 'center',
                                margin: [0, 0, 0,
                                    12
                                ] // [left, top, right, bottom]
                            });

                        doc.footer = function(currentPage, pageCount) {
                            return {
                                text: 'Halaman ' + currentPage.toString() +
                                    ' dari ' +
                                    pageCount,
                                alignment: 'center',
                                fontSize: 8,
                                margin: [0, 10, 0, 0]
                            };
                        };
                        doc.styles.tableHeader = {
                            fillColor: '#dedede', // Warna latar belakang header
                            color: 'black',
                            bold: true,
                            alignment: 'center' // Rata tengah teks header
                        };


                        doc.content.splice(1,
                            0, { // Menambahkan setelah header utama
                                text: 'Tanggal Cetak: ' + new Date()
                                    .toLocaleDateString(
                                        'id-ID'),
                                fontSize: 10,
                                alignment: 'right',
                                margin: [0, 0, 0, 8]
                            });
                    }
                }, 'print'],
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
                },
                responsive: true,
                pageLength: 50,
                lengthMenu: [5, 10, 25, 50, 100],
                order: [
                    [4, 'asc']
                ], // Default sorting by Ranking
                columnDefs: [{
                    orderable: false,
                    targets: [0] // Non-orderable untuk kolom No
                }]
            });

            // Tombol refresh
            $('#refreshBtn').click(function() {
                table.ajax.reload();
            });
        });
    </script>
@endsection
