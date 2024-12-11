<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\Unit;
use App\Models\User;
use App\Models\Status;
use App\Models\Category;
use App\Models\Document;
use App\Models\FormTime;
use App\Models\Standard;
use App\Models\FormAudit;
use App\Models\Indicator;
use App\Models\Competency;
use App\Models\FormAccess;
use App\Events\FormUpdated;
use Illuminate\Http\Request;
use App\Models\FormSubmission;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpWord\Element\Chart;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Chart\Title;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Chart\Legend;
use PhpOffice\PhpSpreadsheet\Chart\PlotArea;
use PhpOffice\PhpSpreadsheet\Chart\DataSeries;
use PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues;
use PhpOffice\PhpSpreadsheet\Chart\Chart as SpreadsheetChart;

class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (app('user_role') === 'PJM') {
            // Jika pengguna masuk sebagai admin, ambil semua formulir
            // $forms = Form::all();
            $forms = Form::orderBy('id', 'desc')->get();
        } else {
            $userId = auth()->id();

            // Jika bukan admin, ambil formulir berdasarkan akses pengguna
            $forms = Form::whereHas('formAccesses', function ($query) use ($userId) {
                $query->where('user_id', $userId)
                    // ->where(function ($query) {
                    //     $query->where('position', 'Pimpinan')
                    //         ->orWhere('position', 'LIKE', 'PIC%');
                    // })
                ;
            })->get();
        }

        return view('forms.index', compact('forms'));
    }

    public function create(Request $request)
    {
        $documents = Document::orderBy('created_at', 'desc')->pluck('name', 'id');

        $documentId = $request->input('document_id', $documents->keys()->first());

        if ($documentId) {
            $categories = Category::where('document_id', $documentId)->get();

            $standards = Standard::whereIn('category_id', $categories->pluck('id'))->get();

            $competencies = Competency::whereIn('standard_id', $standards->pluck('id'))->get();

            $indicators = Indicator::whereIn('competency_id', $competencies->pluck('id'))->get();

            $standardsByCategory = $standards->groupBy('category_id');

            $competenciesByStandard = $competencies->groupBy('standard_id');

            $indicatorsByCompetency = $indicators->groupBy('competency_id');
        } else {
            $categories = collect();
            $standardsByCategory = collect();
            $competenciesByStandard = collect();
            $indicatorsByCompetency = collect();
        }

        $units = Unit::all();
        $users = User::all();

        return view('forms.create', compact('units', 'users',  'documentId', 'documents', 'categories', 'standardsByCategory', 'competenciesByStandard', 'indicatorsByCompetency'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $units = $request->input('units');
        $document = $request->input('document');
        $deadline = str_replace('T', ' ', $request->input('deadline')) . ':00';
        $positions = $request->input('positions');
        $userNames = $request->input('user_names'); // Dapatkan input nama user
        $userUsernames = $request->input('user_usernames'); // Dapatkan input username user
        $userEmails = $request->input('user_emails'); // Dapatkan input email user
        $indicators_id = $request->input('indicators_id');

        foreach ($units as $index => $unit) {
            $form = Form::create([
                'document_id' => $document,
                'unit_id' => $unit,
                'stage_id' => 1,
                'deadline' => $deadline
            ]);

            $unitUserNames = $userNames[$unit] ?? []; // Dapatkan nama user untuk unit ini
            $unitUserUsernames = $userUsernames[$unit] ?? []; // Dapatkan username user untuk unit ini
            $unitUserEmails = $userEmails[$unit] ?? []; // Dapatkan email user untuk unit ini
            $unitPositions = $positions[$unit] ?? []; // Dapatkan data posisi untuk unit ini

            foreach ($unitUserEmails as $index => $email) {
                $name = $unitUserNames[$index] ?? ''; // Ambil nama yang sesuai atau default
                $username = $unitUserUsernames[$index] ?? ''; // Ambil username yang sesuai atau default
                $position = $unitPositions[$index] ?? ''; // Ambil posisi yang sesuai atau default

                // Periksa apakah email dan nama tidak kosong
                if (empty($email) || empty($name)) {
                    continue; // Lewati iterasi jika email atau nama kosong
                }

                $user = User::firstOrCreate(
                    ['email' => $email], // Jika user tidak ditemukan berdasarkan email
                    [
                        'name' => $name,
                        'username' => $username,
                        'email' => $email,
                    ] // Buat user baru dengan nama ini
                );

                if (in_array($position, ['Pimpinan']) || strpos($position, 'PIC') !== false) {
                    $user->assignRole('Auditee');
                } elseif (in_array($position, ['Ketua']) || strpos($position, 'Anggota') !== false) {
                    $user->assignRole('Auditor');
                }

                // Setelah user ditemukan atau dibuat, buat entri FormAccess
                FormAccess::create([
                    'form_id' => $form->id,
                    'user_id' => $user->id,
                    'position' => $position
                ]);
            }

            foreach ($indicators_id as $indicator_id) {
                FormAudit::create([
                    'form_id' => $form->id,
                    'indicator_id' => $indicator_id
                ]);
            }
        }

        return redirect()->route('forms.index')->with('success', 'Data saved successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Form $form)
    {
        $formAccesses = FormAccess::where('form_id', $form->id)->get();

        $viewAccess = $formAccesses->contains('user_id', auth()->id());

        if (!$viewAccess && app('user_role') !== 'PJM') {
            abort(403);
        }

        $auditees = $formAccesses->filter(function ($access) {
            return $access->position === 'Pimpinan' || strpos($access->position, 'PIC') !== false;
        })->sortBy(function ($access) {
            return $access->position === 'Pimpinan' ? 0 : (intval(str_replace('PIC', '', $access->position)) ?: 1);
        });

        $auditors = $formAccesses->filter(function ($access) {
            return $access->position === 'Ketua' || strpos($access->position, 'Anggota') !== false;
        })->sortBy(function ($access) {
            return $access->position === 'Ketua' ? 0 : (intval(str_replace('Anggota', '', $access->position)) ?: 1);
        });

        $formAudits = FormAudit::with([
            'indicator.competency.standard.category'
        ])->where('form_id', $form->id)->get();

        $grouped = $formAudits->groupBy(function ($item) {
            return $item->indicator?->competency?->standard?->category?->id ?? null;
        });

        $statuses = Status::orderBy('id', 'desc')->get();

        $skip = true;

        return view('forms.show', compact('form', 'auditees', 'auditors', 'grouped', 'statuses', 'skip'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Form $form, Request $request)
    {
        $documents = Document::orderBy('created_at', 'desc')->pluck('name', 'id');

        $documentId = $request->input('document_id', $documents->keys()->first());

        if ($documentId) {
            $categories = Category::where('document_id', $documentId)->get();

            $standards = Standard::whereIn('category_id', $categories->pluck('id'))->get();

            $competencies = Competency::whereIn('standard_id', $standards->pluck('id'))->get();

            $indicators = Indicator::whereIn('competency_id', $competencies->pluck('id'))->get();

            $standardsByCategory = $standards->groupBy('category_id');

            $competenciesByStandard = $competencies->groupBy('standard_id');

            $indicatorsByCompetency = $indicators->groupBy('competency_id');
        } else {
            $categories = collect();
            $standardsByCategory = collect();
            $competenciesByStandard = collect();
            $indicatorsByCompetency = collect();
        }

        $units = Unit::all();
        $users = User::all();

        $formAccesses = FormAccess::where('form_id', $form->id)->get();

        return view('forms.edit', compact('formAccesses', 'form', 'units', 'users',  'documentId', 'documents', 'categories', 'standardsByCategory', 'competenciesByStandard', 'indicatorsByCompetency'));
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Form $form)
    {
        Form::destroy($form->id);

        return redirect('/forms')->with('status', 'Form berhasil dihapus.');
    }

    public function export0(Form $form)
    {
        $unit = $form->unit->name;
        $fileName = "Laporan AMI {$form->unit->code}.docx";

        // Ambil data FormAccess yang terkait dengan form
        $formAccesses = FormAccess::where('form_id', $form->id)->get();

        // Filter untuk auditees dan auditors
        $auditees = $formAccesses->filter(function ($access) {
            return $access->position === 'Pimpinan' || strpos($access->position, 'PIC') !== false;
        });

        $auditors = $formAccesses->filter(function ($access) {
            return $access->position === 'Ketua' || strpos($access->position, 'Anggota') !== false;
        });

        // Buat instance TemplateProcessor dengan template yang sudah ada
        $phpWord = new \PhpOffice\PhpWord\TemplateProcessor('Laporan AMI.docx');

        // Set nilai untuk unit
        $phpWord->setValue('unit', $unit);

        // Clone blocks untuk Auditees
        $phpWord->cloneBlock('auditee_block', $auditees->count(), true);

        foreach ($auditees as $index => $auditee) {
            $phpWord->setValue("auditee_position#" . ($index + 1), $auditee->position);
            $phpWord->setValue("auditee_name#" . ($index + 1), $auditee->user->name);
        }

        // Clone blocks untuk Auditors
        $phpWord->cloneBlock('auditor_block', $auditors->count(), true);

        foreach ($auditors as $index => $auditor) {
            $phpWord->setValue("auditor_position#" . ($index + 1), $auditor->position);
            $phpWord->setValue("auditor_name#" . ($index + 1), $auditor->user->name);
        }

        // Tentukan path sementara untuk menyimpan file
        $tempFilePath = storage_path("app/{$fileName}");
        $phpWord->saveAs($tempFilePath);

        // Berikan respons unduhan dan hapus file sementara setelah diunduh
        return response()->download($tempFilePath)->deleteFileAfterSend(true);
    }

    public function export1(Form $form)
    {
        // Inisialisasi TemplateProcessor
        $templateProcessor = new TemplateProcessor('Laporan AMI.docx');


        $unit = $form->unit->name;
        $templateProcessor->setValue('unit', $unit);

        $data = [
            ['nama' => 'John Doe', 'alamat' => '123 Main Street'],
            ['nama' => 'Jane Smith', 'alamat' => '456 Maple Avenue'],
        ];

        // Siapkan data untuk penggandaan blok
        $replacements = [];
        foreach ($data as $index => $biodata) {
            $replacements[] = [
                'nama' => '${nama_' . $index . '}',
                'alamat' => '${alamat_' . $index . '}',
            ];
        }

        // Clone block
        $templateProcessor->cloneBlock('block_biodata', count($replacements), true, false, $replacements);

        // Menyimpan file sementara
        $fileName = "Laporan AMI {$form->unit->code}.docx";
        $tempFilePath = storage_path("app/{$fileName}");
        $templateProcessor->saveAs($tempFilePath);

        // Memberikan respons untuk mengunduh file dan menghapus file setelah diunduh
        return response()->download($tempFilePath)->deleteFileAfterSend(true);
    }

    public function export2(Form $form)
    {
        $unit = $form->unit->name;
        $fileName = "Laporan AMI {$form->unit->code}.docx";

        // Ambil data FormAccess yang terkait dengan form
        $formAccesses = FormAccess::where('form_id', $form->id)->get();

        // Filter untuk auditees dan auditors
        $auditees = $formAccesses->filter(function ($access) {
            return $access->position === 'Pimpinan' || strpos($access->position, 'PIC') !== false;
        });

        $auditors = $formAccesses->filter(function ($access) {
            return $access->position === 'Ketua' || strpos($access->position, 'Anggota') !== false;
        });

        // dd($auditees);

        // Buat instance TemplateProcessor dengan template yang sudah ada
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('Laporan AMI.docx');

        // Set nilai untuk unit
        $templateProcessor->setValue('unit', $unit);

        // Buat array data untuk diisi ke dalam tabel
        $rowCount = max($auditees->count(), $auditors->count());
        $rows = [];

        for ($i = 0; $i < $rowCount; $i++) {
            $auditee = $auditees->skip($i)->first();
            $auditor = $auditors->skip($i)->first();

            $rows[] = [
                "auditee_position#" . ($i + 1) => $auditee->position ?? '',
                "auditee_name#" . ($i + 1) => $auditee->user->name ?? '',
                "auditor_position#" . ($i + 1) => $auditor->position ?? '',
                "auditor_name#" . ($i + 1) => $auditor->user->name ?? '',
            ];
        }

        // Clone row di Word berdasarkan data
        $templateProcessor->cloneRowAndSetValues('auditee_position', $rows);

        // Tentukan path sementara untuk menyimpan file
        $tempFilePath = storage_path("app/{$fileName}");
        $templateProcessor->saveAs($tempFilePath);

        // Berikan respons unduhan dan hapus file sementara setelah diunduh
        return response()->download($tempFilePath)->deleteFileAfterSend(true);
    }

    public function export3(Form $form)
    {
        $formAccesses = FormAccess::where('form_id', $form->id)->get();

        // Filter untuk auditees (Pimpinan & PIC)
        $auditees = $formAccesses->filter(function ($access) {
            return $access->position === 'Pimpinan' || strpos($access->position, 'PIC') !== false;
        });

        // Filter untuk auditors (Ketua & Anggota)
        $auditors = $formAccesses->filter(function ($access) {
            return $access->position === 'Ketua' || strpos($access->position, 'Anggota') !== false;
        });

        // Transformasi data untuk template
        $auditeesData = $auditees->map(function ($auditee) {
            return [
                'auditee_position' => $auditee->position,
                'auditee_name' => $auditee->user->name, // Asumsi relasi user()->name
            ];
        })->toArray();

        $auditorsData = $auditors->map(function ($auditor) {
            return [
                'auditor_position' => $auditor->position,
                'auditor_name' => $auditor->user->name, // Asumsi relasi user()->name
            ];
        })->toArray();

        // Load template Word
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('Laporan AMI.docx');

        // Clone rows dan set nilai
        $templateProcessor->cloneRowAndSetValues('auditee_position', $auditeesData);
        $templateProcessor->cloneRowAndSetValues('auditor_position', $auditorsData);

        // Simpan file sementara
        $fileName = "Laporan AMI {$form->unit->code}.docx";
        $tempFilePath = storage_path("app/{$fileName}");
        $templateProcessor->saveAs($tempFilePath);

        // Kirim file sebagai respons
        return response()->download($tempFilePath)->deleteFileAfterSend(true);
    }

    public function export4(Form $form)
    {
        $formAccesses = FormAccess::where('form_id', $form->id)->get();

        // Filter untuk auditees (Pimpinan & PIC)
        $auditees = $formAccesses->filter(function ($access) {
            return $access->position === 'Pimpinan' || strpos($access->position, 'PIC') !== false;
        });

        // Filter untuk auditors (Ketua & Anggota)
        $auditors = $formAccesses->filter(function ($access) {
            return $access->position === 'Ketua' || strpos($access->position, 'Anggota') !== false;
        });

        // Transformasi data untuk template
        $auditeesData = $auditees->map(function ($auditee) {
            return [
                'auditee_position' => $auditee->position,
                'auditee_name' => $auditee->user->name ?? '',
            ];
        })->values()->toArray();

        $auditorsData = $auditors->map(function ($auditor) {
            return [
                'auditor_position' => $auditor->position,
                'auditor_name' => $auditor->user->name ?? '',
            ];
        })->values()->toArray();

        // Gabungkan data
        $maxRows = max(count($auditeesData), count($auditorsData));
        $combinedData = [];

        for ($i = 0; $i < $maxRows; $i++) {
            $combinedData[] = [
                'auditee_position' => $auditeesData[$i]['auditee_position'] ?? '',
                'auditee_name' => $auditeesData[$i]['auditee_name'] ?? '',
                'auditor_position' => $auditorsData[$i]['auditor_position'] ?? '',
                'auditor_name' => $auditorsData[$i]['auditor_name'] ?? '',
            ];
        }

        // Load template Word
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('Laporan AMI.docx');

        // Clone rows dan set nilai
        $templateProcessor->cloneRowAndSetValues('auditee_position', $combinedData);

        // Simpan file sementara
        $fileName = "Laporan AMI {$form->unit->code}.docx";
        $tempFilePath = storage_path("app/{$fileName}");
        $templateProcessor->saveAs($tempFilePath);

        // Kirim file sebagai respons
        return response()->download($tempFilePath)->deleteFileAfterSend(true);
    }

    public function export5(Form $form)
    {
        // Load template Word
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('Laporan AMI.docx');

        // Ambil data FormAudit beserta relasi indicator dan competency
        $formAudits = FormAudit::with([
            'indicator.competency'
        ])->where('form_id', $form->id)->get();

        // Kelompokkan data berdasarkan ID kompetensi
        $grouped = $formAudits->groupBy(fn($item) => $item->indicator->competency->id);

        $rows = []; // Menyimpan data kompetensi untuk template

        // Loop untuk memproses kompetensi
        foreach ($grouped as $competencyId => $formAuditsGroup) {
            // Ambil data kompetensi
            $competency = $formAuditsGroup->first()->indicator->competency;

            // Placeholder untuk indikator
            $indicatorPlaceholder = '${indicator_' . $competencyId . '}';

            // Tambahkan data kompetensi ke $rows
            $rows[] = [
                'competency_statement' => $competency->statement ?? '',
                'indicator_placeholder' => $indicatorPlaceholder,
            ];
        }

        // Clone row untuk kompetensi dan set data
        $templateProcessor->cloneRowAndSetValues('competency_statement', $rows);

        // Simpan file sementara
        $fileName = "Laporan AMI {$form->unit->code}.docx";
        $tempFilePath = storage_path("app/{$fileName}");
        $templateProcessor->saveAs($tempFilePath);

        // kemudian masukkan data dibawah ini

        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($tempFilePath);

        // Kirim file sebagai respons
        return response()->download($tempFilePath)->deleteFileAfterSend(true);

        // Loop untuk memproses indikator
        foreach ($grouped as $competencyId => $formAuditsGroup) {
            $indicatorPlaceholder = "indicator_{$competencyId}";


            // Data indikator untuk kompetensi ini
            $competencyIndicators = [];

            foreach ($formAuditsGroup as $audit) {
                $competencyIndicators[] = [
                    $indicatorPlaceholder => $audit->indicator->code ?? '',
                    'verification_status' => $audit->verification_status ?? '',
                ];
            }

            // dd($competencyIndicators);
            // Clone row untuk indikator dan set data
            $templateProcessor->cloneRowAndSetValues("$indicatorPlaceholder", $competencyIndicators);

            // dd($indicatorPlaceholder);
        }

        // Simpan file sementara
        $fileName = "Laporan AMI {$form->unit->code}.docx";
        $tempFilePath = storage_path("app/{$fileName}");
        $templateProcessor->saveAs($tempFilePath);

        // Kirim file sebagai respons
        return response()->download($tempFilePath)->deleteFileAfterSend(true);
    }

    public function export(Form $form)
    {
        // Load template
        $templateProcessor = new TemplateProcessor('Laporan AMI.docx');

        // Set nilai untuk unit
        $unit = $form->unit->name;
        $templateProcessor->setValue('unit', $unit);

        $formAudits = FormAudit::with([
            'indicator.competency'
        ])->where('form_id', $form->id)->get();

        // Kelompokkan data berdasarkan ID kategori, standar, kompetensi, dan indikator
        $grouped = $formAudits->groupBy(fn($item) => $item->indicator->competency->id);

        // Transformasi data untuk template
        $rows = [];
        $counter = 1;

        foreach ($grouped as $competencyId => $formAuditsGroup) {
            $competency = $formAuditsGroup->first()->indicator->competency;

            foreach ($formAuditsGroup as $audit) {
                $rows[] = [
                    'i' => $counter++, // Nomor urut
                    'competency_statement' => $competency->statement ?? '',
                    'indicator_code' => $audit->indicator->code ?? '',
                    'verification_status' => $audit->verification_status ?? '',
                ];

                // Tambahkan baris kosong untuk kompetensi selain pada baris pertama
                $competency->statement = '';
            }
        }

        // Clone rows dan isi data
        $templateProcessor->cloneRowAndSetValues('competency_statement', $rows);

        $formAccesses = FormAccess::where('form_id', $form->id)->get();

        // Filter dan transformasi data untuk auditees dan auditors
        $auditeesData = $formAccesses->filter(
            fn($access) =>
            in_array($access->position, ['Pimpinan', 'PIC']) || strpos($access->position, 'PIC') !== false
        )->map(fn($auditee) => [
            'auditee_position' => $auditee->position,
            'auditee_name' => $auditee->user->name ?? '',
            'auditee_contact' => $auditee->user->contact,
        ])->values();

        $auditorsData = $formAccesses->filter(
            fn($access) =>
            in_array($access->position, ['Ketua', 'Anggota']) || strpos($access->position, 'Anggota') !== false
        )->map(fn($auditor) => [
            'auditor_position' => $auditor->position,
            'auditor_name' => $auditor->user->name ?? '',
            'auditor_contact' => $auditor->user->contact,
        ])->values();

        // Gabungkan data auditees dan auditors sebagai template
        $combinedData = collect(range(0, max($auditeesData->count(), $auditorsData->count()) - 1))
            ->map(fn($i) => [
                'auditee_position' => $auditeesData[$i]['auditee_position'] ?? '',
                'auditee_name' => $auditeesData[$i]['auditee_name'] ?? '',
                'auditee_contact' => $auditeesData[$i]['auditee_contact'] ?? '',
                'auditor_position' => $auditorsData[$i]['auditor_position'] ?? '',
                'auditor_name' => $auditorsData[$i]['auditor_name'] ?? '',
                'auditor_contact' => $auditorsData[$i]['auditor_contact'] ?? '',
            ])
            ->toArray();

        // Clone rows dan set nilai
        $templateProcessor->cloneRowAndSetValues('auditee_position', $combinedData);

        $categories = array('A', 'B', 'C', 'D');
        $series1 = array(1, 3, 2, 5);
        $chart = new Chart('pie', $categories, $series1);

        // Atur ukuran chart
        // $chart->setWidth(600); // Lebar chart dalam piksel
        // $chart->setHeight(400); // Tinggi chart dalam piksel
        $templateProcessor->setChart('chart', $chart);

        // $chartPath = $this->generateChartImageGD();
        // $chartPath = $this->generatePieChartImage();
        // $chartPath = $this->generateChartImage();

        // 3. Replace Placeholder with Chart Image
        // $templateProcessor->setImageValue('chart_placeholder', [
        //     'path' => $chartPath,
        //     'width' => 600,  // Set width (pixels)
        //     'height' => 400, // Set height (pixels)
        // ]);

        // Simpan file sementara
        $fileName = "Laporan AMI {$form->unit->code}.docx";
        $tempFilePath = storage_path("app/{$fileName}");
        $templateProcessor->saveAs($tempFilePath);

        // Kirim file sebagai respons
        return response()->download($tempFilePath)->deleteFileAfterSend(true);
    }

    private function generateChartImage()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Data for chart
        $categories = ['A', 'B', 'C', 'D', 'E'];
        $values = [1, 3, 2, 5, 4];

        // Add data to spreadsheet
        $sheet->fromArray(
            [['Category', 'Value'], ...array_map(null, $categories, $values)],
            null,
            'A1'
        );

        // Create chart data series
        $dataSeriesValues = [new DataSeriesValues('Number', 'Worksheet!$B$2:$B$6')];
        $xAxisTickValues = [new DataSeriesValues('String', 'Worksheet!$A$2:$A$6')];

        $series = new DataSeries(
            DataSeries::TYPE_BARCHART,
            DataSeries::GROUPING_CLUSTERED,
            range(0, count($dataSeriesValues) - 1),
            [],
            $xAxisTickValues,
            $dataSeriesValues
        );

        $plotArea = new PlotArea(null, [$series]);
        $chart = new SpreadsheetChart(
            'Sample Chart',
            new Title('Example Chart'),
            null,
            $plotArea
        );

        // Position chart in the sheet
        $chart->setTopLeftPosition('A7');
        $chart->setBottomRightPosition('H20');

        $sheet->addChart($chart);

        // Save chart as image
        $chartImagePath = storage_path('app\chart.png');
        $writer = new Xlsx($spreadsheet);
        $writer->setIncludeCharts(true);

        // Save as temporary Excel file first
        $tempXlsx = storage_path('app/chart.xlsx');
        $writer->save($tempXlsx);

        // Convert XLSX to PNG using LibreOffice (or other tools)
        exec("libreoffice --headless --convert-to png --outdir " . dirname($chartImagePath) . " $tempXlsx");

        return $chartImagePath;
    }

    private function generatePieChartImage()
    {
        // Dimensi gambar
        $width = 600;
        $height = 400;

        // Warna untuk setiap bagian
        $colors = [
            [255, 99, 71],   // Tomato
            [60, 179, 113],  // Medium Sea Green
            [30, 144, 255],  // Dodger Blue
            [255, 215, 0],   // Gold
            [148, 0, 211],   // Dark Violet
        ];

        // Data untuk pie chart
        $data = [20, 30, 10, 25, 15]; // Representasi persentase
        $total = array_sum($data);

        // Buat gambar kosong
        $image = imagecreatetruecolor($width, $height);

        // Warna latar belakang
        $backgroundColor = imagecolorallocate($image, 255, 255, 255); // Putih
        imagefilledrectangle($image, 0, 0, $width, $height, $backgroundColor);

        // Warna untuk masing-masing bagian
        $gdColors = [];
        foreach ($colors as $rgb) {
            $gdColors[] = imagecolorallocate($image, $rgb[0], $rgb[1], $rgb[2]);
        }

        // Gambar pie chart
        $centerX = $width / 2;
        $centerY = $height / 2;
        $radius = min($width, $height) / 3;
        $startAngle = 0;

        foreach ($data as $index => $value) {
            $endAngle = $startAngle + ($value / $total) * 360;
            imagefilledarc(
                $image,
                $centerX,
                $centerY,
                $radius * 2,
                $radius * 2,
                $startAngle,
                $endAngle,
                $gdColors[$index % count($gdColors)],
                IMG_ARC_PIE
            );
            $startAngle = $endAngle;
        }

        // Simpan ke file PNG sementara
        $filePath = storage_path('app/pie_chart.png');
        imagepng($image, $filePath);

        // Hapus gambar dari memori
        imagedestroy($image);

        return $filePath;
    }

    private function generateChartImageGD()
    {
        $width = 600;  // Lebar gambar
        $height = 400; // Tinggi gambar
        $image = imagecreatetruecolor($width, $height);

        // Warna
        $backgroundColor = imagecolorallocate($image, 255, 255, 255); // Putih
        $barColor = imagecolorallocate($image, 0, 123, 255);          // Biru
        $textColor = imagecolorallocate($image, 0, 0, 0);             // Hitam

        // Isi background
        imagefilledrectangle($image, 0, 0, $width, $height, $backgroundColor);

        // Data untuk chart
        $categories = ['A', 'B', 'C', 'D', 'E']; // Kategori
        $values = [1, 3, 2, 5, 4];               // Nilai

        // Gambar bar chart
        $barWidth = ($width - 40) / count($values) - 20; // Lebar bar
        $maxValue = max($values); // Nilai maksimal untuk skala
        foreach ($values as $i => $value) {
            $x1 = 20 + $i * ($barWidth + 20);
            $x2 = $x1 + $barWidth;
            $y1 = $height - 20 - ($value / $maxValue) * ($height - 40);
            $y2 = $height - 20;

            // Gambar bar
            imagefilledrectangle($image, $x1, $y1, $x2, $y2, $barColor);

            // Tambahkan teks kategori
            imagestring($image, 5, $x1, $y2 + 5, $categories[$i], $textColor);
        }

        // Simpan sebagai PNG
        $tempPng = storage_path('app/temp_chart.png');
        imagepng($image, $tempPng); // Simpan di path storage
        imagedestroy($image);       // Hapus dari memory

        return $tempPng; // Return path ke file PNG
    }

    public function editSubmission(Form $form)
    {
        $formAccesses = FormAccess::where('form_id', $form->id)->get();

        $editAccess = $formAccesses->contains(function ($access) {
            return $access->user_id === auth()->id() &&
                ($access->position === 'Pimpinan' || strpos($access->position, 'PIC') !== false);
        });

        if (!$editAccess || $form->stage_id !== 1 || app('user_role') !== 'Auditee') {
            abort(403);
        }

        $submitAccess = $formAccesses->contains(function ($access) {
            return $access->user_id === auth()->id() && $access->position === 'Pimpinan';
        });

        $auditees = $formAccesses->filter(function ($access) {
            return $access->position === 'Pimpinan' || strpos($access->position, 'PIC') !== false;
        })->sortBy(function ($access) {
            return $access->position === 'Pimpinan' ? 0 : (intval(str_replace('PIC', '', $access->position)) ?: 1);
        });

        $auditors = $formAccesses->filter(function ($access) {
            return $access->position === 'Ketua' || strpos($access->position, 'Anggota') !== false;
        })->sortBy(function ($access) {
            return $access->position === 'Ketua' ? 0 : (intval(str_replace('Anggota', '', $access->position)) ?: 1);
        });

        $formAudits = FormAudit::with([
            'indicator.competency.standard.category'
        ])->where('form_id', $form->id)->get();

        $grouped = $formAudits->groupBy(function ($item) {
            return $item->indicator?->competency?->standard?->category?->id ?? null;
        });

        $statuses = Status::orderBy('id', 'desc')->get();

        return view('forms.edit-submission', compact('form', 'submitAccess', 'auditees', 'auditors', 'grouped', 'statuses'));
    }

    public function updateSubmission(Request $request, Form $form)
    {
        if ($request->input('action') === 'submit') {

            $indicators = $request->input('indicators');

            foreach ($indicators as $indicator) {
                $indicator = json_decode($indicator, true); // Mengubah JSON string menjadi array

                $code = $indicator['code'];

                Validator::make($indicator, [
                    "id" => 'required|integer|exists:form_audits,id',
                    "submission_status" => 'exclude_if:entry,Disable|required|integer|exists:statuses,id',
                    "validation" => 'exclude_if:entry,Disable|required|string',
                    "link" => 'exclude_if:entry,Disable|required|string',
                ])->setAttributeNames([
                    "submission_status" => "Audit {$code}",
                    "validation" => "Validation {$code}",
                    "link" => "Link {$code}",
                ])->validate();
            }

            FormTime::updateOrCreate(
                ['form_id' => $form->id],
                ['submission_time' => now()]
            );

            // Gunakan operator ternary untuk menentukan nilai berdasarkan tombol yang ditekan
            Form::updateOrCreate(
                ['id' => $form->id],
                ['stage_id' => 2]
            );

            return redirect('forms')->with('success', "Form {$form->unit->code} {$form->document->name} successfully submitted.");
        } else {

            $indicator = $request->input('indicator');

            // Update the FormAudit entry based on the provided indicator data
            FormAudit::updateOrCreate(
                ['id' => $indicator['id']], // Cari evaluasi berdasarkan ID
                [
                    'submission_status' => $indicator['submission_status'],
                    'validation' => $indicator['validation'],
                    'link' => $indicator['link'],
                ]
            );

            // Dispatch the event for the updated indicator
            FormUpdated::dispatch($form->id, $indicator, auth()->user()->name);

            return response()->json(['message' => "{$indicator['code']} successfully updated."]);
        }
    }

    public function editAssessment(Form $form)
    {
        $formAccesses = FormAccess::where('form_id', $form->id)->get();

        $editAccess = $formAccesses->contains(function ($access) {
            return $access->user_id === auth()->id() &&
                ($access->position === 'Ketua' || strpos($access->position, 'Anggota') !== false);
        });

        if (!$editAccess || $form->stage_id !== 2 || app('user_role') !== 'Auditor') {
            abort(403);
        }

        $submitAccess = $formAccesses->contains(function ($access) {
            return $access->user_id === auth()->id() && $access->position === 'Ketua';
        });

        $auditees = $formAccesses->filter(function ($access) {
            return $access->position === 'Pimpinan' || strpos($access->position, 'PIC') !== false;
        })->sortBy(function ($access) {
            return $access->position === 'Pimpinan' ? 0 : (intval(str_replace('PIC', '', $access->position)) ?: 1);
        });

        $auditors = $formAccesses->filter(function ($access) {
            return $access->position === 'Ketua' || strpos($access->position, 'Anggota') !== false;
        })->sortBy(function ($access) {
            return $access->position === 'Ketua' ? 0 : (intval(str_replace('Anggota', '', $access->position)) ?: 1);
        });

        $formAudits = FormAudit::with([
            'indicator.competency.standard.category'
        ])->where('form_id', $form->id)->get();

        $grouped = $formAudits->groupBy(function ($item) {
            return $item->indicator?->competency?->standard?->category?->id ?? null;
        });

        $statuses = Status::orderBy('id', 'desc')->get();

        return view('forms.edit-assessment', compact('form', 'submitAccess', 'auditees', 'auditors', 'grouped', 'statuses'));
    }

    public function updateAssessment(Request $request, Form $form)
    {
        if ($request->input('action') === 'submit') {

            $indicators = $request->input('indicators');

            foreach ($indicators as $indicator) {
                $indicator = json_decode($indicator, true); // Mengubah JSON string menjadi array

                $code = $indicator['code'];

                Validator::make($indicator, [
                    "id" => 'required|integer|exists:form_audits,id',
                    "assessment_status" => 'exclude_if:entry,Disable|required|integer|exists:statuses,id',
                    "description" => 'exclude_if:entry,Disable|nullable|string',
                ])->setAttributeNames([
                    "assessment_status" => "Audit {$code}",
                    "description" => "Description {$code}",
                ])->validate();
            }

            FormTime::updateOrCreate(
                ['form_id' => $form->id],
                ['assessment_time' => now()]
            );

            // Gunakan operator ternary untuk menentukan nilai berdasarkan tombol yang ditekan
            Form::updateOrCreate(
                ['id' => $form->id],
                ['stage_id' => 3]
            );

            return redirect('forms')->with('success', "Form {$form->unit->code} {$form->document->name} successfully submitted.");
        } else {

            $indicator = $request->input('indicator');

            // Update the FormAudit entry based on the provided indicator data
            FormAudit::updateOrCreate(
                ['id' => $indicator['id']], // Cari evaluasi berdasarkan ID
                [
                    'assessment_status' => $indicator['assessment_status'],
                    'description' => $indicator['description'],
                ]
            );

            // Dispatch the event for the updated indicator
            FormUpdated::dispatch($form->id, $indicator, auth()->user()->name);

            return response()->json(['message' => "{$indicator['code']} successfully updated."]);
        }
    }

    public function editFeedback(Form $form)
    {
        $formAccesses = FormAccess::where('form_id', $form->id)->get();

        $editAccess = $formAccesses->contains(function ($access) {
            return $access->user_id === auth()->id() &&
                ($access->position === 'Pimpinan' || strpos($access->position, 'PIC') !== false);
        });

        if (!$editAccess || $form->stage_id !== 3 || app('user_role') !== 'Auditee') {
            abort(403);
        }

        $submitAccess = $formAccesses->contains(function ($access) {
            return $access->user_id === auth()->id() && $access->position === 'Pimpinan';
        });

        $auditees = $formAccesses->filter(function ($access) {
            return $access->position === 'Pimpinan' || strpos($access->position, 'PIC') !== false;
        })->sortBy(function ($access) {
            return $access->position === 'Pimpinan' ? 0 : (intval(str_replace('PIC', '', $access->position)) ?: 1);
        });

        $auditors = $formAccesses->filter(function ($access) {
            return $access->position === 'Ketua' || strpos($access->position, 'Anggota') !== false;
        })->sortBy(function ($access) {
            return $access->position === 'Ketua' ? 0 : (intval(str_replace('Anggota', '', $access->position)) ?: 1);
        });

        $formAudits = FormAudit::with([
            'indicator.competency.standard.category'
        ])->where('form_id', $form->id)->get();

        $grouped = $formAudits->groupBy(function ($item) {
            return $item->indicator?->competency?->standard?->category?->id ?? null;
        });

        $statuses = Status::orderBy('id', 'desc')->get();

        return view('forms.edit-feedback', compact('form', 'submitAccess', 'auditees', 'auditors', 'grouped', 'statuses'));
    }

    public function updateFeedback(Request $request, Form $form)
    {
        if ($request->input('action') === 'submit') {

            $indicators = $request->input('indicators');

            foreach ($indicators as $indicator) {
                $indicator = json_decode($indicator, true); // Mengubah JSON string menjadi array

                $indicator['feedback'] = $indicator['feedback'] === "" ? 1 : $indicator['feedback'];
                $code = $indicator['code'];

                Validator::make($indicator, [
                    "id" => 'required|integer|exists:form_audits,id',
                    "validation" => 'exclude_if:entry,Disable|required|string',
                    "link" => 'exclude_if:entry,Disable|required|string',
                    "feedback" => 'exclude_if:entry,Disable|required|integer',
                    "comment" => 'exclude_if:entry,Disable|nullable|string',
                ])->setAttributeNames([
                    "validation" => "Validation {$code}",
                    "link" => "Link {$code}",
                    "feedback" => "Feedback {$code}",
                    "comment" => "Comment {$code}",
                ])->validate();

                FormAudit::updateOrCreate(
                    ['id' => $indicator['id']], // Cari evaluasi berdasarkan ID
                    [
                        'feedback' => $indicator['feedback'],
                    ]
                );
            }

            FormTime::updateOrCreate(
                ['form_id' => $form->id],
                ['feedback_time' => now()]
            );

            // Gunakan operator ternary untuk menentukan nilai berdasarkan tombol yang ditekan
            Form::updateOrCreate(
                ['id' => $form->id],
                ['stage_id' => 4]
            );

            return redirect('forms')->with('success', "Form {$form->unit->code} {$form->document->name} successfully submitted.");
        } else {

            $indicator = $request->input('indicator');

            // Update the FormAudit entry based on the provided indicator data
            FormAudit::updateOrCreate(
                ['id' => $indicator['id']], // Cari evaluasi berdasarkan ID
                [
                    'validation' => $indicator['validation'],
                    'link' => $indicator['link'],
                    'feedback' => $indicator['feedback'],
                    'comment' => $indicator['comment'],
                ]
            );

            // Dispatch the event for the updated indicator
            FormUpdated::dispatch($form->id, $indicator, auth()->user()->name);

            return response()->json(['message' => "{$indicator['code']} successfully updated."]);
        }
    }

    public function editVerification(Form $form)
    {
        $formAccesses = FormAccess::where('form_id', $form->id)->get();

        $editAccess = $formAccesses->contains(function ($access) {
            return $access->user_id === auth()->id() &&
                ($access->position === 'Ketua' || strpos($access->position, 'Anggota') !== false);
        });

        if (!$editAccess || $form->stage_id !== 4 || app('user_role') !== 'Auditor') {
            abort(403);
        }

        $submitAccess = $formAccesses->contains(function ($access) {
            return $access->user_id === auth()->id() && $access->position === 'Ketua';
        });

        $auditees = $formAccesses->filter(function ($access) {
            return $access->position === 'Pimpinan' || strpos($access->position, 'PIC') !== false;
        })->sortBy(function ($access) {
            return $access->position === 'Pimpinan' ? 0 : (intval(str_replace('PIC', '', $access->position)) ?: 1);
        });

        $auditors = $formAccesses->filter(function ($access) {
            return $access->position === 'Ketua' || strpos($access->position, 'Anggota') !== false;
        })->sortBy(function ($access) {
            return $access->position === 'Ketua' ? 0 : (intval(str_replace('Anggota', '', $access->position)) ?: 1);
        });

        $formAudits = FormAudit::with([
            'indicator.competency.standard.category'
        ])->where('form_id', $form->id)->get();

        $grouped = $formAudits->groupBy(function ($item) {
            return $item->indicator?->competency?->standard?->category?->id ?? null;
        });

        $statuses = Status::orderBy('id', 'desc')->get();

        return view('forms.edit-verification', compact('form', 'submitAccess', 'auditees', 'auditors', 'grouped', 'statuses'));
    }

    public function updateVerification(Request $request, Form $form)
    {
        if ($request->input('action') === 'submit') {

            $indicators = $request->input('indicators');

            foreach ($indicators as $indicator) {
                $indicator = json_decode($indicator, true); // Mengubah JSON string menjadi array

                $code = $indicator['code'];

                Validator::make($indicator, [
                    "id" => 'required|integer|exists:form_audits,id',
                    "verification_status" => 'exclude_if:entry,Disable|required|integer|exists:statuses,id',
                    "conclusion" => 'exclude_if:entry,Disable|required|string',
                ])->setAttributeNames([
                    "verification_status" => "Audit {$code}",
                    "conclusion" => "Conclusion {$code}",
                ])->validate();
            }

            FormTime::updateOrCreate(
                ['form_id' => $form->id],
                ['verification_time' => now()]
            );

            // Gunakan operator ternary untuk menentukan nilai berdasarkan tombol yang ditekan
            Form::updateOrCreate(
                ['id' => $form->id],
                ['stage_id' => 5]
            );

            return redirect('forms')->with('success', "Form {$form->unit->code} {$form->document->name} successfully submitted.");
        } else {

            $indicator = $request->input('indicator');

            // Update the FormAudit entry based on the provided indicator data
            FormAudit::updateOrCreate(
                ['id' => $indicator['id']], // Cari evaluasi berdasarkan ID
                [
                    'verification_status' => $indicator['verification_status'],
                    'conclusion' => $indicator['conclusion'],
                ]
            );

            // Dispatch the event for the updated indicator
            FormUpdated::dispatch($form->id, $indicator, auth()->user()->name);

            return response()->json(['message' => "{$indicator['code']} successfully updated."]);
        }
    }
}
