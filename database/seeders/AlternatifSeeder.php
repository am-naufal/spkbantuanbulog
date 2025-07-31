<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Alternatif;
use App\Models\User;

class AlternatifSeeder extends Seeder
{
    public function run()
    {
        $users = User::where('role', 'user')->get();

        foreach ($users as $user) {
            Alternatif::create([
                'user_id' => $user->id, // asumsi kolom user_id sebagai foreign key
                'nama_alternatif' => $user->name,
                'nik' => $user->nik,
                'alamat' => $user->alamat,
                'telepon' => $user->telepon,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
