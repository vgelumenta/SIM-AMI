<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Status::create([
            'name' => 'Menyimpang',
        ]);

        Status::create([
            'name' => 'Belum mencapai',
        ]);

        Status::create([
            'name' => 'Telah mencapai',
        ]);
        
        Status::create([
            'name' => 'Telah melampaui',
        ]);
    }
}
