<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\Unit;
use App\Models\User;
use App\Models\Status;
use App\Models\Category;
use App\Models\Document;
use App\Models\Standard;
use App\Models\FormAudit;
use App\Models\Indicator;
use App\Models\Competency;
use App\Models\FormAccess;
use App\Events\FormUpdated;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FormSubmission;

class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (app('user_role') === 'PJM') {
            // Jika pengguna masuk sebagai admin, ambil semua formulir
            $forms = Form::all();
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
        $statuses = Status::orderBy('id', 'desc')->get();

        $formAudits = FormAudit::with([
            'indicator.competency.standard.category'
        ])->where('form_id', $form->id)->get();

        // Kelompokkan data berdasarkan ID kategori, standar, kompetensi, dan indikator
        $grouped = $formAudits->groupBy(function ($item) {
            return $item->indicator->competency->standard->category->id;
        });
        
        $formAccesses = FormAccess::where('form_id', $form->id)->get();

        return view('forms.show', compact('statuses', 'form', 'formAccesses', 'grouped'));
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

    public function editSubmission(Form $form)
    {
        $userAccesses = FormAccess::where('form_id', $form->id)
            ->where('user_id', auth()->id())->get();

        $statuses = Status::orderBy('id', 'desc')->get();

        $formAudits = FormAudit::with([
            'indicator.competency.standard.category'
        ])->where('form_id', $form->id)->get();

        // Kelompokkan data berdasarkan ID kategori, standar, kompetensi, dan indikator
        $grouped = $formAudits->groupBy(function ($item) {
            return $item->indicator->competency->standard->category->id;
        });
        
        $formAccesses = FormAccess::where('form_id', $form->id)->get();

        return view('forms.edit-submission', compact('statuses', 'form', 'formAccesses', 'userAccesses', 'grouped'));
    }

    public function updateSubmission(Request $request, Form $form)
    {
        // broadcast(new FormUpdated($request->all()));
        // FormUpdated::dispatch($request->all());
        // dd($request->all());
        // Validasi input untuk evaluasi
        $validatedData = $request->validate([
            'audits.*.id' => 'required|integer|exists:form_audits,id',
            'audits.*.status' => 'nullable|integer|exists:statuses,id',
            'audits.*.validation' => 'nullable|string',
            'audits.*.link' => 'nullable|string',
        ]);

        // Gunakan operator ternary untuk menentukan nilai berdasarkan tombol yang ditekan
        Form::updateOrCreate(
            ['id' => $form->id], // Kondisi untuk mencari form
            [
                'stage_id' => $request->input('action') === 'draft' ? 1 : 2,
            ]
        );
        
        FormSubmission::updateOrCreate(
            ['form_id' => $form->id], // Kondisi untuk mencari form
            [
                'submission' => $request->input('action') === 'draft' ? null : now(),
            ]
        );

        // Update evaluasi seperti sebelumnya menggunakan updateOrCreate
        foreach ($validatedData['audits'] as $auditData) {
            FormAudit::updateOrCreate(
                ['id' => $auditData['id']], // Cari evaluasi berdasarkan ID
                [
                    'submission_status' => $auditData['status'] ?? null,
                    'validation' => $auditData['validation'] ?? null,
                    'link' => $auditData['link'] ?? null,
                ]
            );
        }

        // Redirect setelah semua perubahan tersimpan
        return redirect('forms')->with('status', 'Form berhasil diperbarui.');
    }

    public function editAsessment(Form $form)
    {
        $statuses = Status::orderBy('id', 'desc')->get();

        $userAccesses = FormAccess::where('form_id', $form->id)
            ->where('user_id', auth()->id())->get();

        $formAudits = FormAudit::with([
            'indicator.competency.standard.category'
        ])->where('form_id', $form->id)->get();

        // Kelompokkan data berdasarkan ID kategori, standar, kompetensi, dan indikator
        $grouped = $formAudits->groupBy(function ($item) {
            return $item->indicator->competency->standard->category->id;
        });

        $formAccesses = FormAccess::where('form_id', $form->id)->get();

        return view('forms.edit-asessment', compact('statuses', 'form','userAccesses', 'formAccesses', 'grouped'));
    }

    public function updateAsessment(Request $request, Form $form)
    {
        // Validasi input untuk evaluasi
        $validatedData = $request->validate([
            'evaluations.*.id' => 'required|integer|exists:form_audits,id',
            'evaluations.*.status' => 'nullable|integer|exists:statuses,id',
            'evaluations.*.description' => 'nullable|string',
        ]);

        // Gunakan operator ternary untuk menentukan nilai berdasarkan tombol yang ditekan
        Form::updateOrCreate(
            ['id' => $form->id], // Kondisi untuk mencari form
            [
                'stage_id' => $request->input('action') === 'draft' ? 2 : 3,
            ]
        );
        
        FormSubmission::updateOrCreate(
            ['form_id' => $form->id], // Kondisi untuk mencari form
            [
                'assessment' => $request->input('action') === 'draft' ? null : now(),
            ]
        );

        // Update evaluasi seperti sebelumnya menggunakan updateOrCreate
        foreach ($validatedData['evaluations'] as $evaluationData) {
            FormAudit::updateOrCreate(
                ['id' => $evaluationData['id']], // Cari evaluasi berdasarkan ID
                [
                    'assessment_status' => $evaluationData['status'] ?? null,
                    'description' => $evaluationData['description'] ?? null,
                ]
            );
        }

        // Redirect setelah semua perubahan tersimpan
        return redirect('forms')->with('status', 'Form berhasil diperbarui.');
    }
    
    public function editFeedback(Form $form)
    {
        $statuses = Status::orderBy('id', 'desc')->get();

        $userAccesses = FormAccess::where('form_id', $form->id)
            ->where('user_id', auth()->id())->get();

        $formAudits = FormAudit::with([
            'indicator.competency.standard.category'
        ])->where('form_id', $form->id)->get();

        // Kelompokkan data berdasarkan ID kategori, standar, kompetensi, dan indikator
        $grouped = $formAudits->groupBy(function ($item) {
            return $item->indicator->competency->standard->category->id;
        });

        $formAccesses = FormAccess::where('form_id', $form->id)->get();

        return view('forms.edit-feedback', compact('statuses', 'form','userAccesses', 'formAccesses', 'grouped'));
    }

    public function updateFeedback(Request $request, Form $form)
    {
        // Validasi input untuk evaluasi
        $validatedData = $request->validate([
            'feedbacks.*.id' => 'required|integer|exists:form_audits,id',
            'feedbacks.*.feedback' => 'nullable',
            'feedbacks.*.comment' => 'nullable|string',
        ]);

        // Gunakan operator ternary untuk menentukan nilai berdasarkan tombol yang ditekan
        Form::updateOrCreate(
            ['id' => $form->id], // Kondisi untuk mencari form
            [
                'stage_id' => $request->input('action') === 'draft' ? 3 : 4,
            ]
        );
        
        FormSubmission::updateOrCreate(
            ['form_id' => $form->id], // Kondisi untuk mencari form
            [
                'feedback' => $request->input('action') === 'draft' ? null : now(),
            ]
        );

        // Update evaluasi seperti sebelumnya menggunakan updateOrCreate
        foreach ($validatedData['feedbacks'] as $feedbackData) {
            FormAudit::updateOrCreate(
                ['id' => $feedbackData['id']], // Cari evaluasi berdasarkan ID
                [
                    'feedback' => $feedbackData['feedback'] ?? null,
                    'comment' => $feedbackData['comment'] ?? null,
                ]
            );
        }

        // Redirect setelah semua perubahan tersimpan
        return redirect('forms')->with('status', 'Form berhasil diperbarui.');
    }
    
    public function editVerification(Form $form)
    {
        $statuses = Status::orderBy('id', 'desc')->get();

        $userAccesses = FormAccess::where('form_id', $form->id)
            ->where('user_id', auth()->id())->get();

        $formAudits = FormAudit::with([
            'indicator.competency.standard.category'
        ])->where('form_id', $form->id)->get();

        // Kelompokkan data berdasarkan ID kategori, standar, kompetensi, dan indikator
        $grouped = $formAudits->groupBy(function ($item) {
            return $item->indicator->competency->standard->category->id;
        });

        $formAccesses = FormAccess::where('form_id', $form->id)->get();

        return view('forms.edit-verification', compact('statuses', 'form','userAccesses', 'formAccesses', 'grouped'));
    }

    public function updateVerification(Request $request, Form $form)
    {
        // Validasi input untuk evaluasi
        $validatedData = $request->validate([
            'verifications.*.id' => 'required|integer|exists:form_audits,id',
            'verifications.*.status' => 'nullable|integer|exists:statuses,id',
            'verifications.*.conclusion' => 'nullable|string',
        ]);

        // Gunakan operator ternary untuk menentukan nilai berdasarkan tombol yang ditekan
        Form::updateOrCreate(
            ['id' => $form->id], // Kondisi untuk mencari form
            [
                'stage_id' => $request->input('action') === 'draft' ? 4 : 5,
            ]
        );
        
        FormSubmission::updateOrCreate(
            ['form_id' => $form->id], // Kondisi untuk mencari form
            [
                'verification' => $request->input('action') === 'draft' ? null : now(),
            ]
        );

        // Update evaluasi seperti sebelumnya menggunakan updateOrCreate
        foreach ($validatedData['verifications'] as $verificationData) {
            FormAudit::updateOrCreate(
                ['id' => $verificationData['id']], // Cari evaluasi berdasarkan ID
                [
                    'verification_status' => $verificationData['status'] ?? null,
                    'conclusion' => $verificationData['conclusion'] ?? null,
                ]
            );
        }

        // Redirect setelah semua perubahan tersimpan
        return redirect('forms')->with('status', 'Form berhasil diperbarui.');
    }
}
