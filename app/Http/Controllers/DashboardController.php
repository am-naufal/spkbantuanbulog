<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\User;
use App\Models\WargaTerpilih;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function kepalaDesa()
    {
        $data = [
            'totalWarga' => Alternatif::count(),
            'totalPenerima' => WargaTerpilih::count(),
            'totalKriteria' => Kriteria::count(),
            'totalPenilaian' => Penilaian::count(),

        ];

        return view('dashboard.kepala-desa', $data);
    }

    public function user()
    {
        $userId = auth()->id();
        $penilaian = Penilaian::with(['detailPenilaian.kriteria', 'detailPenilaian.crips'])
            ->where('user_id', $userId)
            ->first();
        $nikUser = auth()->user()->nik;
        $alternatif = Alternatif::where('nik', $nikUser)->first();

        // Tampung data normalisasi
        $normalisasi = [];
        $normalisasiPerKriteria = [];
        $totalNilai = 0;

        if ($penilaian) {
            // Ambil semua kriteria
            $kriteria = Kriteria::with('crips')->orderBy('nama_kriteria', 'ASC')->get();

            // Ambil semua penilaian untuk mencari min/max per kriteria
            $allPenilaians = Penilaian::with(['detailPenilaian.kriteria', 'detailPenilaian.crips'])->get();

            // Kumpulkan data bobot per kriteria untuk min/max
            $minMax = [];
            foreach ($kriteria as $k) {
                $minMax[$k->id] = [];

                foreach ($allPenilaians as $p) {
                    foreach ($p->detailPenilaian as $detail) {
                        if ($detail->kriteria_id == $k->id && $detail->crips) {
                            $minMax[$k->id][] = $detail->crips->bobot;
                        }
                    }
                }
            }

            // Hitung normalisasi untuk penilaian user
            foreach ($kriteria as $k) {
                $detailFound = false;

                foreach ($penilaian->detailPenilaian as $detail) {
                    if ($detail->kriteria_id == $k->id && $detail->crips) {
                        $bobot = $detail->crips->bobot;

                        // Pastikan array tidak kosong untuk menghindari division by zero
                        if (!empty($minMax[$k->id])) {
                            $max = max($minMax[$k->id]);
                            $min = min($minMax[$k->id]);

                            // Normalisasi berdasarkan tipe kriteria
                            if ($k->attribut == 'Benefit') {
                                $normValue = $bobot / $max;
                            } else { // Cost
                                $normValue = $min / $bobot;
                            }

                            $nilaiBobot = $normValue * $k->bobot;
                            $normalisasiPerKriteria[] = [
                                'nama_kriteria' => $k->nama_kriteria,
                                'attribut' => $k->attribut,
                                'nilai_asli' => $bobot,
                                'nilai_normalisasi' => $normValue,
                                'bobot_kriteria' => $k->bobot,
                                'nilai_bobot' => $nilaiBobot
                            ];

                            $totalNilai += $nilaiBobot;
                            $detailFound = true;
                        }
                        break;
                    }
                }

                // Jika tidak ada detail penilaian untuk kriteria ini
                if (!$detailFound) {
                    $normalisasiPerKriteria[] = [
                        'nama_kriteria' => $k->nama_kriteria,
                        'attribut' => $k->attribut,
                        'nilai_asli' => 0,
                        'nilai_normalisasi' => 0,
                        'bobot_kriteria' => $k->bobot,
                        'nilai_bobot' => 0
                    ];
                }
            }
        }

        $data = [
            'alternatif' => $alternatif,
            'statusPenilaian' => $penilaian ? true : false,
            'hasilPenilaian' => $penilaian,
            'totalNilai' => $penilaian ? $penilaian->total_nilai : 0,
            'detailPenilaian' => $penilaian ? $penilaian->detailPenilaian : collect(),
            'normalisasiData' => $normalisasiPerKriteria,
            'totalNilaiNormalisasi' => $totalNilai,
            'statusKelayakan' => $totalNilai >= 60 ? 'layak' : 'tidak layak'
        ];

        return view('dashboard.user', $data);
    }

    public function admin()
    {
        $data = [
            'totalWarga' => Alternatif::count(),
            // 'totalPenerima' => Penilaian::where(')->count(),
            'totalKriteria' => Kriteria::count(),
            'totalPenilaian' => Penilaian::count(),
            'totalUser' => User::count(),
            'totalPenerima' => WargaTerpilih::count(),
        ];

        return view('dashboard.admin', $data);
    }
}
