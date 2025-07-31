<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Exception;

class AlternatifController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $alternatif = Alternatif::latest()->paginate(10);
        $user = User::all();
        return view('admin.alternatif.index', ['data' => $alternatif, 'user' => $user]);
    }
    public function create()
    {
        $user = auth()->user();

        // Cek dulu apakah sudah ada
        $exists = \App\Models\Alternatif::where('nik', $user->nik)->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Data alternatif sudah ada.');
        }
        // Simpan data
        \App\Models\Alternatif::create([
            'nik' => $user->nik,
            'nama_alternatif' => $user->name,
            'alamat' => $user->alamat,
            'telepon' => $user->telepon,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $alternatif = Alternatif::where('nik', $user->nik)->get();
        $kriteria = Kriteria::with('crips')->orderBy('id', 'ASC')->get();
        return redirect()->route('penilaianuser.create', ['alternatif' => $alternatif, 'kriteria' => $kriteria]);
    }
    public function store(Request $request)
    {
        $this->validate($request, [

            'nama_alternatif' => 'required|string',
            'nik' => 'required|string',
            'alamat' => 'required|string',
            'telepon' => 'required|string',

        ]);

        try {

            $alternatif = new Alternatif();
            $alternatif->nama_alternatif = $request->nama_alternatif;
            $alternatif->nik = $request->nik;
            $alternatif->alamat = $request->alamat;
            $alternatif->telepon = $request->telepon;
            $alternatif->save();
            return back()->with('msg', 'Berhasil Menambahkan Data');
        } catch (Exception $e) {
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            die("Gagal");
        }
    }


    public function edit($id)
    {
        $data['alternatif'] = Alternatif::findOrFail($id);
        return view('admin.alternatif.edit', $data);
    }


    public function update(Request $request, $id)
    {

        $this->validate($request, [

            'nama_alternatif' => 'required|string',
            'nik' => 'required|string',
            'alamat' => 'required|string',
            'telepon' => 'required|string',

        ]);

        try {

            $alternatif = Alternatif::findOrFail($id);
            $alternatif->update([
                'nama_alternatif' => $request->nama_alternatif,
                'nik' => $request->nik,
                'alamat' => $request->alamat,
                'telepon' => $request->telepon
            ]);
            return back()->with('msg', 'Berhasil Mengubah Data');
        } catch (Exception $e) {
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            die("Gagal");
        }
    }

    public function destroy($id)
    {

        try {

            $alternatif = Alternatif::findOrFail($id);
            $alternatif->delete();
            Penilaian::truncate();
        } catch (Exception $e) {
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            die("Gagal");
        }
    }

    public function downloadPDF()
    {
        setlocale(LC_ALL, 'IND');
        $tanggal = Carbon::now()->formatLocalized('%A, %d %B %Y');
        $alternatif = Alternatif::with('penilaian.detailPenilaian.crips')->get();

        $pdf = Pdf::loadView('admin.alternatif.alternatif-pdf', compact('alternatif', 'tanggal'));
        $pdf->setPaper('A4', 'potrait');
        return $pdf->stream('alternatif.pdf');
    }
    public function getAlternatif($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }

        return response()->json([
            'nik' => $user->nik,
            'alamat' => $user->alamat,
            'telepon' => $user->telepon
        ]);
    }

    public function cariAlternatif(Request $request)
    {
        $search = $request->q;

        $data = User::where('name', 'like', "%$search%")->orWhere('nik', 'like', '%' . $search . '%')
            ->select('id', 'name', 'nik')
            ->limit(10)
            ->get();

        return response()->json($data);
    }
}
