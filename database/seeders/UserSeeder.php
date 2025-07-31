<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'alamat' => 'Admin address',
            'telepon' => '081234567890',
            'keterangan' => 'Admin',
            'nik' => '0000000000000001',
            'role' => 'admin'
        ]);

        // Kepala Desa
        User::create([
            'name' => 'Kepala Desa',
            'email' => 'kepaladesa@example.com',
            'password' => Hash::make('password123'),
            'alamat' => 'Kepala Desa address',
            'telepon' => '081234567891',
            'keterangan' => 'Kepala Desa',
            'nik' => '0000000000000002',
            'role' => 'kepala_desa'
        ]);

        // Warga (user biasa)
        $users = [
            ['3175091201900001', '081234567891', 'A Nur Hidayat', 'Kelurahan Alasbuluh Rt 005 Rw 002 Alasbuluh Wongsorejo Banyuwangi Jawa Timur'],
            ['3201056501900002', '082134567892', 'Abd Hayyi', 'Kelurahan Alasbuluh Rt 007 Rw 002 Alasbuluh Wongsorejo Banyuwangi Jawa Timur'],
            ['3302040301900003', '083134567893', 'Abdul Jalil', 'Kelurahan Alasbuluh Rt 013 Rw 001 Alasbuluh Wongsorejo Banyuwangi Jawa Timur'],
            ['3375021401900004', '081345678901', 'Abdul Latip', 'Kelurahan Alasbuluh Rt 008 Rw 002 Alasbuluh Wongsorejo Banyuwangi Jawa Timur'],
            ['3403012001900005', '082345678902', 'Abdul Wahid', 'Kelurahan Alasbuluh Rt 001 Rw 002 Alasbuluh Wongsorejo Banyuwangi Jawa Timur'],
            ['3203041801900006', '083245678903', 'Abdur Rahman', 'Kelurahan Alasbuluh Rt 010 Rw 002 Alasbuluh Wongsorejo Banyuwangi Jawa Timur'],
            ['3175052201900007', '081234567904', 'Abdur Rahman', 'Kelurahan Alasbuluh Rt 010 Rw 001 Alasbuluh Wongsorejo Banyuwangi Jawa Timur'],
            ['3175062501900008', '082156789012', 'Abunidi', 'Kelurahan Alasbuluh Rt 013 Rw 001 Alasbuluh Wongsorejo Banyuwangi Jawa Timur'],
            ['3175080101900009', '083156789013', 'Agus Fausi', 'Kelurahan Alasbuluh Rt 010 Rw 001 Alasbuluh Wongsorejo Banyuwangi Jawa Timur'],
            ['3175070301900010', '081256789014', 'Ahmad Fauzi', 'Kelurahan Alasbuluh Rt 008 Rw 001 Alasbuluh Wongsorejo Banyuwangi Jawa Timur'],
            ['3271010401900011', '082356789015', 'Ahmd Riyadi', 'Kelurahan Alasbuluh Rt 006 Rw 001 Alasbuluh Wongsorejo Banyuwangi Jawa Timur'],
            ['3271020501900012', '083356789016', 'Ali Syahid', 'Kelurahan Alasbuluh Rt 003 Rw 002 Alasbuluh Wongsorejo Banyuwangi Jawa Timur'],
            ['3374010601900013', '081456789017', 'Ario', 'Kelurahan Alasbuluh Rt 005 Rw 002 Alasbuluh Wongsorejo Banyuwangi Jawa Timur'],
            ['3374020701900014', '082456789018', 'Asan Basri', 'Kelurahan Alasbuluh Rt 009 Rw 001 Alasbuluh Wongsorejo Banyuwangi Jawa Timur'],
            ['3173010801900015', '083456789019', 'Asmar', 'Kelurahan Alasbuluh Rt 001 Rw 002 Alasbuluh Wongsorejo Banyuwangi Jawa Timur'],
            ['3173020901900016', '081567890120', 'Asmawan', 'Kelurahan Alasbuluh Rt 004 Rw 002 Alasbuluh Wongsorejo Banyuwangi Jawa Timur'],
            ['3273011001900017', '082567890121', 'Begiran', 'Kelurahan Alasbuluh Rt 006 Rw 002 Alasbuluh Wongsorejo Banyuwangi Jawa Timur'],
            ['3273021101900018', '083567890122', 'Buhari', 'Kelurahan Alasbuluh Rt 007 Rw 001 Alasbuluh Wongsorejo Banyuwangi Jawa Timur'],
            ['3301011201900019', '081678901223', 'Buiman', 'Kelurahan Alasbuluh Rt 006 Rw 002 Alasbuluh Wongsorejo Banyuwangi Jawa Timur'],
            ['3301021301900020', '082678901224', 'Bunadi', 'Kelurahan Alasbuluh Rt 002 Rw 002 Alasbuluh Wongsorejo Banyuwangi Jawa Timur'],
            ['3404011401900021', '083678901225', 'Burawi', 'Kelurahan Alasbuluh Rt 001 Rw 002 Alasbuluh Wongsorejo Banyuwangi Jawa Timur'],
            ['3404021501900022', '081789012326', 'Burawi', 'Kelurahan Alasbuluh Rt 004 Rw 002 Alasbuluh Wongsorejo Banyuwangi Jawa Timur'],
            ['3202011601900023', '082789012327', 'Busamin', 'Kelurahan Alasbuluh Rt 007 Rw 002 Alasbuluh Wongsorejo Banyuwangi Jawa Timur'],
            ['3202021701900024', '083789012328', 'Busana', 'Kelurahan Alasbuluh Rt 008 Rw 002 Alasbuluh Wongsorejo Banyuwangi Jawa Timur'],
            ['3274011801900025', '081890123429', 'Bustanul Arifin', 'Kelurahan Alasbuluh Rt 009 Rw 001 Alasbuluh Wongsorejo Banyuwangi Jawa Timur'],
            ['3274021901900026', '082890123430', 'Buyamin', 'Kelurahan Alasbuluh Rt 003 Rw 002 Alasbuluh Wongsorejo Banyuwangi Jawa Timur'],
            ['3373012001900027', '083890123431', 'Dael', 'Kelurahan Alasbuluh Rt 002 Rw 002 Alasbuluh Wongsorejo Banyuwangi Jawa Timur'],
            ['3373022101900028', '081901234532', 'Darsono', 'Kelurahan Alasbuluh Rt 009 Rw 001 Alasbuluh Wongsorejo Banyuwangi Jawa Timur'],
            ['3373032201900029', '082901234533', 'Durahman', 'Kelurahan Alasbuluh Rt 004 Rw 002 Alasbuluh Wongsorejo Banyuwangi Jawa Timur'],
            ['3373042301900030', '083901234534', 'Ediyanto', 'Kelurahan Alasbuluh Rt 006 Rw 002 Alasbuluh Wongsorejo Banyuwangi Jawa Timur'],
            ['3174012401900031', '081012345635', 'Ervan Tusin Susilo', 'Kelurahan Alasbuluh Rt 005 Rw 002 Alasbuluh Wongsorejo Banyuwangi Jawa Timur'],
            ['3174022501900032', '082012345636', 'Giman', 'Kelurahan Alasbuluh Rt 006 Rw 002 Alasbuluh Wongsorejo Banyuwangi Jawa Timur'],
            ['3272012601900033', '083012345637', 'Haerul Anam', 'Kelurahan Alasbuluh Rt 007 Rw 001 Alasbuluh Wongsorejo Banyuwangi Jawa Timur'],
            ['3272022701900034', '081112345738', 'Hajar', 'Kelurahan Alasbuluh Rt 014 Rw 001 Alasbuluh Wongsorejo Banyuwangi Jawa Timur'],
            ['3303012801900035', '082112345739', 'Hariyanto', 'Kelurahan Alasbuluh Rt 001 Rw 002 Alasbuluh Wongsorejo Banyuwangi Jawa Timur'],
            ['3303022901900036', '083112345740', 'Hariyono', 'Kelurahan Alasbuluh Rt 000 Rw 002 Alasbuluh Wongsorejo Banyuwangi Jawa Timur'],
            ['3402013001900037', '081212345841', 'Harun', 'Kelurahan Alasbuluh Rt 001 Rw 001 Alasbuluh Wongsorejo Banyuwangi Jawa Timur'],
            ['3402023101900038', '082212345842', 'Hermanto', 'Kelurahan Alasbuluh Rt 004 Rw 001 Alasbuluh Wongsorejo Banyuwangi Jawa Timur'],
            ['3275013201900039', '083212345843', 'Herwanto', 'Kelurahan Alasbuluh Rt 010 Rw 001 Alasbuluh Wongsorejo Banyuwangi Jawa Timur'],
            ['3275023301900040', '081312345944', 'Hor Rohman Hasan', 'Kelurahan Alasbuluh Rt 003 Rw 002 Alasbuluh Wongsorejo Banyuwangi Jawa Timur'],
        ];


        foreach ($users as $index => [$nik, $telepon, $name, $alamat]) {
            User::create([
                'name' => $name,
                'email' => 'user' . ($index + 1) . '@example.com',
                'password' => Hash::make('password123'),
                'alamat' => $alamat,
                'telepon' => $telepon,
                'keterangan' => 'Warga',
                'nik' => $nik,
                'role' => 'user'
            ]);
        }
    }
}
