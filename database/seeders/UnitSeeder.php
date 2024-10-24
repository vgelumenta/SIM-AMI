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
            'faculty_id' => '2'
        ]);

        Unit::create([
            'code' => '2',
            'name' => 'Matematika',
            'faculty_id' => '1'
        ]);
        
        Unit::create([
            'code' => '3',
            'name' => 'Teknik Mesin',
            'faculty_id' => '3'
        ]);

        Unit::create([
            'code' => '4',
            'name' => 'Teknik Elektro',
            'faculty_id' => '3'
        ]);

        Unit::create([
            'code' => '5',
            'name' => 'Teknik Kimia',
            'faculty_id' => '3'
        ]);

        Unit::create([
            'code' => '6',
            'name' => 'Teknik Material dan Metalurgi',
            'faculty_id' => '5'
        ]);

        Unit::create([
            'code' => '7',
            'name' => 'Teknik Sipil',
            'faculty_id' => '4'
        ]);

        Unit::create([
            'code' => '8',
            'name' => 'Perencanaan Wilayah dan Kota',
            'faculty_id' => '4'
        ]);

        Unit::create([
            'code' => '9',
            'name' => 'Teknik Perkapalan',
            'faculty_id' => '2'
        ]);

        Unit::create([
            'code' => '10',
            'name' => 'Sistem Informasi',
            'faculty_id' => '1'
        ]);

        Unit::create([
            'code' => '11',
            'name' => 'Informatika',
            'faculty_id' => '1'
        ]);

        Unit::create([
            'code' => '12',
            'name' => 'Teknik Industri',
            'faculty_id' => '3'
        ]);
        
        Unit::create([
            'code' => '13',
            'name' => 'Teknik Lingkungan',
            'faculty_id' => '5'
        ]);

        Unit::create([
            'code' => '14',
            'name' => 'Teknik Kelautan',
            'faculty_id' => '2'
        ]);

        Unit::create([
            'code' => '15',
            'name' => 'Teknik Pangan',
            'faculty_id' => '2'
        ]);
        
        Unit::create([
            'code' => '16',
            'name' => 'Ilmu Aktuaria',
            'faculty_id' => '1'
        ]);

        Unit::create([
            'code' => '17',
            'name' => 'Statistika',
            'faculty_id' => '1'
        ]);

        Unit::create([
            'code' => '18',
            'name' => 'Bisnis Digital',
            'faculty_id' => '1'
        ]);

        Unit::create([
            'code' => '19',
            'name' => 'Arsitektur',
            'faculty_id' => '4'
        ]);

        Unit::create([
            'code' => '20',
            'name' => 'Rekayasa Keselamatan',
            'faculty_id' => '3'
        ]);

        Unit::create([
            'code' => '21',
            'name' => 'Teknik Logistik',
            'faculty_id' => '3'
        ]);

        Unit::create([
            'code' => '22',
            'name' => 'Desain Komunikasi Visual',
            'faculty_id' => '4'
        ]);

    }
}
