<?php

namespace Database\Seeders;

use App\Models\Stage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Stage::create([
            'name' => 'Pengisian',
        ]);

        Stage::create([
            'name' => 'Penilaian',
        ]);

        Stage::create([
            'name' => 'Feedback',
        ]);

        Stage::create([
            'name' => 'Verifikasi',
        ]);

        Stage::create([
            'name' => 'Laporan',
        ]);
        
        Stage::create([
            'name' => 'Selesai',
        ]);
    }
}
