<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\DetailPenilaian;
use App\Models\WargaTerpilih;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AlgoritmaController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index()
    {

        $alternatif = Alternatif::with(['penilaian.detailPenilaian.kriteria', 'penilaian.detailPenilaian.crips'])->get();
        $kriteria = Kriteria::with('crips')->orderBy('nama_kriteria', 'ASC')->get();
        $penilaians = Penilaian::with(['alternatif', 'detailPenilaian.kriteria', 'detailPenilaian.crips'])->get();

        if ($penilaians->isEmpty()) {
            return redirect()->route('penilaian.index')->with('empty', 'Data kosong, silahkan isi terlebih dahulu');
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
                $sortalternatif = Alternatif::where('nama_alternatif', $nama)->first();

                if ($sortalternatif) {
                    WargaTerpilih::create([
                        'alternatif_id' => $sortalternatif->id,
                        'ranking' => $rankingPosisi++,
                        'total_nilai' => $nilai,
                    ]);
                }
            }
        }

        $wargaTerpilih = WargaTerpilih::with('alternatif')->orderBy('ranking')->get();

        return view('admin.perhitungan.index', compact('alternatif', 'kriteria', 'normalisasi', 'sortedData', 'penilaians'));
    }

    public function downloadPDF()
    {
        try {
            $alternatif = Alternatif::with(['penilaian.detailPenilaian.kriteria', 'penilaian.detailPenilaian.crips'])->get();
            $kriteria = Kriteria::with('crips')->orderBy('nama_kriteria', 'ASC')->get();
            $penilaians = Penilaian::with(['alternatif', 'detailPenilaian.kriteria', 'detailPenilaian.crips'])->get();

            if ($penilaians->isEmpty()) {
                return redirect()->route('penilaian.index')->with('empty', 'Data kosong, silahkan isi terlebih dahulu');
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

            $sortedData = collect($ranking)->sortDesc()->toArray();

            // Simpan ke tabel warga_terpilih
            DB::beginTransaction();
            WargaTerpilih::truncate(); // hapus data lama

            $rankingPosisi = 1;
            foreach ($sortedData as $nama => $nilai) {
                $alternatif = Alternatif::where('nama_alternatif', $nama)->first();
                if ($alternatif) {
                    WargaTerpilih::create([
                        'alternatif_id' => $alternatif->id,
                        'ranking' => $rankingPosisi++,
                        'total_nilai' => $nilai,
                    ]);
                }
            }
            DB::commit();

            Log::info('Perhitungan SAW dan penyimpanan warga terpilih berhasil dilakukan');

            return view('admin.perhitungan.index', compact('alternatif', 'kriteria', 'normalisasi', 'sortedData', 'penilaians'));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error pada perhitungan SAW admin: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->route('penilaian.index')->with('msg', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function indexUser()
    {
        try {
            $userId = auth()->id();

            // Ambil data penilaian khusus user yang login
            $penilaians = Penilaian::with(['alternatif', 'detailPenilaian.kriteria', 'detailPenilaian.crips'])
                ->where('user_id', $userId)
                ->get();

            if ($penilaians->isEmpty()) {
                return redirect()->route('penilaianuser.create')->with('empty', 'Data kosong, silahkan isi penilaian terlebih dahulu');
            }

            $kriteria = Kriteria::with('crips')->orderBy('nama_kriteria', 'ASC')->get();
            $alternatif = Alternatif::whereIn('id', $penilaians->pluck('alternatif_id'))->get();

            $minMax = [];
            $normalisasi = [];
            $ranking = [];

            // Kumpulkan data bobot per kriteria untuk min/max
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

            // Normalisasi berdasarkan atribut Benefit/Cost
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

            // Hitung nilai ranking
            foreach ($normalisasi as $nama => $nilaiPerKriteria) {
                $total = 0;

                foreach ($kriteria as $k) {
                    if (isset($nilaiPerKriteria[$k->id])) {
                        $total += $nilaiPerKriteria[$k->id] * $k->bobot;
                    }
                }

                $ranking[$nama] = $total;
            }

            // Urutkan dari nilai tertinggi
            $sortedData = collect($ranking)->sortDesc()->toArray();

            Log::info('Perhitungan SAW untuk user berhasil dilakukan');

            return view('user.perhitungan.index', compact('alternatif', 'kriteria', 'normalisasi', 'sortedData', 'penilaians'));
        } catch (\Exception $e) {
            Log::error('Error pada perhitungan SAW user: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->route('penilaianuser.create')->with('msg', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
