<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\WargaTerpilih;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $alternatif = Alternatif::count();
        $kriteria = Kriteria::count();
        $perhitungan = Penilaian::count();
        $totalpenerima = WargaTerpilih::count();
        return view('admin.home', compact('alternatif', 'kriteria', 'perhitungan', 'totalpenerima'));
    }
}
