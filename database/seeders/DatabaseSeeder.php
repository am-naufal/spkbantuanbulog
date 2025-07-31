<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Menonaktifkan foreign key constraints sementara
        Schema::disableForeignKeyConstraints();

        // \App\Models\User::factory(10)->create();

        // Memanggil User Seeder
        $this->call(UserSeeder::class);

        // Memanggil Kriteria Seeder
        $this->call(KriteriaSeeder::class);

        // Memanggil Crips Seeder
        $this->call(CripsSeeder::class);



        // Memanggil Alternatif Seeder
        $this->call(AlternatifSeeder::class);

        // Memanggil Penilaian Seeder
        $this->call(PenilaianSeeder::class);

        // Mengaktifkan kembali foreign key constraints
        Schema::enableForeignKeyConstraints();
    }
}
