<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penilaian;
use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\Crips;
use App\Models\DetailPenilaian;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;
use Barryvdh\DomPDF\Facade\Pdf;



class PenilaianController extends Controller
{
    public function index()
    {
        $alternatif = Alternatif::all();
        $kriteria = Kriteria::with('crips')->orderBy('id', 'ASC')->get();
        $penilaians = Penilaian::with(['alternatif', 'user', 'detailPenilaian.kriteria', 'detailPenilaian.crips'])->get();

        return view('admin.penilaian.index', compact('alternatif', 'kriteria', 'penilaians'));
    }
    public function indexUser()
    {
        $userId = auth()->id();
        $penilaians = Penilaian::with(['alternatif', 'detailPenilaian.kriteria', 'detailPenilaian.crips'])
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.penilaian.index', compact('penilaians'));
    }
    public function create()
    {
        $alternatif = Alternatif::all();
        $kriteria = Kriteria::with('crips')->orderBy('id', 'ASC')->get();
        return view('admin.penilaian.tambah', compact('alternatif', 'kriteria'));
    }

    public function createforuser()
    {
        $nik = auth()->user()->nik;
        $alternatif = Alternatif::where('nik', $nik)->first();
        $kriteria = Kriteria::with('crips')->orderBy('id', 'ASC')->get();

        return view('user.penilaian.create', compact('alternatif', 'kriteria'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'alternatif_id' => 'required',
            'kriteria_id' => 'required|array',
            'crips_id' => 'required|array',
        ]);

        try {
            DB::beginTransaction();

            $user = auth()->user();
            $alternatif = Alternatif::findOrFail($request->alternatif_id);
            $kriteria = Kriteria::with('crips')->whereIn('id', $request->kriteria_id)->get();

            // Hitung total nilai
            $totalNilai = 0;
            foreach ($request->kriteria_id as $kriteriaId) {
                if (isset($request->crips_id[$kriteriaId][0])) {
                    $cripsId = $request->crips_id[$kriteriaId][0];
                    $kriteriaData = $kriteria->firstWhere('id', $kriteriaId);
                    $cripsData = $kriteriaData->crips->firstWhere('id', $cripsId);

                    if ($kriteriaData && $cripsData) {
                        $totalNilai += ($kriteriaData->bobot * $cripsData->bobot);
                    }
                }
            }

            // Buat penilaian utama
            $penilaian = Penilaian::create([
                'user_id' => $user->id,
                'alternatif_id' => $request->alternatif_id,
                'nik' => $alternatif->nik,
                'total_nilai' => $totalNilai,
            ]);

            // Buat detail penilaian untuk setiap kriteria
            foreach ($request->kriteria_id as $index => $kriteriaId) {
                if (isset($request->crips_id[$kriteriaId][0])) {
                    DetailPenilaian::create([
                        'penilaian_id' => $penilaian->id,
                        'kriteria_id' => $kriteriaId,
                        'crips_id' => $request->crips_id[$kriteriaId][0],
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('penilaian.index')->with('status', 'Penilaian berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('msg', 'Gagal menyimpan penilaian: ' . $e->getMessage())->withInput();
        }
    }
    public function storeUser(Request $request)
    {
        try {
            // Log seluruh request untuk debugging
            Log::info('Request from user form:', $request->all());

            // Validasi input
            $validated = $request->validate([
                'alternatif_id' => 'required',
                'kriteria_id' => 'required|array',
                'crips_id' => 'required|array',
            ]);

            DB::beginTransaction();

            $user = auth()->user();
            $alternatif = Alternatif::findOrFail($request->alternatif_id);
            $kriteria = Kriteria::with('crips')->whereIn('id', $request->kriteria_id)->get();

            // Hitung total nilai
            $totalNilai = 0;
            foreach ($request->kriteria_id as $kriteriaId) {
                if (isset($request->crips_id[$kriteriaId])) {
                    $cripsId = $request->crips_id[$kriteriaId];
                    $kriteriaData = $kriteria->firstWhere('id', $kriteriaId);
                    $cripsData = $kriteriaData->crips->firstWhere('id', $cripsId);

                    if ($kriteriaData && $cripsData) {
                        $totalNilai += ($kriteriaData->bobot * $cripsData->bobot);
                    }
                }
            }

            // Buat penilaian utama
            $penilaian = Penilaian::create([
                'user_id' => $user->id,
                'alternatif_id' => $request->alternatif_id,
                'nik' => $alternatif->nik,
                'total_nilai' => $totalNilai,
            ]);

            // Log data penilaian yang dibuat
            Log::info('Penilaian created:', $penilaian->toArray());

            // Buat detail penilaian untuk setiap kriteria
            foreach ($request->kriteria_id as $index => $kriteriaId) {
                if (isset($request->crips_id[$kriteriaId])) {
                    $cripsId = $request->crips_id[$kriteriaId];

                    $detail = DetailPenilaian::create([
                        'penilaian_id' => $penilaian->id,
                        'kriteria_id' => $kriteriaId,
                        'crips_id' => $cripsId,
                    ]);

                    // Log detail penilaian yang dibuat
                    Log::info('DetailPenilaian created for kriteria_id ' . $kriteriaId . ':', $detail->toArray());
                }
            }

            DB::commit();
            Log::info('Transaction committed successfully');
            return redirect()->route('userDashboard')->with('success', 'Penilaian berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in storeUser: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('msg', 'Gagal menyimpan penilaian: ' . $e->getMessage())->withInput();
        }
    }

    // Start Generation Here
    public function downloadPDF()
    {
        try {
            // Memperbaiki struktur eager loading
            $penilaians = Penilaian::with(['alternatif', 'user', 'detailPenilaian.kriteria', 'detailPenilaian.crips'])->get();

            // Mengambil data alternatif dengan relasi yang benar
            $alternatif = Alternatif::with([
                'penilaian' => function ($query) {
                    $query->with('detailPenilaian.crips', 'detailPenilaian.kriteria');
                }
            ])->get();

            $kriteria = Kriteria::orderBy('id', 'ASC')->get();

            setlocale(LC_ALL, 'IND');
            $tanggal = Carbon::now()->formatLocalized('%A, %d %B %Y');

            $pdf = Pdf::loadView('admin.penilaian.penilaian-pdf', compact('penilaians', 'alternatif', 'kriteria', 'tanggal'));
            $pdf->setPaper('A4', 'potrait');
            return $pdf->stream('penilaian.pdf');
        } catch (\Exception $e) {
            Log::error('Error in downloadPDF: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->route('penilaian.index')->with('msg', 'Gagal mengunduh PDF: ' . $e->getMessage());
        }
    }

    /**
     * Mengunduh detail satu penilaian dalam format PDF
     */
    public function downloadPenilaianDetail($id)
    {
        try {
            $penilaian = Penilaian::with(['alternatif', 'user', 'detailPenilaian.kriteria', 'detailPenilaian.crips'])->findOrFail($id);
            $kriteria = Kriteria::with('crips')->orderBy('id', 'ASC')->get();

            setlocale(LC_ALL, 'IND');
            $tanggal = Carbon::now()->formatLocalized('%A, %d %B %Y');

            $pdf = Pdf::loadView('admin.penilaian.detail-pdf', compact('penilaian', 'kriteria', 'tanggal'));
            $pdf->setPaper('A4', 'landscape');
            return $pdf->stream('penilaian-detail-' . $id . '.pdf');
        } catch (\Exception $e) {
            Log::error('Error in downloadPenilaianDetail: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->route('penilaian.index')->with('msg', 'Gagal mengunduh PDF: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $penilaian = Penilaian::findOrFail($id);

            // Hapus semua detail penilaian terkait
            $penilaian->detailPenilaian()->delete();

            // Hapus penilaian
            $penilaian->delete();

            return redirect()->route('penilaian.index')->with('status', 'Data penilaian berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('penilaian.index')->with('msg', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    /**
     * Menghitung total nilai untuk satu penilaian
     */
    public function calculate($id)
    {
        try {
            $penilaian = Penilaian::with('detailPenilaian.kriteria', 'detailPenilaian.crips')->findOrFail($id);

            // Inisialisasi total nilai
            $totalNilai = 0;

            // Hitung total nilai berdasarkan detail penilaian
            foreach ($penilaian->detailPenilaian as $detail) {
                if ($detail->crips && $detail->kriteria) {
                    // Bobot kriteria dikalikan dengan bobot crips
                    $nilaiKriteria = $detail->kriteria->bobot * $detail->crips->bobot;
                    $totalNilai += $nilaiKriteria;

                    Log::info("Menghitung nilai untuk kriteria {$detail->kriteria->nama_kriteria}: {$detail->kriteria->bobot} * {$detail->crips->bobot} = {$nilaiKriteria}");
                }
            }

            // Simpan total nilai ke database
            $penilaian->update(['total_nilai' => $totalNilai]);

            Log::info("Total nilai untuk penilaian ID {$id}: {$totalNilai}");

            return redirect()->route('penilaian.index')->with('status', "Berhasil menghitung nilai untuk {$penilaian->alternatif->nama_alternatif}. Total nilai: {$totalNilai}");
        } catch (\Exception $e) {
            Log::error('Error in calculate: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->route('penilaian.index')->with('msg', 'Gagal menghitung nilai: ' . $e->getMessage());
        }
    }

    /**
     * Menghitung total nilai untuk semua penilaian
     */
    public function calculateAll()
    {
        try {
            $penilaians = Penilaian::with('detailPenilaian.kriteria', 'detailPenilaian.crips')->get();

            $count = 0;
            foreach ($penilaians as $penilaian) {
                // Inisialisasi total nilai
                $totalNilai = 0;

                // Hitung total nilai berdasarkan detail penilaian
                foreach ($penilaian->detailPenilaian as $detail) {
                    if ($detail->crips && $detail->kriteria) {
                        // Bobot kriteria dikalikan dengan bobot crips
                        $nilaiKriteria = $detail->kriteria->bobot * $detail->crips->bobot;
                        $totalNilai += $nilaiKriteria;
                    }
                }

                // Simpan total nilai ke database
                $penilaian->update(['total_nilai' => $totalNilai]);

                $count++;
            }

            Log::info("Berhasil menghitung {$count} total nilai penilaian");

            return redirect()->route('penilaian.index')->with('status', "Berhasil menghitung {$count} total nilai penilaian");
        } catch (\Exception $e) {
            Log::error('Error in calculateAll: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->route('penilaian.index')->with('msg', 'Gagal menghitung nilai: ' . $e->getMessage());
        }
    }

    /**
     * Menghitung nilai dan langsung memproses dengan metode SAW
     */
    public function calculateAndProcessSAW()
    {
        try {
            // Hitung semua penilaian terlebih dahulu
            $penilaians = Penilaian::with('detailPenilaian.kriteria', 'detailPenilaian.crips')->get();

            $count = 0;
            foreach ($penilaians as $penilaian) {
                // Inisialisasi total nilai
                $totalNilai = 0;

                // Hitung total nilai berdasarkan detail penilaian
                foreach ($penilaian->detailPenilaian as $detail) {
                    if ($detail->crips && $detail->kriteria) {
                        // Bobot kriteria dikalikan dengan bobot crips
                        $nilaiKriteria = $detail->kriteria->bobot * $detail->crips->bobot;
                        $totalNilai += $nilaiKriteria;
                    }
                }

                // Simpan total nilai ke database
                $penilaian->update(['total_nilai' => $totalNilai]);

                $count++;
            }

            Log::info("Berhasil menghitung {$count} total nilai penilaian dan melanjutkan ke metode SAW");

            // Redirect ke algoritma controller untuk perhitungan SAW
            return redirect()->route('perhitungan.index');
        } catch (\Exception $e) {
            Log::error('Error in calculateAndProcessSAW: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->route('penilaian.index')->with('msg', 'Gagal menghitung nilai dengan metode SAW: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan detail penilaian
     */
    public function show($id)
    {
        try {
            $penilaian = Penilaian::with(['alternatif', 'user', 'detailPenilaian.kriteria', 'detailPenilaian.crips'])->findOrFail($id);
            $kriteria = Kriteria::with('crips')->orderBy('id', 'ASC')->get();

            return view('admin.penilaian.detail', compact('penilaian', 'kriteria'));
        } catch (\Exception $e) {
            return redirect()->route('penilaian.index')->with('msg', 'Data penilaian tidak ditemukan: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan form untuk mengedit penilaian
     */
    public function edit($id)
    {
        try {
            $penilaian = Penilaian::with(['alternatif', 'user', 'detailPenilaian.kriteria', 'detailPenilaian.crips'])->findOrFail($id);
            $user = User::where('id', $penilaian->user_id)->first();
            $alternatif = Alternatif::where('nik', $penilaian->nik)->first();
            $kriteria = Kriteria::with('crips')->orderBy('id', 'ASC')->get();
            return view('admin.penilaian.edit', compact('penilaian', 'user', 'alternatif', 'kriteria'));
        } catch (\Exception $e) {
            return redirect()->route('penilaian.index')->with('msg', 'Data penilaian tidak ditemukan: ' . $e->getMessage());
        }
    }

    /**
     * Mengupdate data penilaian
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'kriteria_id' => 'required|array',
            'crips_id' => 'required|array',
        ]);

        try {
            DB::beginTransaction();

            $penilaian = Penilaian::findOrFail($id);
            $kriteria = Kriteria::with('crips')->whereIn('id', $request->kriteria_id)->get();

            // Hitung ulang total nilai
            $totalNilai = 0;
            foreach ($request->kriteria_id as $kriteriaId) {
                if (isset($request->crips_id[$kriteriaId][0])) {
                    $cripsId = $request->crips_id[$kriteriaId][0];
                    $kriteriaData = $kriteria->firstWhere('id', $kriteriaId);
                    $cripsData = $kriteriaData->crips->firstWhere('id', $cripsId);

                    if ($kriteriaData && $cripsData) {
                        $totalNilai += ($kriteriaData->bobot * $cripsData->bobot);
                    }
                }
            }

            // Update total nilai
            $penilaian->update(['total_nilai' => $totalNilai]);

            // Hapus detail penilaian lama
            $penilaian->detailPenilaian()->delete();

            // Buat detail penilaian baru
            foreach ($request->kriteria_id as $index => $kriteriaId) {
                if (isset($request->crips_id[$kriteriaId][0])) {
                    DetailPenilaian::create([
                        'penilaian_id' => $penilaian->id,
                        'kriteria_id' => $kriteriaId,
                        'crips_id' => $request->crips_id[$kriteriaId][0],
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('penilaian.index')->with('status', 'Penilaian berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('msg', 'Gagal memperbarui penilaian: ' . $e->getMessage())->withInput();
        }
    }
}
