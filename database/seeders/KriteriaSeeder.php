<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kriteria;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class KriteriaSeeder extends Seeder
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

        // Hapus data kriteria
        DB::table('kriteria')->truncate();

        // Mengaktifkan kembali foreign key constraints
        Schema::enableForeignKeyConstraints();

        // Data kriteria
        $kriteria = [
            [
                'id' => 1,
                'nama_kriteria' => 'Pendapatan Keluarga',
                'attribut' => 'Cost',
                'bobot' => 20,
                'created_at' => '2025-05-09 14:51:44',
                'updated_at' => '2025-05-09 14:51:44'
            ],
            [
                'id' => 2,
                'nama_kriteria' => 'Jumlah Anggota keluarga',
                'attribut' => 'Benefit',
                'bobot' => 15,
                'created_at' => '2025-05-09 14:52:02',
                'updated_at' => '2025-05-09 14:52:02'
            ],
            [
                'id' => 3,
                'nama_kriteria' => 'Kondisi Kesehatan',
                'attribut' => 'Benefit',
                'bobot' => 15,
                'created_at' => '2025-05-09 14:52:10',
                'updated_at' => '2025-05-09 14:52:10'
            ],
            [
                'id' => 4,
                'nama_kriteria' => 'Status Tempat Tinggal',
                'attribut' => 'Benefit',
                'bobot' => 15,
                'created_at' => '2025-05-09 14:52:21',
                'updated_at' => '2025-05-09 16:12:58'
            ],
            [
                'id' => 5,
                'nama_kriteria' => 'Keberlanjutan Pendidikan Anak',
                'attribut' => 'Benefit',
                'bobot' => 10,
                'created_at' => '2025-05-09 14:52:33',
                'updated_at' => '2025-05-09 14:52:33'
            ],
            [
                'id' => 6,
                'nama_kriteria' => 'Status Pekerjaan',
                'attribut' => 'Benefit',
                'bobot' => 15,
                'created_at' => '2025-05-09 14:52:44',
                'updated_at' => '2025-05-09 16:59:37'
            ],
            [
                'id' => 7,
                'nama_kriteria' => 'Akses Sumber Daya lain',
                'attribut' => 'Benefit',
                'bobot' => 10,
                'created_at' => '2025-05-09 14:52:55',
                'updated_at' => '2025-05-09 14:52:55'
            ],
        ];

        // Masukkan data
        foreach ($kriteria as $item) {
            Kriteria::create($item);
        }
    }
}
