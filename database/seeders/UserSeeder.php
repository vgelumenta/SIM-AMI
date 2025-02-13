<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Vincent',
            'username' => '123',
            'email' => 'vgelumenta@gmail.com',
            'password' => Hash::make('11111111'),
        ])->assignRole('PJM', 'Auditor', 'Auditee');

        // User::create([
        //     'name' => 'Penjaminan Mutu',
        //     'username' => '11201091',
        //     'email' => '11201091@student.itk.ac.id',
        //     'password' => Hash::make('11111111'),
        // ])->assignRole('PJM', 'Auditor', 'Auditee');

        // User::create([
        //     'name' => 'Rifqi Aulia Tanjung, S.T., M.T.',
        //     'username' => '100118161',
        //     'email' => 'rifqi.aulia@lecturer.itk.ac.id',
        // ])->assignRole('PJM', 'Auditor', 'Auditee');

        // User::create([
        //     'name' => 'Darmansyah, S.Si., M.T.I',
        //     'username' => '198704282022031002',
        //     'email' => 'darmansyah@lecturer.itk.ac.id',
        // ])->assignRole('PJM', 'Auditor', 'Auditee');
    }
}
