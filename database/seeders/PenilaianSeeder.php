<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Penilaian;
use App\Models\DetailPenilaian;
use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\Crips;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class PenilaianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Ambil semua alternatif
        $alternatifs = Alternatif::all();

        // Ambil semua kriteria
        $kriterias = Kriteria::all();

        // Ambil user dengan role admin untuk dijadikan penilai
        $admin = User::where('role', 'admin')->first();

        foreach ($alternatifs as $alternatif) {
            // Buat record penilaian
            $penilaian = Penilaian::create([
                'user_id' => $admin->id,
                'alternatif_id' => $alternatif->id,
                'nik' => $alternatif->nik,
                'total_nilai' => 0, // Akan diupdate setelah semua detail penilaian dibuat
                'created_at' => now(),
                'updated_at' => now()
            ]);

            $totalNilai = 0;
            foreach ($kriterias as $kriteria) {
                // Ambil crips untuk kriteria ini
                $crips = Crips::where('kriteria_id', $kriteria->id)->get();

                if ($crips->count() > 0) {
                    // Pilih crips secara random
                    $selectedCrips = $crips->random();

                    // Buat detail penilaian
                    DetailPenilaian::create([
                        'penilaian_id' => $penilaian->id,
                        'kriteria_id' => $kriteria->id,
                        'crips_id' => $selectedCrips->id,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);

                    // Tambahkan nilai ke total
                    $totalNilai += $selectedCrips->nilai;
                }
            }

            // Update total nilai penilaian
            $penilaian->update(['total_nilai' => $totalNilai]);
        }
    }
}
