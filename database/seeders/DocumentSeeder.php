<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $DocumentAMI2023 = [
            "categories" => [
                [
                    "id" => 1,
                    "name" => "Standar Pendidikan"
                ],
                [
                    "id" => 2,
                    "name" => "Standar Penelitian"
                ]
            ],
            "standards" => [
                [
                    "id" => 1,
                    "name" => "Kompetensi Lulusan",
                    "category_id" => 1
                ],
                [
                    "id" => 2,
                    "name" => "Isi Pembelajaran",
                    "category_id" => 1
                ],
                [
                    "id" => 3,
                    "name" => "Hasil Penelitian",
                    "category_id" => 2
                ]
            ],
            "competencies" => [
                [
                    "id" => 1,
                    "statement" => "Rektor harus menetapkan CPL di tingkat institut mencakup aspek sikap dan keterampilan umum yang sesuai dengan SN Dikti serta visi dan misi ITK yang dievaluasi minimal 5 (lima) tahun sekali",
                    "standard_id" => 1
                ],
                [
                    "id" => 2,
                    "statement" => "Ketua Jurusan dan Koordinator Program Studi harus memastikan tingkat pencapaian kualifikasi dan kompetensi lulusan yang memiliki daya saing dan kinerja unggul serta SELALU DIEVALUASI setiap tahun",
                    "standard_id" => 1
                ],
                [
                    "id" => 3,
                    "statement" => "Ketua Jurusan dan Koordinator Program Studi harus memastikan Keterlibatan pemangku kepentingan dalam proses evaluasi dan pemutakhiran kurikulum sesuai perkembangan ipteks dan kebutuhan pengguna setiap 5 (lima) tahun sekali",
                    "standard_id" => 2
                ],
                [
                    "id" => 4,
                    "statement" => "Dosen pembimbing harus memastikan hasil penelitian mahasiswa memenuhi kaidah dan metode ilmiah secara sistematis sesuai otonomi keilmuan dan budaya akademik di ITK, serta memenuhi Capaian Pembelajaran Lulusan (CPL)",
                    "standard_id" => 3
                ],
                [
                    "id" => 5,
                    "statement" => "Dosen harus memberikan kesempatan kepada tenaga kependidikan, dan mahasiswa untuk ikut serta dalam kegiatan Penelitian setiap tahun",
                    "standard_id" => 3
                ]
            ],
            "indicators" => [
                [
                    "id" => 1,
                    "assessment" => "Jurnal Internasional",
                    "competency_id" => 1,
                    "code" => "A.1",
                    "entry" => "Option",
                    "rate_option" => "",
                    "disable_text" => "",
                    "info" => "",
                ],
                [
                    "id" => 2,
                    "assessment" => "Konferensi Nasional",
                    "competency_id" => 1,
                    "code" => "A.2",
                    "entry" => "Option",
                    "rate_option" => "",
                    "disable_text" => "",
                    "info" => "",
                ],
                [
                    "id" => 3,
                    "assessment" => "Jumlah Lulusan",
                    "competency_id" => 2,
                    "code" => "A.3",
                    "entry" => "Option",
                    "rate_option" => "",
                    "disable_text" => "",
                    "info" => "",
                ],
                [
                    "id" => 4,
                    "assessment" => "Ketersedian bukti sahih yang menunjukan jumlah mata kuliah yang dikembangkan berdasarkan hasil penelitian dan PkM Dosen Tetap",
                    "competency_id" => 3,
                    "code" => "A.4",
                    "entry" => "Option",
                    "rate_option" => "",
                    "disable_text" => "",
                    "info" => "",
                ],
                [
                    "id" => 5,
                    "assessment" => "Ketersedian bukti sahih berupa laporan hasil penelitian mahasiswa yang memenuhi kaidah dan metode ilmiah secara sistematis sesuai otonomi keilmuan dan budaya akademik di ITK, serta memenuhi CPL",
                    "competency_id" => 4,
                    "code" => "B.1",
                    "entry" => "Option",
                    "rate_option" => "",
                    "disable_text" => "",
                    "info" => "",
                ],
                [
                    "id" => 6,
                    "assessment" => "Ketersedian bukti sahih yang menunjukkan persentase jumlah penelitian Dosen Tetap yang melibatkan mahasiswa program studi => PPDM ≥ 25%",
                    "competency_id" => 5,
                    "code" => "B.2",
                    "entry" => "Option",
                    "rate_option" => "",
                    "disable_text" => "",
                    "info" => "",
                ]
            ]
        ];

        Storage::disk('public')->put('drafts/Document AMI 2023.json', json_encode($DocumentAMI2023, JSON_PRETTY_PRINT));
    }
}
