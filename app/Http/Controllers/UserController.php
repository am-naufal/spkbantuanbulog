<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data['user'] = User::where('role', 'user')->get();
        return view('admin.user.index_user', $data);
    }


    public function admin()
    {
        $data['user'] = User::whereIn('role', ['admin', 'kepala_desa'])->get();
        return view('admin.user.index_admin', $data);
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'nik' => ['required', 'string', 'max:16', 'unique:users'],
            'alamat' => 'required|string',
            'telepon' => 'required|string',
            'role' => 'required|string',
            'keterangan' => 'required|string',
        ]);

        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->nik = $request->nik;
            $user->alamat = $request->alamat;
            $user->telepon = $request->telepon;
            $user->role = $request->role;
            $user->keterangan = $request->keterangan;

            $user->save();
            return redirect()->route('user.index')->with('msg', 'Berhasil Menambahkan Data');
        } catch (Exception $e) {
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            return back()->with('error', 'Gagal menambahkan data');
        }
    }

    public function edit($id)
    {
        $data['users'] = User::findOrFail($id);
        return view('admin.user.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'nik' => ['required', 'string', 'max:16', 'unique:users,nik,' . $id],
            'alamat' => 'required|string',
            'telepon' => 'required|string',
            'role' => 'required|string',
            'keterangan' => 'required|string',
        ]);

        try {
            $user = User::findOrFail($id);
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'nik' => $request->nik,
                'alamat' => $request->alamat,
                'telepon' => $request->telepon,
                'role' => $request->role,
                'keterangan' => $request->keterangan
            ];

            // Update password hanya jika diisi
            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $user->update($data);
            return redirect()->route('user.index')->with('msg', 'Berhasil Mengubah Data');
        } catch (Exception $e) {
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            return back()->with('error', 'Gagal mengubah data');
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return redirect()->route('user.index')->with('msg', 'Berhasil Menghapus Data');
        } catch (Exception $e) {
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            return back()->with('error', 'Gagal menghapus data');
        }
    }

    public function downloadPDF()
    {
        setlocale(LC_ALL, 'IND');
        $tanggal = Carbon::now()->formatLocalized('%A, %d %B %Y');
        $user = User::get();

        $pdf = Pdf::loadView('admin.user.user-pdf', compact('user', 'tanggal'));
        $pdf->setPaper('A3', 'potrait');
        return $pdf->stream('user.pdf');
    }
}
