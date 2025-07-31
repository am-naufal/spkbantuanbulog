<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Crips;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CripsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Menonaktifkan foreign key constraints sementara
        Schema::disableForeignKeyConstraints();

        // Hapus data yang ada terlebih dahulu
        DB::table('crips')->truncate();

        // Mengaktifkan kembali foreign key constraints
        Schema::enableForeignKeyConstraints();

        // Data crips
        $crips = [
            [
                'id' => 1,
                'kriteria_id' => 1,
                'nama_crips' => '< Rp. 500.000',
                'bobot' => 5,
                'created_at' => '2025-05-09 14:58:35',
                'updated_at' => '2025-05-09 14:58:35'
            ],
            [
                'id' => 2,
                'kriteria_id' => 1,
                'nama_crips' => '< Rp. 1.000.000',
                'bobot' => 4,
                'created_at' => '2025-05-09 14:59:03',
                'updated_at' => '2025-05-09 14:59:03'
            ],
            [
                'id' => 3,
                'kriteria_id' => 1,
                'nama_crips' => '< Rp. 2.000.000',
                'bobot' => 3,
                'created_at' => '2025-05-09 14:59:23',
                'updated_at' => '2025-05-09 14:59:23'
            ],
            [
                'id' => 4,
                'kriteria_id' => 1,
                'nama_crips' => '< Rp. 3.000.000',
                'bobot' => 2,
                'created_at' => '2025-05-09 14:59:43',
                'updated_at' => '2025-05-09 14:59:43'
            ],
            [
                'id' => 5,
                'kriteria_id' => 1,
                'nama_crips' => 'Lebih > Rp. 3.000.000',
                'bobot' => 1,
                'created_at' => '2025-05-09 15:00:02',
                'updated_at' => '2025-05-09 15:00:02'
            ],
            [
                'id' => 6,
                'kriteria_id' => 2,
                'nama_crips' => '2 Orang',
                'bobot' => 1,
                'created_at' => '2025-05-09 15:01:11',
                'updated_at' => '2025-05-09 15:01:11'
            ],
            [
                'id' => 7,
                'kriteria_id' => 2,
                'nama_crips' => '3 Orang',
                'bobot' => 2,
                'created_at' => '2025-05-09 15:01:28',
                'updated_at' => '2025-05-09 15:01:28'
            ],
            [
                'id' => 8,
                'kriteria_id' => 2,
                'nama_crips' => '4 Orang',
                'bobot' => 3,
                'created_at' => '2025-05-09 15:01:43',
                'updated_at' => '2025-05-09 15:01:43'
            ],
            [
                'id' => 9,
                'kriteria_id' => 2,
                'nama_crips' => '5 Orang',
                'bobot' => 4,
                'created_at' => '2025-05-09 15:02:10',
                'updated_at' => '2025-05-09 15:02:10'
            ],
            [
                'id' => 10,
                'kriteria_id' => 2,
                'nama_crips' => '6 Orang atau Lebih',
                'bobot' => 5,
                'created_at' => '2025-05-09 15:02:27',
                'updated_at' => '2025-05-09 15:02:27'
            ],
            [
                'id' => 11,
                'kriteria_id' => 3,
                'nama_crips' => 'Sakit kronis/berat (tidak bisa bekerja)',
                'bobot' => 5,
                'created_at' => '2025-05-09 16:12:06',
                'updated_at' => '2025-05-09 16:12:06'
            ],
            [
                'id' => 12,
                'kriteria_id' => 3,
                'nama_crips' => 'Sering sakit, aktivitas terbatas',
                'bobot' => 4,
                'created_at' => '2025-05-09 16:12:25',
                'updated_at' => '2025-05-09 16:12:25'
            ],
            [
                'id' => 13,
                'kriteria_id' => 3,
                'nama_crips' => 'Sakit ringan (masih bisa bekerja)',
                'bobot' => 3,
                'created_at' => '2025-05-09 16:12:32',
                'updated_at' => '2025-05-09 16:12:32'
            ],
            [
                'id' => 14,
                'kriteria_id' => 3,
                'nama_crips' => 'Sehat namun usia lanjut (rentan)',
                'bobot' => 2,
                'created_at' => '2025-05-09 16:12:38',
                'updated_at' => '2025-05-09 16:12:38'
            ],
            [
                'id' => 15,
                'kriteria_id' => 3,
                'nama_crips' => 'Sehat dan produktif',
                'bobot' => 1,
                'created_at' => '2025-05-09 16:12:45',
                'updated_at' => '2025-05-09 16:12:45'
            ],
            [
                'id' => 16,
                'kriteria_id' => 4,
                'nama_crips' => 'Menumpang / Tinggal di tempat orang lain',
                'bobot' => 5,
                'created_at' => '2025-05-09 16:47:07',
                'updated_at' => '2025-05-09 16:47:07'
            ],
            [
                'id' => 17,
                'kriteria_id' => 4,
                'nama_crips' => 'Sewa Rumah atau kontrakan sederhana',
                'bobot' => 4,
                'created_at' => '2025-05-09 16:47:44',
                'updated_at' => '2025-05-09 16:47:44'
            ],
            [
                'id' => 18,
                'kriteria_id' => 4,
                'nama_crips' => 'Rumah tidak layak huni milik sendiri',
                'bobot' => 3,
                'created_at' => '2025-05-09 16:47:55',
                'updated_at' => '2025-05-09 16:47:55'
            ],
            [
                'id' => 19,
                'kriteria_id' => 4,
                'nama_crips' => 'Rumah layak huni milik sendiri',
                'bobot' => 2,
                'created_at' => '2025-05-09 16:48:07',
                'updated_at' => '2025-05-09 16:48:07'
            ],
            [
                'id' => 20,
                'kriteria_id' => 4,
                'nama_crips' => 'Rumah mewah milik sendiri',
                'bobot' => 1,
                'created_at' => '2025-05-09 16:48:11',
                'updated_at' => '2025-05-09 16:48:11'
            ],
            [
                'id' => 21,
                'kriteria_id' => 5,
                'nama_crips' => 'Tidak Punya Anak',
                'bobot' => 1,
                'created_at' => '2025-05-09 16:56:37',
                'updated_at' => '2025-05-09 16:56:37'
            ],
            [
                'id' => 22,
                'kriteria_id' => 5,
                'nama_crips' => '1 Tidak Sekolah',
                'bobot' => 2,
                'created_at' => '2025-05-09 16:57:10',
                'updated_at' => '2025-05-09 16:57:10'
            ],
            [
                'id' => 23,
                'kriteria_id' => 5,
                'nama_crips' => '2 Sekolah',
                'bobot' => 3,
                'created_at' => '2025-05-09 16:57:33',
                'updated_at' => '2025-05-09 16:57:33'
            ],
            [
                'id' => 24,
                'kriteria_id' => 5,
                'nama_crips' => '3 Sekolah',
                'bobot' => 4,
                'created_at' => '2025-05-09 16:58:20',
                'updated_at' => '2025-05-09 16:58:20'
            ],
            [
                'id' => 25,
                'kriteria_id' => 5,
                'nama_crips' => '4 Sekolah',
                'bobot' => 5,
                'created_at' => '2025-05-09 16:58:48',
                'updated_at' => '2025-05-09 16:58:48'
            ],
            [
                'id' => 26,
                'kriteria_id' => 6,
                'nama_crips' => 'Tidak Kerja',
                'bobot' => 1,
                'created_at' => '2025-05-09 17:00:19',
                'updated_at' => '2025-05-09 17:00:19'
            ],
            [
                'id' => 27,
                'kriteria_id' => 6,
                'nama_crips' => 'Buruh',
                'bobot' => 2,
                'created_at' => '2025-05-09 17:00:27',
                'updated_at' => '2025-05-09 17:00:27'
            ],
            [
                'id' => 28,
                'kriteria_id' => 6,
                'nama_crips' => 'Pekerja tidak tetap / serabutan',
                'bobot' => 2,
                'created_at' => '2025-05-09 17:01:39',
                'updated_at' => '2025-05-09 17:01:39'
            ],
            [
                'id' => 29,
                'kriteria_id' => 6,
                'nama_crips' => 'Buruh harian',
                'bobot' => 3,
                'created_at' => '2025-05-09 17:01:47',
                'updated_at' => '2025-05-09 17:01:47'
            ],
            [
                'id' => 30,
                'kriteria_id' => 6,
                'nama_crips' => 'Pekerja tetap swasta',
                'bobot' => 4,
                'created_at' => '2025-05-09 17:01:56',
                'updated_at' => '2025-05-09 17:01:56'
            ],
            [
                'id' => 31,
                'kriteria_id' => 6,
                'nama_crips' => 'Pegawai negeri / pegawai tetap',
                'bobot' => 5,
                'created_at' => '2025-05-09 17:02:09',
                'updated_at' => '2025-05-09 17:02:09'
            ],
            [
                'id' => 32,
                'kriteria_id' => 7,
                'nama_crips' => 'Tidak memiliki sumber daya tambahan',
                'bobot' => 1,
                'created_at' => '2025-05-09 17:03:26',
                'updated_at' => '2025-05-09 17:03:26'
            ],
            [
                'id' => 33,
                'kriteria_id' => 7,
                'nama_crips' => 'Memiliki satu aset kecil (misal sepeda, ayam)',
                'bobot' => 2,
                'created_at' => '2025-05-09 17:03:48',
                'updated_at' => '2025-05-09 17:03:48'
            ],
            [
                'id' => 34,
                'kriteria_id' => 7,
                'nama_crips' => 'Memiliki beberapa aset (motor, sawah kecil)',
                'bobot' => 3,
                'created_at' => '2025-05-09 17:04:02',
                'updated_at' => '2025-05-09 17:04:02'
            ],
            [
                'id' => 35,
                'kriteria_id' => 7,
                'nama_crips' => 'Memiliki usaha mikro atau tabungan > Rp1 juta',
                'bobot' => 4,
                'created_at' => '2025-05-09 17:04:05',
                'updated_at' => '2025-05-09 17:04:05'
            ],
            [
                'id' => 36,
                'kriteria_id' => 7,
                'nama_crips' => 'Memiliki usaha tetap, kendaraan & tanah produktif',
                'bobot' => 5,
                'created_at' => '2025-05-09 17:04:14',
                'updated_at' => '2025-05-09 17:04:19'
            ],
        ];

        // Masukkan data
        foreach ($crips as $item) {
            Crips::create($item);
        }
    }
}
