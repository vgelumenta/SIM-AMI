<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Department::create([
            'code' => 'JMTI',
            'name' => 'Jurusan Matematika dan Teknologi Informasi'
        ]);

        Department::create([
            'code' => 'JSTPK',
            'name' => 'Jurusan Sains, Teknologi Pangan, dan Kemaritiman'
        ]);

        Department::create([
            'code' => 'JTIP',
            'name' => 'Jurusan Teknologi Industri dan Proses'
        ]);

        Department::create([
            'code' => 'JTSP',
            'name' => 'Jurusan Teknik Sipil dan Perencanaan'
        ]);

        Department::create([
            'code' => 'JIKL',
            'name' => 'Jurusan Ilmu Kebumian dan Lingkungan'
        ]);
    }
}
