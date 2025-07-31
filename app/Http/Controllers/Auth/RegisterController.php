<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use PDF;
use Carbon\Carbon;
use Exception;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboardusers';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'alamat' => 'required|string',
            'telepon' => 'required|string',
            'keterangan' => 'nullable|string',
            'nik' => 'required|string|max:16',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'nik' => $data['nik'],
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'alamat' => $data['alamat'],
            'telepon' => $data['telepon'],
            'keterangan' => $data['keterangan'] ?? 'tidak ada keterangan',
            'nik' => $data['nik'],
            'role' => 'user',

        ]);
    }

    // Optional: fitur tambahan
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
        } catch (Exception $e) {
            Log::emergency("File:" . $e->getFile() . " Line:" . $e->getLine() . " Message:" . $e->getMessage());
            abort(500, 'Gagal menghapus user');
        }
    }

    public function downloadPDF()
    {
        setlocale(LC_ALL, 'IND');
        $tanggal = Carbon::now()->formatLocalized('%A, %d %B %Y');
        $user = User::get();

        $pdf = DomPDF::loadView('admin.user.user-pdf', compact('user', 'tanggal'));
        $pdf->setPaper('A3', 'portrait');
        return $pdf->stream('user.pdf');
    }
}
