<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\WargaTerpilih;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PDF;

class LaporanController extends Controller
{
    public function downloadPDF()
    {
        $kriteria = Kriteria::all();
        $alternatif = Alternatif::with(['penilaian.detailPenilaian.crips'])->get();

        // Hitung normalisasi
        $normalisasi = [];
        foreach ($alternatif as $alt) {
            $normalisasi[$alt->nama_alternatif] = [];
            foreach ($kriteria as $k) {
                $nilai = 0;
                if (isset($alt->penilaian[0])) {
                    foreach ($alt->penilaian[0]->detailPenilaian as $detail) {
                        if ($detail->kriteria_id == $k->id && $detail->crips) {
                            $nilai = $detail->crips->bobot;
                            break;
                        }
                    }
                }
                $normalisasi[$alt->nama_alternatif][$k->id] = $nilai;
            }
        }

        // Hitung perangkingan
        $ranking = [];
        foreach ($normalisasi as $alt => $nilaiKriteria) {
            $total = 0;
            foreach ($kriteria as $k) {
                $total += ($nilaiKriteria[$k->id] ?? 0) * $k->bobot;
            }
            $ranking[$alt] = $total;
        }
        arsort($ranking);

        $pdf = PDF::loadView('admin.perhitungan.laporan', [
            'kriteria' => $kriteria,
            'alternatif' => $alternatif,
            'normalisasi' => $normalisasi,
            'ranking' => $ranking
        ]);

        return $pdf->download('laporan-perhitungan-saw.pdf');
    }

    public function downloadPDFTerpilih()
    {
        $wargaTerpilih = WargaTerpilih::all();




        return view('admin.report.terpilih', compact('wargaTerpilih'));
    }
    public function hitungSAW()
    {

        $alternatif = Alternatif::with(['penilaian.detailPenilaian.kriteria', 'penilaian.detailPenilaian.crips'])->get();
        $kriteria = Kriteria::with('crips')->orderBy('nama_kriteria', 'ASC')->get();
        $penilaians = Penilaian::with(['alternatif', 'detailPenilaian.kriteria', 'detailPenilaian.crips'])->get();

        if ($penilaians->isEmpty()) {
            throw new \Exception('Data kosong, silahkan isi terlebih dahulu');
        }

        $minMax = [];
        $normalisasi = [];
        $ranking = [];

        foreach ($kriteria as $k) {
            $minMax[$k->id] = [];
            foreach ($penilaians as $p) {
                foreach ($p->detailPenilaian as $detail) {
                    if ($detail->kriteria_id == $k->id && $detail->crips) {
                        $minMax[$k->id][] = $detail->crips->bobot;
                    }
                }
            }
        }

        foreach ($penilaians as $p) {
            if (!$p->alternatif) continue;

            $nama = $p->alternatif->nama_alternatif;
            $normalisasi[$nama] = [];

            foreach ($kriteria as $k) {
                $detailFound = false;

                foreach ($p->detailPenilaian as $detail) {
                    if ($detail->kriteria_id == $k->id && $detail->crips) {
                        $bobot = $detail->crips->bobot;

                        if (!empty($minMax[$k->id])) {
                            $max = max($minMax[$k->id]);
                            $min = min($minMax[$k->id]);

                            if ($k->attribut == 'Benefit') {
                                $normalisasi[$nama][$k->id] = $bobot / $max;
                            } else {
                                $normalisasi[$nama][$k->id] = $min / $bobot;
                            }

                            $detailFound = true;
                        }
                        break;
                    }
                }

                if (!$detailFound) {
                    $normalisasi[$nama][$k->id] = 0;
                }
            }
        }

        foreach ($normalisasi as $nama => $nilaiPerKriteria) {
            $total = 0;
            foreach ($kriteria as $k) {
                if (isset($nilaiPerKriteria[$k->id])) {
                    $total += $nilaiPerKriteria[$k->id] * $k->bobot;
                }
            }
            $ranking[$nama] = $total;
        }

        return collect($ranking)->sortDesc()->toArray(); // return hasil perhitungan
    }

    public function wargaTerpilih()
    {


        $alternatif = Alternatif::with(['penilaian.detailPenilaian.kriteria', 'penilaian.detailPenilaian.crips'])->get();
        $kriteria = Kriteria::with('crips')->orderBy('nama_kriteria', 'ASC')->get();
        $penilaians = Penilaian::with(['alternatif', 'detailPenilaian.kriteria', 'detailPenilaian.crips'])->get();

        if ($penilaians->isEmpty()) {
            throw new \Exception('Data penilaian kosong, silahkan isi terlebih dahulu.');
        }

        $minMax = [];
        foreach ($kriteria as $k) {
            $minMax[$k->id] = [];
            foreach ($penilaians as $p) {
                foreach ($p->detailPenilaian as $detail) {
                    if ($detail->kriteria_id == $k->id && $detail->crips) {
                        $minMax[$k->id][] = $detail->crips->bobot;
                    }
                }
            }
        }

        $normalisasi = [];
        foreach ($penilaians as $p) {
            if (!$p->alternatif) continue;
            $nama = $p->alternatif->nama_alternatif;
            $normalisasi[$nama] = [];

            foreach ($kriteria as $k) {
                $detailFound = false;
                foreach ($p->detailPenilaian as $detail) {
                    if ($detail->kriteria_id == $k->id && $detail->crips) {
                        $bobot = $detail->crips->bobot;

                        if (!empty($minMax[$k->id])) {
                            $max = max($minMax[$k->id]);
                            $min = min($minMax[$k->id]);

                            if ($k->attribut == 'Benefit') {
                                $normalisasi[$nama][$k->id] = $bobot / $max;
                            } else { // Cost
                                $normalisasi[$nama][$k->id] = $min / $bobot;
                            }
                            $detailFound = true;
                        }
                        break;
                    }
                }
                if (!$detailFound) {
                    $normalisasi[$nama][$k->id] = 0;
                }
            }
        }

        $ranking = [];
        foreach ($normalisasi as $nama => $nilaiPerKriteria) {
            $total = 0;
            foreach ($kriteria as $k) {
                if (isset($nilaiPerKriteria[$k->id])) {
                    $total += $nilaiPerKriteria[$k->id] * $k->bobot;
                }
            }
            $ranking[$nama] = $total;
        }

        $sortedData = collect($ranking)->sortDesc()->toArray();


        if (empty($sortedData)) {
            return response()->json([
                'status' => 'info',
                'message' => 'Hasil perhitungan SAW kosong, tidak ada warga terpilih yang disimpan.'
            ], 200);
        }


        WargaTerpilih::truncate();
        $rankingPosisi = 1;

        foreach ($sortedData as $nama => $nilai) {
            if ($nilai >= 60) { // Kriteria nilai minimal 60
                $alternatif = Alternatif::where('nama_alternatif', $nama)->first();

                if ($alternatif) {
                    WargaTerpilih::create([
                        'alternatif_id' => $alternatif->id,
                        'ranking' => $rankingPosisi++,
                        'total_nilai' => $nilai,
                    ]);
                }
            }
        }

        $wargaTerpilih = WargaTerpilih::with('alternatif')->orderBy('ranking')->get();
        return view('admin.report.terpilih', compact('wargaTerpilih'))->with('msg', 'Terjadi kesalahan: ');
    }
}
