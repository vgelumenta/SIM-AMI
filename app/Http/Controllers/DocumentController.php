<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Document;
use App\Models\Standard;
use App\Models\Indicator;
use App\Models\Competency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $documents = Document::with(['forms'])->get();

        foreach ($documents as $document) {

            $canBeDeleted = true;

            if ($document->forms->isNotEmpty()) {
                $canBeDeleted = false;
            }

            $document->can_be_deleted = $canBeDeleted;
        }

        // Mengambil semua file JSON dari folder public
        $drafts = collect(Storage::files('public/drafts'))
            ->filter(fn($file) => pathinfo($file, PATHINFO_EXTENSION) === 'json')
            ->map(fn($file) => pathinfo($file, PATHINFO_FILENAME))
            ->sortByDesc(fn($file) => filectime(storage_path('app/public/drafts/' . $file . '.json')))
            ->diff($documents->pluck('name')) // Ganti 'name' dengan properti yang sesuai dari model Document
            ->values(); // Mengembalikan array yang terurut

        return view('documents.index', compact('documents', 'drafts'));
    }

    // public function index()
    // {
    //     // Eager loading dengan relasi forms dan formEvaluations
    //     $documents = Document::with(['forms.formEvaluations'])->get();

    //     // Menambahkan flag `can_be_edited` ke setiap dokumen
    //     foreach ($documents as $document) {
    //         $canBeEdited = true; // Default bisa diubah

    //         // Loop melalui setiap form terkait dokumen
    //         foreach ($document->forms as $form) {
    //             // Cek apakah ada form evaluation dengan validasi yang sudah diisi (tidak null)
    //             if ($form->formEvaluations->whereNotNull('evaluation_status')->isNotEmpty()) {
    //                 $canBeEdited = false;
    //                 break; // Jika ditemukan satu saja, tidak bisa di-edit
    //             }
    //         }

    //         // Tambahkan properti `can_be_edited` ke dokumen
    //         $document->can_be_edited = $canBeEdited;
    //     }

    //     // Mengambil semua file JSON dari folder public
    //     $drafts = collect(Storage::files('public'))
    //         ->filter(fn($file) => pathinfo($file, PATHINFO_EXTENSION) === 'json')
    //         ->map(fn($file) => pathinfo($file, PATHINFO_FILENAME))
    //         ->diff($documents->pluck('name')) // Ganti 'name' dengan properti yang sesuai dari model Document
    //         ->sortByDesc(fn($file) => filectime(storage_path('app/public/' . $file . '.json')))
    //         ->values(); // Mengembalikan array yang terurut

    //     return view('documents.index', compact('documents', 'drafts'));
    // }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // Ambil nama file JSON dari folder drafts yang memiliki ekstensi .json dan ada di tabel documents
        $drafts = collect(Storage::files('public/drafts/'))
            ->filter(fn($file) => pathinfo($file, PATHINFO_EXTENSION) === 'json')
            ->map(fn($file) => pathinfo($file, PATHINFO_FILENAME))
            ->sortByDesc(fn($file) => Storage::lastModified("public/drafts/{$file}.json"))
            ->values();

        // Pilih file yang dipilih pengguna, atau gunakan file terbaru jika tidak ada
        $template = $request->input('template', $drafts->first());

        // Jika tidak ada file atau file tidak ditemukan, gunakan nilai default
        if (!$template || !Storage::exists("public/drafts/{$template}.json")) {

            $categories = $standardsByCategory = $competenciesByStandard = $indicatorsByCompetency = [];
        } else {
            // Ambil data dari file JSON yang valid
            $data = json_decode(Storage::get("public/drafts/{$template}.json"), true);

            // Ambil kategori, standar, kompetensi, dan indikator dari data JSON
            $categories = collect($data['categories'] ?? []);
            $standards = collect($data['standards'] ?? []);
            $competencies = collect($data['competencies'] ?? []);
            $indicators = collect($data['indicators'] ?? []);

            // Kelompokkan standar, kompetensi, dan indikator berdasarkan id
            $standardsByCategory = $standards->groupBy('category_id');
            $competenciesByStandard = $competencies->groupBy('standard_id');
            $indicatorsByCompetency = $indicators->groupBy('competency_id');
        }

        // Mengirim data ke view
        return view('documents.create', compact(
            'template',
            'drafts',
            'categories',
            'standardsByCategory',
            'competenciesByStandard',
            'indicatorsByCompetency'
        ));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $categories = $request->input('categories', []);
        $document_name = $request->input('document_name');

        $data = [
            'categories' => [],
            'standards' => [],
            'competencies' => [],
            'indicators' => [],
        ];

        foreach ($categories as $categoryData) {

            $data['categories'][] = [
                'id' => (int) $categoryData['id'],
                'name' => $categoryData['name'],
            ];

            if (isset($categoryData['standards'])) {
                foreach ($categoryData['standards'] as $standardData) {

                    $data['standards'][] = [
                        'id' => (int) $standardData['id'],
                        'category_id' => (int) $standardData['category_id'],
                        'name' => $standardData['name'],
                    ];

                    if (isset($standardData['competencies'])) {
                        foreach ($standardData['competencies'] as $competencyData) {

                            $data['competencies'][] = [
                                'id' => (int) $competencyData['id'],
                                'standard_id' => (int) $competencyData['standard_id'],
                                'name' => $competencyData['name'],
                            ];

                            if (isset($competencyData['indicators'])) {
                                foreach ($competencyData['indicators'] as $indicatorData) {

                                    $data['indicators'][] = [
                                        'id' => (int) $indicatorData['id'],
                                        'competency_id' => (int) $indicatorData['competency_id'],
                                        'assessment' => $indicatorData['assessment'],
                                        'code' => $indicatorData['code'],
                                        'entry' => $indicatorData['entry'],
                                        'link_info' => $indicatorData['link_info'],
                                        'rate_option' => $indicatorData['rate_option'] ?? null,
                                    ];
                                }
                            }
                        }
                    }
                }
            }
        }

        Storage::put('public/drafts/' . $document_name . '.json', json_encode($data, JSON_PRETTY_PRINT));

        if ($request->input('action') === 'draft') {

            return redirect('/documents#drafts')->with('success', $document_name . ' saved as draft!');
            
        } elseif ($request->input('action') === 'submit') {

            $validator = Validator::make($request->all(), [
                'document_name' => 'required|string|unique:documents,name',
                'categories' => 'required|array',
                'categories.*.id' => 'nullable|integer',
                'categories.*.name' => 'required|string',
                'categories.*.standards' => 'nullable|array',
                'categories.*.standards.*.id' => 'nullable|integer',
                'categories.*.standards.*.category_id' => 'required|integer',
                'categories.*.standards.*.name' => 'required|string',
                'categories.*.standards.*.competencies' => 'nullable|array',
                'categories.*.standards.*.competencies.*.id' => 'nullable|integer',
                'categories.*.standards.*.competencies.*.standard_id' => 'required|string',
                'categories.*.standards.*.competencies.*.name' => 'required|string',
                'categories.*.standards.*.competencies.*.indicators' => 'nullable|array',
                'categories.*.standards.*.competencies.*.indicators.*.id' => 'nullable|integer',
                'categories.*.standards.*.competencies.*.indicators.*.competency_id' => 'required|integer',
                'categories.*.standards.*.competencies.*.indicators.*.assessment' => 'required|string',
                'categories.*.standards.*.competencies.*.indicators.*.code' => 'required|string',
                'categories.*.standards.*.competencies.*.indicators.*.entry' => 'required|string',
                'categories.*.standards.*.competencies.*.indicators.*.link_info' => 'nullable|string',
                'categories.*.standards.*.competencies.*.indicators.*.rate_option' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $document = Document::create([
                'name' => $document_name,
                'code' => now()
            ]);

            foreach ($categories as $categoryData) {
                $category = Category::create([
                    'document_id' => $document->id,
                    'name' => $categoryData['name'],
                ]);

                if (isset($categoryData['standards'])) {
                    foreach ($categoryData['standards'] as $standardData) {
                        $standard = Standard::create([
                            'category_id' => $category->id,
                            'name' => $standardData['name'],
                        ]);

                        if (isset($standardData['competencies'])) {
                            foreach ($standardData['competencies'] as $competencyData) {
                                $competency = Competency::create([
                                    'standard_id' => $standard->id,
                                    'name' => $competencyData['name'],
                                ]);

                                if (isset($competencyData['indicators'])) {
                                    foreach ($competencyData['indicators'] as $indicatorData) {
                                        Indicator::create([
                                            'competency_id' => $competency->id,
                                            'assessment' => $indicatorData['assessment'],
                                            'code' => $indicatorData['code'],
                                            'entry' => $indicatorData['entry'],
                                            'link_info' => $indicatorData['link_info'],
                                            'rate_option' => $indicatorData['rate_option'] ?? null,
                                        ]);
                                    }
                                }
                            }
                        }
                    }
                }
            }

            return redirect('/documents')->with('success', $document_name . ' created!');
        }
    }

    /**
     * Display the specified resource.
     */
    // public function show($filename)
    // {
    //     // Tambahkan ekstensi .json jika belum ada
    //     if (pathinfo($filename, PATHINFO_EXTENSION) !== 'json') {
    //         $filename .= '.json';
    //     }

    //     // Ambil path lengkap dari file JSON berdasarkan nama file
    //     $path = storage_path("app/public/{$filename}");

    //     // Cek apakah file ada
    //     if (!File::exists($path)) {
    //         abort(404, 'File not found');
    //     }

    //     // Ambil data dari file JSON
    //     $file = File::get($path);
    //     $data = json_decode($file, true);

    //     // Ambil kategori, standar, kompetensi, dan indikator
    //     $categories = $data['categories'];
    //     $standards = $data['standards'];
    //     $competencies = $data['competencies'];
    //     $indicators = $data['indicators'];

    //     // Kelompokkan standar berdasarkan category_id
    //     $standardsByCategory = collect($standards)->groupBy('category_id');

    //     // Kelompokkan kompetensi berdasarkan standard_id
    //     $competenciesByStandard = collect($competencies)->groupBy('standard_id');

    //     // Kelompokkan indikator berdasarkan competency_id
    //     $indicatorsByCompetency = collect($indicators)->groupBy('competency_id');

    //     // Tampilkan view dengan data yang diambil
    //     return view('documents.show1', compact('filename', 'categories', 'standardsByCategory', 'competenciesByStandard', 'indicatorsByCompetency'));
    // }
    public function show(Document $document)
    {
        $categories = Category::where('document_id', $document->id)->get();

        $standards = Standard::whereIn('category_id', $categories->pluck('id'))->get();

        $competencies = Competency::whereIn('standard_id', $standards->pluck('id'))->get();

        $indicators = Indicator::whereIn('competency_id', $competencies->pluck('id'))->get();

        $standardsByCategory = $standards->groupBy('category_id');

        $competenciesByStandard = $competencies->groupBy('standard_id');

        $indicatorsByCompetency = $indicators->groupBy('competency_id');

        return view('documents.show', compact('document', 'categories', 'standardsByCategory', 'competenciesByStandard', 'indicatorsByCompetency'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('documents.edit');
    }
    
    public function editDraft($draft)
    {
        $filePath = 'public/drafts/' . $draft . '.json';
        
        $data = json_decode(Storage::get($filePath), true);

            // Ambil kategori, standar, kompetensi, dan indikator dari data JSON
            $categories = collect($data['categories'] ?? []);
            $standards = collect($data['standards'] ?? []);
            $competencies = collect($data['competencies'] ?? []);
            $indicators = collect($data['indicators'] ?? []);

            // Kelompokkan standar, kompetensi, dan indikator berdasarkan id
            $standardsByCategory = $standards->groupBy('category_id');
            $competenciesByStandard = $competencies->groupBy('standard_id');
            $indicatorsByCompetency = $indicators->groupBy('competency_id');
            
            return view('documents.edit-draft', compact('draft', 'categories', 'standardsByCategory', 'competenciesByStandard', 'indicatorsByCompetency'));
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
    public function destroy(Document $document)
    {
        Document::destroy($document->id);

        $filePath = 'public/drafts/' . $document->name . '.json';

        Storage::delete($filePath);

        return redirect('/documents')->with('status', 'File berhasil dihapus.');
    }

    public function destroyDraft($draft)
    {
        $filePath = 'public/drafts/' . $draft . '.json';

        Storage::delete($filePath);

        return redirect('/documents#drafts')->with('status', 'File berhasil dihapus.');
    }
}
