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
            'name' => 'Submission',
            'description' => 'Tahap pengumpulan bukti ketercapaian indikator oleh Audite.'
        ]);

        Stage::create([
            'name' => 'Assessment',
            'description' => 'Tahap penilaian ketercapaian indikator oleh Auditor.'
        ]);

        Stage::create([
            'name' => 'Feedback',
            'description' => 'Tahap umpan balik Audite terhadap penilaian Auditor.'
        ]);

        Stage::create([
            'name' => 'Validation',
            'description' => 'Tahap validasi ketercapaian indikator berdasarkan kesepakatan bersama saat verifikasi lapangan.'
        ]);

        Stage::create([
            'name' => 'Meeting',
            'description' => 'Tahap pengumpulan Berita Acara RTM dengan verifikasi PJM.'
        ]);

        Stage::create([
            'name' => 'Planning',
            'description' => 'Tahap perencanaan tindak lanjut indikator yang belum memenuhi oleh Audite.'
        ]);

        Stage::create([
            'name' => 'Signing',
            'description' => 'Tahap pengumpulan Laporan Audit yang telah ditandatangani.'
        ]);

        Stage::create([
            'name' => 'Outcome',
            'description' => 'Kegiatan Audit Mutu Internal berhasil dilaksanakan.'
        ]);
    }
}
