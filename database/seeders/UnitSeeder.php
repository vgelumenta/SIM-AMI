<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Unit::create([
            'code' => 'JMTI',
            'name' => 'Jurusan Matematika dan Teknologi Informasi',
        ]);

        Unit::create([
            'code' => 'JSTPK',
            'name' => 'Jurusan Sains, Teknologi Pangan, Dan Kemaritiman',
        ]);

        Unit::create([
            'code' => 'JTIP',
            'name' => 'Jurusan Teknologi Industri Dan Proses',
        ]);

        Unit::create([
            'code' => 'JTSP',
            'name' => 'Jurusan Teknik Sipil Dan Perencanaan',
        ]);

        Unit::create([
            'code' => 'JIKL',
            'name' => 'Jurusan Ilmu Kebumian Dan Lingkungan',
        ]);
        
        Unit::create([
            'code' => '1',
            'name' => 'Fisika',
            'department_id' => '2'
        ]);

        Unit::create([
            'code' => '2',
            'name' => 'Matematika',
            'department_id' => '1'
        ]);
        
        Unit::create([
            'code' => '3',
            'name' => 'Teknik Mesin',
            'department_id' => '3'
        ]);

        Unit::create([
            'code' => '4',
            'name' => 'Teknik Elektro',
            'department_id' => '3'
        ]);

        Unit::create([
            'code' => '5',
            'name' => 'Teknik Kimia',
            'department_id' => '3'
        ]);

        Unit::create([
            'code' => '6',
            'name' => 'Teknik Material dan Metalurgi',
            'department_id' => '5'
        ]);

        Unit::create([
            'code' => '7',
            'name' => 'Teknik Sipil',
            'department_id' => '4'
        ]);

        Unit::create([
            'code' => '8',
            'name' => 'Perencanaan Wilayah dan Kota',
            'department_id' => '4'
        ]);

        Unit::create([
            'code' => '9',
            'name' => 'Teknik Perkapalan',
            'department_id' => '2'
        ]);

        Unit::create([
            'code' => '10',
            'name' => 'Sistem Informasi',
            'department_id' => '1'
        ]);

        Unit::create([
            'code' => '11',
            'name' => 'Informatika',
            'department_id' => '1'
        ]);

        Unit::create([
            'code' => '12',
            'name' => 'Teknik Industri',
            'department_id' => '3'
        ]);
        
        Unit::create([
            'code' => '13',
            'name' => 'Teknik Lingkungan',
            'department_id' => '5'
        ]);

        Unit::create([
            'code' => '14',
            'name' => 'Teknik Kelautan',
            'department_id' => '2'
        ]);

        Unit::create([
            'code' => '15',
            'name' => 'Teknik Pangan',
            'department_id' => '2'
        ]);
        
        Unit::create([
            'code' => '16',
            'name' => 'Ilmu Aktuaria',
            'department_id' => '1'
        ]);

        Unit::create([
            'code' => '17',
            'name' => 'Statistika',
            'department_id' => '1'
        ]);

        Unit::create([
            'code' => '18',
            'name' => 'Bisnis Digital',
            'department_id' => '1'
        ]);

        Unit::create([
            'code' => '19',
            'name' => 'Arsitektur',
            'department_id' => '4'
        ]);

        Unit::create([
            'code' => '20',
            'name' => 'Rekayasa Keselamatan',
            'department_id' => '3'
        ]);

        Unit::create([
            'code' => '21',
            'name' => 'Teknik Logistik',
            'department_id' => '3'
        ]);

        Unit::create([
            'code' => '22',
            'name' => 'Desain Komunikasi Visual',
            'department_id' => '4'
        ]);

    }
}
